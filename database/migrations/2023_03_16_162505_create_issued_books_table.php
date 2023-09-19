<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
    * Run the migrations.
    */
   public function up(): void
   {
      Schema::create('issued_books', function (Blueprint $table) {
         $table->id();
         $table->foreignId('book_id')->constrained('books')->onDelete("cascade");
         $table->string("issue_date");
         $table->string("return_date")->nullable();
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::dropIfExists('issued_books');
   }
};
