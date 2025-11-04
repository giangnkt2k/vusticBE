<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->date('date_signed');
            $table->integer('customer_id')->unsigned()->index();
            $table->date('date_desk')->nullable();
            $table->decimal('contract_value', 15, 2)->nullable();
            $table->decimal('deposit', 15, 2)->nullable();
            $table->string('status')->nullable();
            $table->string('pdf_file')->nullable();
            $table->string('name')->nullable();
            $table->string('contract_number')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
