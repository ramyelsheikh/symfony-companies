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

    public function testCompleteScenario()
    {
        // Create a new entry in the database
        $crawler = $this->client->request('GET', '/companies');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /companies/");

        /*


        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'appbundle_company[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());*/
    }
}