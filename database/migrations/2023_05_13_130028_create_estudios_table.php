<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estudios', function (Blueprint $table) {
            $table->id();
            // ------------------- inicia campos estudios

            $table->date('Fecha');//00080020
            $table->integer('Hora');//00080020
            $table->string('DNI');//00100020
            $table->string('Paciente');//00100010
            $table->string('Sexo');//00100040
            $table->date('Nacimiento')->nullable(true);//00100030
            $table->string('Os');//Series: 00081040: Institution Department Name ó 00081050: Accession Number
            $table->string('Médico');//00080090
            $table->string('Diagnóstico');//00081030
            $table->string('Descripcion');//ver serie
            $table->string('Ubicación');//00080050
            $table->string('PCuerpo');//Series: 00180015: Body Part Examined
            $table->string('Mo');//00080061
            $table->string('informe');//00080061
            $table->integer('CantInst');//7777102A
            $table->string('studyUID')->unique();//0020000D
            // ------------------- fin campos estudios
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudios');
    }
};
