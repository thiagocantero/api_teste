<?php

use App\Http\Controllers\ApiConsumerController;
use Illuminate\Support\Facades\Route;

route::get('/', [ApiConsumerController::class, 'index'])->name('home');
