<?php

namespace App\Http\Livewire;

use App\Models\Author;
use Livewire\Component;
use Livewire\WithPagination;


class Authors extends Component
{
   use WithPagination;

   public $tableShow = true;
   public $createForm = false;
   public $updateForm = false;

   public $firstname;
   public $lastname;

   public $author_id;

   public $search;

   public function render()
   {
      $authors_count = Author::get();

      $authors = Author::where('firstname', 'LIKE', '%' . $this->search . '%')
         ->orWhere('lastname', 'LIKE', '%' . $this->search . '%')
         ->orderBy("created_at", "DESC")
         ->paginate(10);

      return view(
         'livewire.authors',
         [
            "authors" => $authors,
            "authors_count" => $authors_count
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

      $this->firstname = "";
      $this->lastname = "";
      $this->resetValidation();
   }

   public function store()
   {    
      $data = $this->validate([
         "firstname" => ["required", "string", "unique:authors"],
         "lastname" => ["required", "string", "unique:authors"]
      ]);
      
      Author::create($data);

      $this->tableShow = true;
      $this->createForm = false;
      $this->updateForm = false;

      $this->firstname = "";
      $this->lastname = "";
      $this->resetValidation();
   }

   public function edit($id)
   {
      $this->updateForm = true;
      $this->tableShow = false;
      $this->createForm = false;

      $author = Author::find($id);

      $this->author_id = $author->id;
      $this->firstname = $author->firstname;
      $this->lastname = $author->lastname;

      $this->resetValidation();
   }

   public function update($id)
   {
      $author = Author::find($id);

      $this->validate([
         "firstname" => ["required", "string"],
         "lastname" => ["required", "string"]
      ]);

      $author->firstname = $this->firstname;
      $author->lastname = $this->lastname;

      $author->save();

      $this->tableShow = true;
      $this->createForm = false;
      $this->updateForm = false;

      $this->firstname = "";
      $this->lastname = "";
      $this->resetValidation();
   }

   public function destroy($id)
   {
      $result = Author::find($id);
      $result->delete();
   }
}
