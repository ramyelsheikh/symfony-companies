<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RelationControllerTest extends WebTestCase
{
    protected $client;

    /**
     * RelationControllerTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Create a new client to browse the application
        $this->client = static::createClient();
    }

    public function testRelationIndex()
    {
        // Test relation listing
        $this->client->request('GET', '/relations');
        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /relations"
        );
    }

    public function testRelationCreate()
    {
        // Create a new entry in the database
        $relationData = [
            'name' => 'Daughter',
        ];

        $this->client->request('POST', '/relations', $relationData);

        $this->assertEquals(
            201,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for POST /relations"
        );
    }

    public function testRelationEdit()
    {
        // Create a new entry in the database
        $relationData = [
            'name' => 'Son',
        ];

        $this->client->request('PUT', '/relations/2', $relationData);

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for PUT /relations/2"
        );
    }

    public function testRelationDelete()
    {

        $this->client->request('DELETE', '/relations/2');

        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for DELETE /relations/2"
        );
    }

}