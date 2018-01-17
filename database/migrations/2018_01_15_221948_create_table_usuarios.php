<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->timestamps();
            $table->string('id',12)->primary(); //Identification number E.g. 1234788456
            $table->string('type_id'); //Possible values cc, ce, ps
            $table->string('names');
            $table->string('last_name');
            $table->string('occupation_name'); //Values (empleado, estudiante, independiente)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
