<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;


class Login extends Component
{
   public $email, $name, $password;
   public $registerForm = false;

   public function render()
   {
      return view('livewire.login')->layout("layouts.login-app");
   }

   public function signup()
   {
      $this->registerForm = true;
      $this->resetValidation();
   }

   public function login()
   {
      $this->registerForm = false;
      $this->resetValidation();
   }

   public function loginStore()
   {

      $this->validate([
         "email" => ['required', 'string'],
         "password" => ['required']
      ]);

      $user = Auth::attempt(
         [
            'email' => $this->email,
            'password' => $this->password
         ]
      );

      if ($user) {
         $this->resetErrorBag();
         return redirect()->route("dashboard");
      } else {
         return $this->addError("Error", "Invalid Access Tokens!");
      }
   }

   public function signupStore()
   {
      $this->validate([
         "name" => ['required', 'string', "unique:users"],
         "email" => ["required", "string"],
         "password" => ['required'],
      ]);

      if (Str::length($this->password) < 8) {
         return $this->addError("passwordLength", "Password at least 8 caracters!");
      }
      $this->password = Hash::make($this->password);

      $userReg = User::create([
         'name' => $this->name,
         "email" => $this->email,
         'password' => $this->password
      ]);

      if ($userReg) {
         $this->resetErrorBag();
         return redirect()->route('login');
      } else {
         return;
      }

      $this->email = "";
      $this->name = "";
      $this->password = "";
   }
}
