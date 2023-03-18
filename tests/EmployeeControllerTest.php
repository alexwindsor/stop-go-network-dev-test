<?php
namespace Tests;

require_once __DIR__ . '/../env.php';

use App\Controllers\EmployeeController;
use PHPUnit\Framework\TestCase;
use Throwable;

class EmployeeControllerTest extends TestCase
{

    /** @test */
    public function it_gets_back_data_from_the_employee_model() {

        $_GET['cn'] = '142594708f3a5a3ac2980914a0fc954f';

        $employeeController = new EmployeeController();
        $getEmployee = $employeeController->checkCardNumber();

        self::assertEquals($getEmployee, '{"full_name":"Julius Caesar","department":["Development"]}');

    }


}
