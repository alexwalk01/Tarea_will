<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'security_question_1' => ['required', 'in:first_pet,favorite_movie'], // Validar que sea una de las opciones
            'security_answer_1' => ['required', 'string', 'max:255'],
            'security_question_2' => ['required', 'in:first_pet,favorite_movie'], // Validar que sea una de las opciones
            'security_answer_2' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'security_question_1' => $data['security_question_1'],
            'security_answer_1' => $data['security_answer_1'],
            'security_question_2' => $data['security_question_2'],
            'security_answer_2' => $data['security_answer_2'],
        ]);
    }
}