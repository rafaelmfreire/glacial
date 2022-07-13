<?php

use App\Enums\ServiceOrderStatus;
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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('air_conditioner_id')->constrained()->restrictOnDelete();
            $table->dateTime('done_at');
            $table->string('technicians')->nullable()->default('Instrucon');
            $table->text('services')->nullable();
            $table->unsignedInteger('status')->default(ServiceOrderStatus::Concluido->value);
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
        Schema::dropIfExists('service_orders');
    }
};
