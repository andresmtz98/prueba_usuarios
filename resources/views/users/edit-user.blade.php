@extends('layouts.app')
@section('title')
    Editar Usuario
@endsection

@section('content')
    <div class="row" onloadstart="show()">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal mt-4" method="POST" action="/edit_user/edit">
                        {{ csrf_field() }}

                        <div class="item form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombres</label>

                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->names }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Apellidos</label>

                            <div class="col-md-4">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type_id">Tipo ID</label>
                                <select id="type_id" class="form-control" name="type_id" disabled>
                                    <option value="CC">Cédula de Ciudadanía</option>
                                    <option value="PP">Pasaporte</option>
                                    <option value="CE">Cédula Extranjera</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id" class="col-md-4 control-label">Número de ID</label>

                            <div class="col-md-4">
                                <input id="id" type="number" class="form-control" value="{{ $user->id }}" name="id" required="false" disabled>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="occupation">Ocupación</label>
                                <select id="occupation" class="form-control" name="occupation" onchange="showDivs_occupation(this.selectedIndex)">
                                    <option value="empleado">Empleado</option>
                                    <option value="estudiante">Estudiante</option>
                                    <option value="independiente">Independiente</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4" id="div_employee_data">
                            <div class="form-group">
                                <label for="business">Empresa</label>
                                <input id="business" type="text" class="form-control" name="business" value="{{ old('business') }}" required autofocus>

                                @if ($errors->has('business'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('business') }}</strong>
                                </span>
                                @endif

                                <label for="position">Cargo</label>
                                <input id="position" type="text" class="form-control" name="position" value="{{ old('position') }}" required autofocus>

                                @if ($errors->has('position'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('position') }}</strong>
                                </span>
                                @endif

                                <label for="start_date">Fecha de Inicio</label>
                                <input id="start_date" type="date" class="form-control" name="start_date" value="{{ old('start_date') }}" required autofocus>

                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('start_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4" id="div_student_data" hidden>
                            <div class="form-group">
                                <label for="college">Institución</label>
                                <input id="college" type="text" class="form-control" name="college" value="{{ old('college') }}"  autofocus>

                                @if ($errors->has('college'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('college') }}</strong>
                                </span>
                                @endif

                                <label for="program">Programa</label>
                                <input id="program" type="text" class="form-control" name="program" value="{{ old('program') }}"  autofocus>

                                @if ($errors->has('program'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('program') }}</strong>
                                </span>
                                @endif

                                <label for="semester">Semestre</label>
                                <input id="semester" type="number" min="1" max="15" class="form-control" name="semester" value="{{ old('semester') }}"  autofocus>

                                @if ($errors->has('semester'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('semester') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div id="div_self-employee_data" class="form-group{{ $errors->has('self-employee_description') ? ' has-error' : '' }}"
                             hidden disabled="true">
                            <label for="self-employee_description" class="col-md-4 control-label">Descripción</label>

                            <div class="col-md-6">
                                <textarea id="self-employee_description" class="form-control" name="self-employee_description"  autofocus></textarea>

                                @if ($errors->has('self-employee_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('self-employee_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mt-5">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" class="btn btn-primary" value="Guardar" onclick="enableComponents()"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles_extra')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            /**
             * Load user data to inputs fields.
             */
            switch ('{{ $user->occupation_name }}') {
                case 'empleado': @if(isset($employee))
                            document.getElementById("occupation").value = '{{ $user->occupation_name }}';
                            document.getElementById("business").value = '{{ $employee->empresa }}';
                            document.getElementById("position").value = '{{ $employee->cargo }}';
                            document.getElementById("start_date").value = '{{ $employee->fecha_inicio }}';
                            showDivs_occupation(0);
                        @endif
                    break;
                case 'estudiante': @if(isset($student))
                            document.getElementById("occupation").value = '{{ $user->occupation_name }}';
                            document.getElementById("college").value = '{{ $student->institucion }}';
                            document.getElementById("program").value = '{{ $student->programa }}';
                            document.getElementById("semester").value = '{{ $student->semestre }}';
                            showDivs_occupation(1);
                        @endif
                    break;
                default: @if (isset($self_employee))
                            document.getElementById("occupation").value = '{{ $user->occupation_name }}';
                            document.getElementById("self-employee_description").vaue = '{{ $self_employee->descripcion }}';
                            showDivs_occupation(2);
                        @endif
                    break;
            }
        });

        /**
         * Show and hide divs when the client choose an item from the occupation select.
         * @param index
         */

        function showDivs_occupation(index) {
            if (index === 0){
                document.getElementById("div_employee_data").hidden = false;
                document.getElementById("div_student_data").hidden = true;
                document.getElementById("div_self-employee_data").hidden = true;
            } else if (index === 1){
                document.getElementById("div_employee_data").hidden = true;
                document.getElementById("div_student_data").hidden = false;
                document.getElementById("div_self-employee_data").hidden = true;
            } else {
                document.getElementById("div_employee_data").hidden = true;
                document.getElementById("div_student_data").hidden = true;
                document.getElementById("div_self-employee_data").hidden = false;
            }
            setRequired(index);
        }

        function setRequired(index) {
            if (index === 0){ //Div employee_data
                document.getElementById("business").required = true;
                document.getElementById("position").required = true;
                document.getElementById("start_date").required = true;
                document.getElementById("college").required = false;
                document.getElementById("program").required = false;
                document.getElementById("semester").required = false;
                document.getElementById("self-employee_description").required = false;
            } else if (index === 1) { //Div student_data
                document.getElementById("business").required = false;
                document.getElementById("position").required = false;
                document.getElementById("start_date").required = false;
                document.getElementById("college").required = true;
                document.getElementById("program").required = true;
                document.getElementById("semester").required = true;
                document.getElementById("self-employee_description").required = false;
            } else {
                document.getElementById("business").required = false;
                document.getElementById("position").required = false;
                document.getElementById("start_date").required = false;
                document.getElementById("college").required = false;
                document.getElementById("program").required = false;
                document.getElementById("semester").required = false;
                document.getElementById("self-employee_description").required = true;
            }
        }

        function enableComponents() {
            document.getElementById("type_id").removeAttribute('disabled');
            document.getElementById("id").removeAttribute('disabled');
        }
    </script>
@endsection