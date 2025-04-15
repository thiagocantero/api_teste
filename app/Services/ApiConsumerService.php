<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\DTO\PostDTO;

class ApiConsumerService
{
    public function getPosts(): array
    {
        // Consumindo a API pública
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        if ($response->successful()) {
            // Mapeando os dados para o DTO
            return array_map(function ($post) {
                return new PostDTO(
                    id: $post['id'],
                    title: $post['title'],
                    body: $post['body']
                );
            }, $response->json());
        }

        return []; // Retorna um array vazio em caso de falha
    }
}