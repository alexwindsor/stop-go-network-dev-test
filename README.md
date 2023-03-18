Stop Go Network Php Devleoper test

## To install :

- clone or download/unpack zip into an apache server (ie. /var/www/html/etc..)
- run composer install
- create a database called 'alexwindsor_sgn_php_test'
- edit the env_example.php file with your database credentials
- rename 'env_example.php' to 'env.php'
- visit the db-setup/ endpoint in your browser to create and seed the tables, or import the 'alexwindsor_sgn_php_test.sql' script into your database
- visit /endpoint/?cn=142594708f3a5a3ac2980914a0fc954f to check employee card number


## PHP Unit tests :

The following will run the tests:
`php vendor/phpunit/phpunit/phpunit tests --color`

Results of the unit tests can be seen in this screenshot:
`tests/UnitTests.png`

There are two unit tests in the tests/ directory that test the Employee model class and the EmployeeController class. They test that the correct name 'Julius Caesar' is returned when the following card number is given '142594708f3a5a3ac2980914a0fc954f'  and that empty fields ``{"full_name":" ","department":[""]}`` are returned if an incorrect card number is given.

## Database Schema :

``CREATE TABLE `employees` (
`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
`first_name` varchar(64) NOT NULL,
`last_name` varchar(64) NOT NULL,
`rfid_number` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci``

``CREATE TABLE `departments` (
`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
`name` varchar(64) NOT NULL UNIQUE KEY)``

``CREATE TABLE `department_employee` (
`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`department_id` int(11) NOT NULL REFERENCES `departments` (`id`) ON DELETE CASCADE,
`employee_id` int(11) NOT NULL REFERENCES `employees` (`id`) ON DELETE CASCADE)``

``ALTER TABLE `department_employee` ADD UNIQUE KEY `department_id` (`department_id`,`employee_id`)``

