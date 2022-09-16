<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('air_conditioner_files', function (Blueprint $table) {
            $table->id();
            $table->text('path');
            $table->text('filename');
            $table->char('extension');
            $table->foreignId('air_conditioner_id')->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('air_conditioner_files');
    }
};
