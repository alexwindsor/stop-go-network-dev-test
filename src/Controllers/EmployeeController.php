<?php

namespace App\Controllers;
use App\Models\Employee;

class EmployeeController
{

    public function checkCardNumber() {

        $cn = $_GET['cn'] ?? '';

        // demonstrating usage of regular expressions to check that the rfid is a 32 char long hex string
        if (! preg_match('/^[a-fA-F0-9]{32}$/', $cn)) return '{"full_name":" ","department":[""]}';

        $a = new Employee;
        $data = $a->getEmployeeByCardNumber($_GET['cn']);

        $json = [
            'full_name' => $data['first_name'] . ' ' . $data['last_name'],
            'department' => explode(',', $data['department_name'])
        ];

        return json_encode($json);

    }



}