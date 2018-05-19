<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeControllerTest extends WebTestCase
{
    protected $client;

    /**
     * EmployeeControllerTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Create a new client to browse the application
        $this->client = static::createClient();
    }

    public function testEmployeeIndex()
    {
        // Test employee listing
        $this->client->request('GET', '/employees');
        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /employees"
        );
    }

    public function testEmployeeCreate()
    {
        // Create a new entry in the database
        $employeeData = [
            'name' => 'Test Employee',
            'phone_number' => '+9715845121212',
            'gender' => 'm',
            'date_of_birth' => '1988-01-15',
            'salary' => '20000',
            'company_id' => '34'
        ];

        $this->client->request('POST', '/employees', $employeeData);

        $this->assertEquals(
            201,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for POST /employees"
        );
    }

    public function testEmployeeEdit()
    {
        // Create a new entry in the database
        $employeeData = [
            'name' => 'Test Employee',
            'phone_number' => '+9715845121212',
            'gender' => 'm',
            'date_of_birth' => '1988-01-15',
            'salary' => '20000',
            'company_id' => '34'
        ];

        $this->client->request('PUT', '/employees/14', $employeeData);

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for PUT /employees/14"
        );
    }

    public function testEmployeeDelete()
    {

        $this->client->request('DELETE', '/employees/14');

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for DELETE /employees/14"
        );
    }

}