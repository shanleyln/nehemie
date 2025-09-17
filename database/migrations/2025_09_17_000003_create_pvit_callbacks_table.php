<?php

// database/migrations/2025_09_17_000003_create_pvit_callbacks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('pvit_callbacks', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();            // ex: PAY240420250001
            $table->string('merchant_reference_id')->nullable();     // ex: REF123456
            $table->string('status')->nullable();                    // SUCCESS/FAILED
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('fees', 15, 2)->nullable();
            $table->string('charge_owner')->nullable();              // CUSTOMER/MERCHANT
            $table->string('transaction_operation')->nullable();     // PAYMENT/GIVE_CHANGE
            $table->string('operator')->nullable();
            $table->json('raw_payload')->nullable();                 // trace complète du callback
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pvit_callbacks');
    }
};