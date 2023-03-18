<?php

require '../vendor/autoload.php';
require '../env.php';

use App\Controllers\EmployeeController;

$employee = new EmployeeController;
echo $employee->checkCardNumber();
