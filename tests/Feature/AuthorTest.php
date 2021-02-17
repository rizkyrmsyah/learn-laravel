<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testListAuthor()
    {
        $response = $this->json('GET','/api/authors', ['Accept' => 'application/json']);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAddAuthor()
    {
        $data = [
            'name' => 'Rizkytest',
        ];

        $response = $this->json('POST', '/api/authors', $data, ['Accept' => 'application/json']);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(["message"]);
    }

    public function testAddAuthorNullName()
    {
        $data = [
            'name' => '',
        ];

        $response = $this->json('POST', '/api/authors', $data, ['Accept' => 'application/json']);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            "message",
            "errors" => [
                "name"
            ]
        ]);
    }
}
