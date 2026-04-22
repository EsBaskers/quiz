<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create(){
        return view('quiz.register');
     }
     public function store(Request $request){
         $validated = $request->validate([
             "name" =>['required','max:255'],
             "email" => ['required', 'email', Rule::unique('users', 'email')],
             "password" => ["required","confirmed", Password::min(6)->numbers()->letters()->symbols()]
         ]);
         $user = User::create($validated);
         Auth::login($user);
         return redirect('/Main');
     }
}

?>
