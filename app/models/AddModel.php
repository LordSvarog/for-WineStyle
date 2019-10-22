<?php
require_once "Model.php";

/**
 * класс Модели для добавления нового сотрудника
 * Class IndexModel
 */
class AddModel extends Model
{
    /**
     * Сохраняем нового сотрудника
     *
     * @param $firstName
     * @param $lastName
     * @param $positionId
     * @param $payRate
     * @param $photo
     * @return bool
     */
    public function registerNewWorker($firstName, $lastName, $positionId, $payRate, $photo)
    {
        $sql = "INSERT INTO `workers` (first_name, last_name, position_id, pay_rate, photo)
                    VALUES (:firstName, :lastName, :positionId, :payRate, :photo)
            ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":firstName", $firstName, PDO::PARAM_STR);
        $stmt->bindParam(":lastName", $lastName, PDO::PARAM_STR);
        $stmt->bindParam(":positionId", $positionId, PDO::PARAM_INT);
        $stmt->bindParam(":payRate", $payRate, PDO::PARAM_INT);
        $stmt->bindParam(":photo", $photo, PDO::PARAM_STR);
        $res = $stmt->execute();

        return $res;
    }

    /**
     * Сохраняем фото сотрудника
     * @param $picPath
     * @param $id
     * @return bool
     */
    public function setPic($picPath, $id)
    {
        $sql = "UPDATE `workers`
                  SET photo = :photo
                  WHERE id = :id
                ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":photo", $picPath, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $res = $stmt->execute();

        return $res;
    }
}