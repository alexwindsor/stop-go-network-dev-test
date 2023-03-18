<?php

namespace App\Database;

use App\Database\Connection;

class DbSetup
{

    private $employees;

    public function __construct() {

        $this->createEmployees();
        $this->createDbTables();
        $this->seedDatabase();
        $this->showEmployees();

    }

    public function createEmployees() {
        $this->employees = [
            ['first_name' => 'Julius', 'last_name' => 'Caesar', 'rfid_number' => '142594708f3a5a3ac2980914a0fc954f'],
            ['first_name' => 'Tiberius', 'last_name' => 'Augustus'],
            ['first_name' => 'Gaius', 'last_name' => 'Germanicus'],
            ['first_name' => 'Publius', 'last_name' => 'Pertinax'],
            ['first_name' => 'Marcus', 'last_name' => 'Julianus'],
        ];

        // loop through the employees and generate a random 32 char hex string
        for ($i = 1; $i < count($this->employees); $i++) {
            $rfid = '';
            $counter = 0;

            while ($counter < 32) {
                $random = rand(0, 15);
                if ($random > 9) $random = chr($random + 87);
                $rfid .= $random;
                $this->employees[$i]['rfid_number'] = $rfid;
                $counter++;
            }
        }
    }

    public function createDbTables() {

        Connection::pdo()->exec('DROP TABLE IF EXISTS `department_employee`');
        Connection::pdo()->exec('DROP TABLE IF EXISTS `departments`');
        Connection::pdo()->exec('DROP TABLE IF EXISTS `employees`');

        Connection::pdo()->exec('CREATE TABLE `employees` (
                `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT, 
                `first_name` varchar(64) NOT NULL,
                `last_name` varchar(64) NOT NULL,
                `rfid_number` varchar(32) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
            ');

         Connection::pdo()->exec('CREATE TABLE `departments` (
            `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `name` varchar(64) NOT NULL UNIQUE KEY)
            ');

        Connection::pdo()->exec('CREATE TABLE `department_employee` (
            `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `department_id` int(11) NOT NULL REFERENCES `departments` (`id`) ON DELETE CASCADE,
            `employee_id` int(11) NOT NULL REFERENCES `employees` (`id`) ON DELETE CASCADE)
            ');

        Connection::pdo()->exec('ALTER TABLE `department_employee` ADD UNIQUE KEY `department_id` (`department_id`,`employee_id`)');

    }


    public function seedDatabase() {

        // seed the departments
        $stmt = Connection::pdo()->prepare('INSERT INTO `departments` (`name`) VALUES (?), (?), (?), (?), (?)');
        $stmt->execute(['Development', 'Accounting', 'HR', 'Sales', 'IT']);

        // seed the employees
        $stmt = Connection::pdo()->prepare('INSERT INTO `employees` (`first_name`, `last_name`, `rfid_number`) VALUES (?, ?, ?)');
        foreach ($this->employees as $employee)
            $stmt->execute([$employee['first_name'], $employee['last_name'], $employee['rfid_number']]);


        // seed the pivot table linking an employee to one or more departments
        $stmt = Connection::pdo()->prepare('INSERT INTO `department_employee` (`department_id`, `employee_id`) VALUES (?, ?)');
        $stmt->execute([1, 1]);
        $stmt->execute([1, 3]);
        $stmt->execute([2, 2]);
        $stmt->execute([2, 5]);
        $stmt->execute([3, 4]);
        $stmt->execute([4, 5]);
        $stmt->execute([5, 2]);

    }


    public function showEmployees() {

        $stmt = Connection::pdo()->prepare('
            SELECT `employees`.`first_name`, `employees`.`last_name`, `employees`.`rfid_number`,
            GROUP_CONCAT(`departments`.`name` SEPARATOR ", ") AS `department_name`
            FROM `employees`
            INNER JOIN `department_employee` ON `employees`.`id` = `department_employee`.`employee_id`
            INNER JOIN `departments` ON `department_employee`.`department_id` = `departments`.`id`
            GROUP BY `employees`.`last_name`
            ORDER BY `employees`.`last_name`
        ');

        $stmt->execute();

        $data = $stmt->fetchAll(Connection::pdo()::FETCH_ASSOC);

        $stmt = null;

        echo 'Employees:<br>';

        echo '<br><hr><br>';
        echo '<pre>';
        print_r($data);

    }

}