<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
   use HasFactory;

   protected $table = "books";
   protected $fillable = ["title", "page_count", "publish_date", "author_id"];

   public function author()
   {
      return $this->belongsTo(Author::class);
   }

   public function issuedBooks()
   {
      return $this->hasMany(issueBook::class);
   }

   public function getIssuedBooks($issueDate, $returnDate, $excludeId = null)
   {
      return $this->with(['issuedBooks' => function ($query) use ($issueDate, $returnDate, $excludeId) {
         $query->where(function ($query) use ($issueDate, $returnDate) {
            $query->where('issue_date', '>=', $issueDate)
               ->where('issue_date', '<=', $returnDate);
         })
            ->orWhere(function ($query) use ($issueDate, $returnDate) {
               $query->where('return_date', '>=', $issueDate)
                  ->where('return_date', '<=', $returnDate);
            })
            ->orWhere(function ($query) use ($issueDate, $returnDate) {
               $query->where('issue_date', '<', $issueDate)
                  ->where('return_date', '>', $returnDate);
            })
            ->when($excludeId, function ($query) use ($excludeId) {
               $query->where('id', '<>', $excludeId);
            });
      }])->find($this->id);
   }
}
