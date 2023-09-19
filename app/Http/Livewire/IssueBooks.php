<?php

namespace App\Http\Livewire;

use App\Models\Book;
use App\Models\issueBook;
use Livewire\Component;
use Livewire\WithPagination;

class IssueBooks extends Component
{
   use WithPagination;

   public $tableShow = true;
   public $createForm = false;
   public $updateForm = false;

   public $book_id;
   public $issue_date;
   public $return_date;

   public $issuedBook_id;
   public $books;
   public $authors;

   public $fromDate;
   public $toDate;

   public function render()
   {
      $issuedBooks_count = issueBook::get();
      $all_books = Book::get();
      $this->books = Book::orderBy("id", "DESC")->get();

      if ($this->fromDate && $this->toDate) {
         $issueBooks = issueBook::whereBetween('issue_date', [$this->fromDate, $this->toDate])
            ->orderBy("created_at", "DESC")
            ->paginate(10);
      } elseif ($this->book_id) {
         $issueBooks = issueBook::where('book_id', $this->book_id)
            ->orderBy("created_at", "DESC")
            ->paginate(10);
      } else {
         $issueBooks = issueBook::orderBy("created_at", "DESC")
            ->paginate(10);
      }

      return view(
         'livewire.issue-books',
         [
            "issuedBooks_count" => $issuedBooks_count,
            "issueBooks" => $issueBooks,
            'all_books' => $all_books
         ]
      )->layout("layouts.app");
   }

   public function addForm()
   {
      $this->createForm = true;
      $this->tableShow = false;
      $this->updateForm = false;
      $this->resetValidation();
   }

   public function showTable()
   {
      $this->tableShow = true;
      $this->createForm = false;
      $this->updateForm = false;

      $this->book_id = "";
      $this->issue_date = "";
      $this->return_date = "";
      $this->resetValidation();
   }

   public function store()
   {
      $data = $this->validate([
         "book_id" => ["required", "integer", "exists:books,id"],
         "issue_date" => ["required", "date"],
         "return_date" => ["nullable"]
      ]);

      $book = Book::find($data["book_id"]);
      $issuedBooksExist = $book->issuedBooks()
         ->where(function ($query) use ($data) {
            $query->where('issue_date', '<=', $data['issue_date'])
               ->where(function ($query) use ($data) {
                  $query->whereNull('return_date')
                     ->orWhere('return_date', '>=', $data['issue_date']);
               });
         })
         ->get();

      if ($issuedBooksExist->isNotEmpty()) {
         $this->addError('book_id', 'This book is already issued');
         return;
      }

      issueBook::create($data);

      $this->tableShow = true;
      $this->createForm = false;
      $this->updateForm = false;

      $this->book_id = "";
      $this->issue_date = "";
      $this->return_date = "";
      $this->resetValidation();
   }

   public function edit($id)
   {
      $this->tableShow = false;
      $this->updateForm = true;
      $this->createForm = false;

      $issue_book = issueBook::find($id);

      $this->issuedBook_id = $issue_book->id;
      $this->issue_date = $issue_book->issue_date;
      $this->return_date = $issue_book->return_date;
      $this->book_id = $issue_book->book_id;

      $this->resetValidation();
   }

   public function update($id)
   {
      $issued_book = issueBook::find($id);

      $this->validate([
         "book_id" => ["required", "integer", "exists:books,id"],
         "issue_date" => ["required", "date"],
         "return_date" => ["nullable"]
      ]);

      $book = Book::find($this->book_id);
      $new_issuedBook = $book->getIssuedBooks($this->issue_date, $this->return_date, $this->book_id, $issued_book->id);

      if ($new_issuedBook->issuedBooks->isNotEmpty()) {
         $this->addError('book_id', 'This book is already issued');
         return;
      }

      $issued_book->book_id = $this->book_id;
      $issued_book->issue_date = $this->issue_date;
      $issued_book->return_date = $this->return_date;

      $issued_book->save();

      $this->tableShow = true;
      $this->createForm = false;
      $this->updateForm = false;

      $this->book_id = "";
      $this->issue_date = "";
      $this->return_date = "";
      $this->resetValidation();
   }

   public function destroy($id)
   {
      $result = issueBook::find($id);
      $result->delete();
   }
}
