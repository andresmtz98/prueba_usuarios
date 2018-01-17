<?php

namespace App\Http\Controllers;

use App\Empleado;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    public function create($user_id, $business, $position, $start_date)
    {
        Empleado::create([
            'usuario_id' => $user_id,
            'empresa' => $business,
            'cargo' => $position,
            'fecha_inicio' => $start_date,
        ]);
    }

    public function read($user_id)
    {

    }

    public function update($user_id, $business, $position, $start_date)
    {
        Empleado::where('usuario_id', $user_id)->update([
            'empresa' => $business,
            'cargo' => $position,
            'fecha_inicio' => $start_date,
        ]);
    }

    public function delete($user_id) {
        Empleado::where('usuario_id', $user_id)->delete();
    }
}
