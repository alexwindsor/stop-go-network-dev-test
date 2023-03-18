<?php

namespace App\Models;
use App\Database\Connection;


class Employee {


    public function getEmployeeByCardNumber($cn) {

        // this sql statement uses GROUP_CONCAT to get the employee row along with a comma separated list of linked departments all in one row
        $stmt = Connection::pdo()->prepare('
            SELECT `employees`.`first_name`, `employees`.`last_name`,
                   group_concat(`departments`.`name` separator ",") AS `department_name`
            FROM `employees`
            INNER JOIN `department_employee` ON `employees`.`id` = `department_employee`.`employee_id`
            INNER JOIN `departments` ON `department_employee`.`department_id` = `departments`.`id`
            WHERE `employees`.`rfid_number` = ?
        ');

        $stmt->execute([$cn]);

        $data = $stmt->fetchAll(Connection::pdo()::FETCH_ASSOC);

        return $data[0];

    }



}