<?php

namespace App\Http\Controllers;

use App\Independiente;
use Illuminate\Http\Request;

class IndependientesController extends Controller
{
    public function create($user_id, $description)
    {
        Independiente::create([
            'usuario_id' => $user_id,
            'descripcion' => $description,
        ]);
    }

    public function read($user_id)
    {

    }

    public function update($user_id, $description)
    {
        Independiente::where('usuario_id', $user_id)->update([
            'descripcion' => $description,
        ]);
    }

    public function delete($user_id) {
        Independiente::where('usuario_id', $user_id)->delete();
    }
}