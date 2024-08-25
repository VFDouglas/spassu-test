<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssuntoTest extends TestCase
{
    private int $assuntoId = 123;

    public function test_assunto_post(): void
    {
        $response = $this->post('/api/assuntos', [
            'id'        => $this->assuntoId,
            'descricao' => 'Teste',
        ]);
        $response->assertStatus(200);
    }

    public function test_assunto_get()
    {
        $response = $this->get("/api/assuntos/$this->assuntoId");
        $response->json($response->content());
        $response->assertStatus(200);
    }

    public function test_assunto_put()
    {
        $response = $this->put("/api/assuntos/$this->assuntoId", [
            'descricao' => 'Teste2',
        ]);
        $response->assertStatus(200);
    }

    public function test_assunto_delete()
    {
        $response = $this->delete("/api/assuntos/$this->assuntoId");
        $response->json($response->content());
        $response->assertStatus(200);
    }
}
