<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AutorTest extends TestCase
{
    private int $autorId = 123;

    public function test_autor_post(): void
    {
        $response = $this->post('/api/autores', [
            'id'   => $this->autorId,
            'nome' => 'Ayrton Senna',
        ]);
        $response->assertStatus(200);
    }

    public function test_autor_get()
    {
        $response = $this->get("/api/autores/$this->autorId");
        $response->json($response->content());
        $response->assertStatus(200);
    }

    public function test_autor_put()
    {
        $response = $this->put("/api/autores/$this->autorId", [
            'nome' => 'Nelson Piquet',
        ]);
        $response->assertStatus(200);
    }

    public function test_autor_delete()
    {
        $response = $this->delete("/api/autores/$this->autorId");
        $response->json($response->content());
        $response->assertStatus(200);
    }
}
