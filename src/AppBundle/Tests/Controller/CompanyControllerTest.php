<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyControllerTest extends WebTestCase
{
    protected $client;

    /**
     * CompanyControllerTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Create a new client to browse the application
        $this->client = static::createClient();
    }

    public function testCompanyIndex()
    {
        // Test company listing
        $this->client->request('GET', '/companies');
        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /companies"
        );
    }

    public function testComapnyCreate()
    {
        // Create a new entry in the database
        $companyData = [
            'name' => 'Test Company',
            'address' => 'Test Company Address',
        ];

        $this->client->request('POST', '/companies', $companyData);

        $this->assertEquals(
            201,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for POST /companies"
        );
    }

    public function testComapnyEdit()
    {
        // Create a new entry in the database
        $companyData = [
            'name' => 'Test Company Edit',
            'address' => 'Test Company Address Edit',
        ];

        $this->client->request('PUT', '/companies/57', $companyData);

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for PUT /companies/57"
        );
    }

    public function testComapnyDelete()
    {

        $this->client->request('DELETE', '/companies/57');

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for DELETE /companies/57"
        );
    }

}