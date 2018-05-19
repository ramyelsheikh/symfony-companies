<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DependantControllerTest extends WebTestCase
{
    protected $client;

    /**
     * DependantControllerTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Create a new client to browse the application
        $this->client = static::createClient();
    }

    public function testDependantIndex()
    {
        // Test dependant listing
        $this->client->request('GET', '/dependants');
        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /dependants"
        );
    }

    public function testDependantCreate()
    {
        // Create a new entry in the database
        $dependantData = [
            'name' => 'Test Dependant',
            'phone_number' => '+9715845121212',
            'gender' => 'm',
            'date_of_birth' => '1988-01-15',
            'relation_id' => '1',
            'employee_id' => '49'
        ];

        $this->client->request('POST', '/dependants', $dependantData);

        $this->assertEquals(
            201,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for POST /dependants"
        );
    }

    public function testDependantEdit()
    {
        // Create a new entry in the database
        $dependantData = [
            'name' => 'Test Dependant',
            'phone_number' => '+9715845121212',
            'gender' => 'm',
            'date_of_birth' => '1988-01-15',
            'relation_id' => '1',
            'employee_id' => '49'
        ];

        $this->client->request('PUT', '/dependants/2', $dependantData);

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for PUT /dependants/2"
        );
    }

    public function testDependantDelete()
    {

        $this->client->request('DELETE', '/dependants/2');

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for DELETE /dependants/2"
        );
    }

}