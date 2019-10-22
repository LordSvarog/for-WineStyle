<?php
require_once "Model.php";

class CreateModel extends Model
{
    /**
     * Создаём таблицы в базе
     */
    public function createTables()
    {
        try{
            $this->db->beginTransaction();

            $sql1 = "CREATE TABLE `professions`
                    (
                        id int unsigned auto_increment,
                        title varchar(250) default '' NOT NULL,
                        CONSTRAINT professions_pk
                        PRIMARY KEY (id)
                    )
                    comment 'Справочник профессий'
                    ";
            $sql2 = "CREATE TABLE `workers`
                    (
                        id int unsigned auto_increment,
                        first_name varchar(255) NOT NULL,
                        last_name varchar(255) NOT NULL,
                        position_id int unsigned NOT NULL,
                        pay_rate int unsigned default 20000 NOT NULL,
                        photo varchar(255) NULL,
                        CONSTRAINT workers_pk
                            PRIMARY KEY (id),
                        CONSTRAINT workers_professions_id_fk
                            FOREIGN KEY (position_id) REFERENCES `professions` (id)
                                ON DELETE CASCADE
                    )
                    comment 'Таблица работников'
                    ";
            $sql3 = "CREATE INDEX position_id
                        ON `workers` (position_id)
                    ";
            $sql4 = "CREATE TABLE `payment`
                    (
                        id int unsigned auto_increment,
                        month varchar(100) NOT NULL,
                        workers_id int unsigned NOT NULL,
                        salary int unsigned default 20000 NOT NULL,
                        CONSTRAINT payment_pk
                            PRIMARY KEY (id),
                        CONSTRAINT payment_workers_id_fk
                            FOREIGN KEY (workers_id) REFERENCES `workers` (id)
                                ON DELETE CASCADE
                    )
                    comment 'Таблица выплат'
                    ";
            $sql5 = "CREATE INDEX workers_id
                        ON `payment` (workers_id)
                    ";

            $this->db->exec($sql1);
            $this->db->exec($sql2);
            $this->db->exec($sql3);
            $this->db->exec($sql4);
            $this->db->exec($sql5);

            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();

            return false;
        }
    }
    /**
     * Заполняем таблицу `professions`
     */
    public function addProfessions()
    {
        $positions = ['бухгалтер', 'курьер', 'менеджер'];
        try {
            $this->db->beginTransaction();

            foreach ($positions as $position) {
                $sql = "INSERT INTO `professions`(title)
                            VALUES (:title)
                        ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":title", $position, PDO::PARAM_STR);

                $stmt->execute();
            }
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();

            return false;
        }
    }
    /**
     * Заполняем таблицу `workers`
     */
    public function addWorkers()
    {
        $workers = [];
        $workers[] = ['first_name' => 'Сергей', 'last_name' => 'Рокатов', 'position' => 3, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/1.jpg'];
        $workers[] = ['first_name' => 'Анжелика', 'last_name' => 'Оранова', 'position' => 1, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/2.jpg'];
        $workers[] = ['first_name' => 'Иван', 'last_name' => 'Арбенин', 'position' => 2, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/3.jpg'];
        $workers[] = ['first_name' => 'Анатолий', 'last_name' => 'Платонов', 'position' => 3, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/4.jpg'];
        $workers[] = ['first_name' => 'Иван', 'last_name' => 'Сергеев', 'position' => 2, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/5.jpg'];
        $workers[] = ['first_name' => 'Ольга', 'last_name' => 'Казанцева', 'position' => 1, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/6.jpg'];
        $workers[] = ['first_name' => 'Геннадий', 'last_name' => 'Ильин', 'position' => 3, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/7.jpg'];
        $workers[] = ['first_name' => 'Игорь', 'last_name' => 'Букин', 'position' => 2, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/8.jpg'];
        $workers[] = ['first_name' => 'Олег', 'last_name' => 'Григорьев', 'position' => 2, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/9.jpg'];
        $workers[] = ['first_name' => 'Иван', 'last_name' => 'Сидоров', 'position' => 2, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/10.jpg'];
        $workers[] = ['first_name' => 'Николай', 'last_name' => 'Алевтинов', 'position' => 3, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/11.jpg'];
        $workers[] = ['first_name' => 'Наталья', 'last_name' => 'Мелехова', 'position' => 3, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/12.jpg'];
        $workers[] = ['first_name' => 'Виктория', 'last_name' => 'Олейникова', 'position' => 1, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/13.jpg'];
        $workers[] = ['first_name' => 'Валентин', 'last_name' => 'Носиков', 'position' => 3, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/14.jpg'];
        $workers[] = ['first_name' => 'Анна', 'last_name' => 'Пригожина', 'position' => 3, 'pay_rate' => $this->getPayRate(), 'photo' => '/images/minimages/15.jpg'];

        try {
            $this->db->beginTransaction();

            foreach ($workers as $worker) {
                $sql = "INSERT INTO `workers`(first_name, last_name, position_id, pay_rate, photo)
                            VALUES (:f_name, :l_name, :pos, :rate, :photo)
                        ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":f_name", $worker['first_name'], PDO::PARAM_STR);
                $stmt->bindParam(":l_name", $worker['last_name'], PDO::PARAM_STR);
                $stmt->bindParam(":pos", $worker['position'], PDO::PARAM_INT);
                $stmt->bindParam(":rate", $worker['pay_rate'], PDO::PARAM_INT);
                $stmt->bindParam(":photo", $worker['photo'], PDO::PARAM_STR);

                $stmt->execute();
            }
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();

            return false;
        }
    }
    /**
     * Заполняем таблицу `payment`
     */
    public function addPayments()
    {
        $sql = "SELECT id, pay_rate FROM `workers`";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $rates = $stmt->fetchAll(PDO::FETCH_ASSOC);
        try {
            $this->db->beginTransaction();

            for ($i = 1; $i <= 12; ++$i) {
                foreach ($rates as $rate) {
                    $sql = "INSERT INTO `payment`(month, workers_id, salary)
                                VALUES (:month, :id, :rate)
                            ";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(":month", $i, PDO::PARAM_INT);
                    $stmt->bindParam(":id", $rate['id'], PDO::PARAM_INT);
                    $stmt->bindParam(":rate", $rate['pay_rate'], PDO::PARAM_INT);

                    $stmt->execute();
                }
            }
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();

            return false;
        }
    }
    /**
     * Генерируем случайную зарплату
     * @return int
     */
    private function getPayRate()
    {
        $number = rand(25000, 150000);
        $new_number = substr_replace((string)$number, '00', -2);
        return (int)$new_number;
    }
}