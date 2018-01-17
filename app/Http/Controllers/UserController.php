<?php

namespace App\Http\Controllers;
use App\Empleado;
use App\Estudiante;
use App\Http\Requests\CreateUserRequest;
use App\Independiente;
use App\Usuario;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        Usuario::create([
            'id' => $request->input('id'),
            'type_id' => $request->input('type_id'),
            'names' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'occupation_name' => $request->input('occupation'),
        ]);
        $this->create_user_in_occupation_table($request);

        return redirect('/');
    }

    public function edit(CreateUserRequest $request)
    {
        $user = Usuario::where('id', $request->input('id'))->get()->first();
        $user->names = $request->input('name'); $user->last_name = $request->input('last_name');
        if ($user->occupation_name === $request->input('occupation')) {
            $this->editWithoutDeleting($user, $request);
            $user->save();
        } else {
            $this->editDeleting($user, $request);
            $user->save();
        }
        return redirect('/');
    }

    public function getUser(Usuario $user)
    {
        $params = [
            'user' => $user,
        ];
        switch ($user->occupation_name){
            case 'empleado': $params['employee'] = Empleado::where('usuario_id', $user->id)->get()->first();
                    break;
            case  'estudiante': $params['student'] = Estudiante::where('usuario_id', $user->id)->get()->first();
                    break;
            default: $params['self_employee'] = Independiente::where('usuario_id', $user->id)->get()->first();
                    break;
        }

        return view('users.edit-user', $params);
    }

    public function delete(Usuario $user)
    {
        switch ($user->occupation_name) {
            case 'empleado': $employeeControl = new EmpleadosController();
                        $employeeControl->delete($user->id);
                        break;
            case 'estudiante': $studentControl = new EstudiantesController();
                        $studentControl->delete($user->id);
                        break;
            default:$self_employeeControl = new IndependientesController();
                        $self_employeeControl->delete($user->id);
                        break;
        }
        Usuario::destroy($user->id);
        return redirect('/');
    }

    /**
     * Update user with the same occupation
     * @param $user
     * @param $request
     */

    private function editWithoutDeleting($user, $request)
    {
        switch ($user->occupation_name) {
            case 'empleado':
                $employeeControl = new EmpleadosController();
                $employeeControl->update($user->id, $request->input('business'), $request->input('position'),
                    $request->input('start_date'));
                break;
            case 'estudiante':
                $studentControl = new EstudiantesController();
                $studentControl->update($user->id, $request->input('college'), $request->input('program'),
                    $request->input('semester'));
                break;
            default:
                $self_employeeControl = new IndependientesController();
                $self_employeeControl->update($user->id, $request->input('description'));
                break;
        }
    }

    /**
     * Update user deleting from occupation table (empleados, estudiantes or independientes)
     * And adding to new occupation table
     * @param $user
     * @param $request
     */

    private function editDeleting($user, $request)
    {
        if ($user->occupation_name === 'empleado') {
            $employeeControl = new EmpleadosController(); $employeeControl->delete($user->id);
            if ($request->input('occupation') === 'estudiante') {
                $user->occupation_name = 'estudiante';
                $studentControl = new EstudiantesController();
                $studentControl->create($user->id, $request->input('college'),
                    $request->input('program'), $request->input('semester'));
            } else {
                $user->occupation_name = 'independiente';
                $self_employeeControl = new IndependientesController();
                $self_employeeControl->create($user->id, $request->input('self-employee_description'));
            }
        } else if ($user->occupation_name === 'estudiante') {
            $studentControl = new EstudiantesController(); $studentControl->delete($user->id);
            if ($request->input('occupation') === 'empleado') {
                $user->occupation_name = 'empleado';
                $employeeControl = new EmpleadosController();
                $employeeControl->create($request->input('id'),
                    $request->input('business'), $request->input('position'), $request->input('start_date'));
            } else {
                $user->occupation_name = 'independiente';
                $self_employeeControl = new IndependientesController();
                $self_employeeControl->create($user->id, $request->input('self-employee_description'));
            }
        } else {
            $self_employeeControl = new IndependientesController(); $self_employeeControl->delete($user->id);
            if ($request->input('occupation') === 'empleado') {
                $user->occupation_name = 'empleado';
                $employeeControl = new EmpleadosController();
                $employeeControl->create($request->input('id'),
                    $request->input('business'), $request->input('position'), $request->input('start_date'));
            } else {
                $user->occupation_name = 'estudiante';
                $studentControl = new EstudiantesController();
                $studentControl->create($user->id, $request->input('college'),
                    $request->input('program'), $request->input('semester'));
            }
        }
    }

    private function create_user_in_occupation_table($request)
    {
        switch ($request->input('occupation'))
        {
            case 'empleado': $employeeControl = new EmpleadosController();
                $employeeControl->create($request->input('id'),
                    $request->input('business'), $request->input('position'), $request->input('start_date'));
                break;
            case 'estudiante': $studentControl = new EstudiantesController();
                $studentControl->create($request->input('id'), $request->input('college'),
                    $request->input('program'), $request->input('semester'));
                break;
            default: $self_employeeControl = new IndependientesController();
                $self_employeeControl->create($request->input('id'),$request->input('self-employee_description'));
                break;
        }
    }
}
