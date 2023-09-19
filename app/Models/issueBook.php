<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class issueBook extends Model
{
   use HasFactory;

   protected $table = 'issued_books';
   protected $fillable = ['book_id', "issue_date", "return_date"];

   public function book()
   {
      return $this->belongsTo(Book::class);
   }
}
