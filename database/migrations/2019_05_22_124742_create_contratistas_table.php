<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratistas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 25);
            $table->string('centro_SAP', 4);
            $table->string('almacen_SAP', 4);
            $table->string('added_by')->default('admin');
            $table->string('color', 7)->unique();
            $table->timestamps();
            $table->unique(['centro_SAP', 'almacen_SAP']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contratistas');
    }
}
