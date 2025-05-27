<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // migration create_transactions_table.php
   // migration create_transactions_table.php
  public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID au lieu de $table->id()
            $table->string('reference')->unique();
            $table->unsignedBigInteger('montant');
            $table->string('status')->default('en_attente'); // en_attente, succes, echec
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
