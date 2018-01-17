<?php

namespace App\Http\Controllers;

use App\Estudiante;
use Illuminate\Http\Request;

class EstudiantesController extends Controller
{
    public function create($user_id, $college, $program, $semester)
    {
        Estudiante::create([
            'usuario_id' => $user_id,
            'institucion' => $college,
            'programa' => $program,
            'semestre' => $semester,
        ]);
    }

    public function read($user_id)
    {

    }

    public function update($user_id, $college, $program, $semester)
    {
        Estudiante::where('usuario_id', $user_id)->update([
            'institucion' => $college,
            'programa' => $program,
            'semestre' => $semester,
        ]);
    }

    public function delete($user_id) {
        Estudiante::where('usuario_id', $user_id)->delete();
    }
}
