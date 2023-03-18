<?php
namespace Tests;

require_once __DIR__ . '/../env.php';

use App\Models\Employee;
use PHPUnit\Framework\TestCase;
use Throwable;

class EmployeeTest extends TestCase
{

    /** @test */
    public function it_gets_employee_by_card_number() {

        $employee = new Employee();
        $getEmployee = $employee->getEmployeeByCardNumber('142594708f3a5a3ac2980914a0fc954f');

        self::assertEquals($getEmployee['first_name'] . ' ' . $getEmployee['last_name'], 'Julius Caesar');

    }

    /** @test */
    public function it_returns_empty_fields_with_wrong_card_number() {

        $employee = new Employee();
        $getEmployee = $employee->getEmployeeByCardNumber('xxx');

        self::assertEquals($getEmployee, ['first_name' => '', 'last_name' => '', 'department_name' => '']);

    }

}
