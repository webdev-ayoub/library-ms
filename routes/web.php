<?php

use App\Http\Livewire\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Authors;
use App\Http\Livewire\Books;
use App\Http\Livewire\IssueBooks;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => "auth"], function () {
   Route::get('/', Login::class)->name("login");
   Route::get('/dashboard', Dashboard::class)->name("dashboard");
   Route::get('/authors', Authors::class)->name("authors");
   Route::get('/books', Books::class)->name("books");
   Route::get('/issue-books', IssueBooks::class)->name("issue-books");   
});

Route::group(["middleware" => "guest"], function () {
   Route::get('/', Login::class)->name("login"); 
});
