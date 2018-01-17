<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;

class ListUsersController extends Controller
{
    public function list()
    {
        $users = Usuario::paginate(10);
        return view('users-list', [
           'users' => $users,
        ]);
    }
}
