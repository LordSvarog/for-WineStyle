<?php
require_once "Model.php";

/**
 * Основной класс Модели, которая работает с таблицами
 * Class IndexModel
 */
class IndexModel extends Model
{

    public function checkTable ()
    {
        $table = 'workers';

        $sql = "SHOW TABLES LIKE :workers";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":workers",$table, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_NUM);

        return $res;
    }
    /**
     * Получаем данные работников
     * @param $month
     * @return array
     */
    public function getWorkers($month)
    {
        $sql = "SELECT w.id, w.photo, w.first_name, w.last_name, pr.title, p.salary
                    FROM `workers` w
                    LEFT JOIN `professions` pr ON w.position_id = pr.id
                    LEFT JOIN `payment` p ON w.id = p.workers_id AND p.month = :month
                    ORDER BY w.id
                ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":month", $month, PDO::PARAM_INT);
        $stmt->execute();

        $workers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $workers;
    }

    /**
     * Получаем зарплаты работников за выбранный месяц
     * @param $month
     * @return array
     */
    public function getSalary($month)
    {
        $sql = "SELECT workers_id, salary
                    FROM `payment`
                    WHERE month = :month
                    ORDER BY workers_id
                ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":month", $month, PDO::PARAM_INT);
        $stmt->execute();

        $salary = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $salary[$row['workers_id']] = $row['salary'];
        }

        return $salary;
    }
    /**
     * Получение профессий сотрудников
     * @return array
     */
    public function getPositions ()
    {
        $sql = "SELECT * FROM `professions`
                  ORDER BY id
                ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $positions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $positions[$row['id']] = $row['title'];
        }

        return $positions;
    }

    /**
     * Сохранение премии
     * @param $month
     * @param $posId
     * @param $bonus
     * @return bool
     */
    public function saveBonus($month, $posId, $bonus)
    {
        $sql = "SELECT id FROM `workers`
                  WHERE position_id = :posId
                ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":posId", $posId, PDO::PARAM_INT);
        $stmt->execute();

        $ids = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ids[] = $row['id'];
        }

        $sql2 = "UPDATE `payment`
                    SET salary = salary + :bonus
                    WHERE month = :month AND workers_id = :id
                ";
        $stmt = $this->db->prepare($sql2);

        foreach ($ids as $id) {
            $stmt->bindParam(":bonus", $bonus, PDO::PARAM_INT);
            $stmt->bindParam(":month", $month, PDO::PARAM_INT);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if (!$stmt->execute())
                return false;
        }
        return true;
    }
}