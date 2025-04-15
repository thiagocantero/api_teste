<?php

namespace App\DTO;

class PostDTO
{
    public function __construct(
        public int $id, 
        public string $title, 
        public string $body
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}