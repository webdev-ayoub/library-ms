<?php

namespace App\Http\Livewire;

use App\Models\Author;
use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class Books extends Component
{
   use WithPagination;

   public $tableShow = true;
   public $createForm = false;
   public $updateForm = false;

   public $searchBook;
   public $searchAuthor;

   public $book_id;
   public $title;
   public $page_count;
   public $publish_date;
   public $author_id;

   public function render()
   {
      $books_count = Book::get();
      $authors = Author::get();

      $books = Book::query();

      if ($this->searchBook) {
         $books = Book::where('title', 'LIKE', '%' . $this->searchBook . '%')
            ->orderBy("id")->get();
      } else if ($this->searchAuthor) {
         foreach ($authors as $author) {
            if (str_starts_with($author->firstname . " " . $author->lastname, $this->searchAuthor)) {
               $books = Book::Where('author_id', $author->id)->orderBy("id")->get();
            }
         }
      } else {
         $books = Book::all();
      }

      return view('livewire.books', [
         "books" => $books,
         "authors" => $authors,
         "books_count" => $books_count
      ])->layout("layouts.app");
   }

   public function addForm()
   {
      $this->tableShow = false;
      $this->createForm = true;
      $this->updateForm = false;
      $this->resetValidation();
   }

   public function showTable()
   {
      $this->tableShow = true;
      $this->createForm = false;
      $this->updateForm = false;

      $this->title = "";
      $this->page_count = "";
      $this->publish_date = "";
      $this->author_id = "";
      $this->resetValidation();
   }

   public function store()
   {
      $data = $this->validate([
         "title" => ["required", "string", "unique:books"],
         "page_count" => ["required", "integer"],
         "publish_date" => ["required", "date"],
         "author_id" => ["required", "exists:authors,id"]
      ]);

      Book::create($data);

      $this->tableShow = true;
      $this->createForm = false;
      $this->updateForm = false;

      $this->title = "";
      $this->page_count = "";
      $this->publish_date = "";
      $this->author_id = "";
      $this->resetValidation();
   }

   public function edit($id)
   {
      $this->tableShow = false;
      $this->updateForm = true;
      $this->createForm = false;

      $book = Book::find($id);

      $this->book_id = $book->id;
      $this->title = $book->title;
      $this->page_count = $book->page_count;
      $this->publish_date = $book->publish_date;
      $this->author_id = $book->author_id;

      $this->resetValidation();
   }

   public function update($id)
   {
      $book = Book::find($id);
      $this->validate([
         "title" => ["required", "string"],
         "page_count" => ["required", "integer"],
         "publish_date" => ["required", "date"],
         "author_id" => ["required", "exists:authors,id"]
      ]);

      $book->title = $this->title;
      $book->page_count = $this->page_count;
      $book->publish_date = $this->publish_date;
      $book->author_id = $this->author_id;

      $book->save();

      $this->tableShow = true;
      $this->createForm = false;
      $this->updateForm = false;

      $this->title = "";
      $this->page_count = "";
      $this->publish_date = "";
      $this->author_id = "";
      $this->resetValidation();
   }

   public function destroy($id)
   {
      $result = Book::find($id);
      $result->delete();
   }
}
