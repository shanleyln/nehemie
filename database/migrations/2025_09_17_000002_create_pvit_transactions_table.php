<?php

// database/migrations/2025_09_17_000002_create_pvit_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('pvit_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('request_type')->nullable();        // REST or LINK
            $table->string('service')->nullable();             // RESTFUL / WEB / VISA_MASTERCARD / RESTLINK
            $table->string('transaction_type')->nullable();    // PAYMENT / GIVE_CHANGE
            $table->string('reference')->nullable();           // merchant reference (max 15)
            $table->string('reference_id')->nullable();        // PVit reference_id (ex: PAY2404...)
            $table->string('status')->nullable();              // PENDING/SUCCESS/FAILED/AMBIGUOUS
            $table->string('operator')->nullable();            // MOOV_MONEY / AIRTEL_MONEY / etc.
            $table->string('merchant_operation_account_code')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('customer_account_number')->nullable();
            $table->string('owner_charge')->nullable();        // MERCHANT/CUSTOMER
            $table->string('operator_owner_charge')->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pvit_transactions');
    }
};
