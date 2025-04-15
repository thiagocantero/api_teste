<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiConsumerService;

class ApiConsumerController extends Controller
{
    protected $apiConsumerService;

    public function __construct(ApiConsumerService $apiConsumerService)
    {
        $this->apiConsumerService = $apiConsumerService;
    }

    public function index()
    {
        // Consumindo dados do serviço
        $posts = $this->apiConsumerService->getPosts();

        // Retornando para a view
        return view('welcome', compact('posts'));
    }
}