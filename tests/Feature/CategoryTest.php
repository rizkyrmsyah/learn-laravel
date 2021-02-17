<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListCategory()
    {
        $response = $this->json('GET','/api/categories', ['Accept' => 'application/json']);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAddCategory()
    {
        $data = [
            'name' => 'Pelajaran sekolah',
        ];

        $response = $this->json('POST', '/api/categories', $data, ['Accept' => 'application/json']);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(["message"]);
    }

    public function testCategoryNullName()
    {
        $data = [
            'name' => '',
        ];

        $response = $this->json('POST', '/api/categories', $data, ['Accept' => 'application/json']);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            "message",
            "errors" => [
                "name"
            ]
        ]);
    }
}
