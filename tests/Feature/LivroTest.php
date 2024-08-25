<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class LivroTest extends TestCase
{
    private int $livroId = 123;

    public function test_livro_post(): void
    {
        $response = $this->post('/api/livros', [
            'id'      => $this->livroId,
            'titulo'  => 'O senhor dos Aneis',
            'editora' => 'Teste',
            'edicao'  => '3',
            'ano'     => '2024',
            'valor'   => rand(0, 100),
        ]);
        $response->assertStatus(200);
    }

    public function test_livro_get()
    {
        $response = $this->get("/api/livros/$this->livroId");
        $response->json($response->content());
        $response->assertStatus(200);
    }

    public function test_livro_put()
    {
        $response = $this->put("/api/livros/$this->livroId", [
            'titulo'  => 'Esqueci qual inserir',
            'editora' => 'Não sei',
            'edicao'  => rand(0, 100),
            'ano'     => rand(200, 2000),
            'valor'   => rand(0, 100),
        ]);
        $response->assertStatus(200);
    }

    public function test_livro_delete()
    {
        $response = $this->delete("/api/livros/$this->livroId");
        $response->json($response->content());
        $response->assertStatus(200);
    }
}
