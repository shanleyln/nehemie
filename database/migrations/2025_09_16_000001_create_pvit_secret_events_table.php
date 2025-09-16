<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('pvit_secret_events', function (Blueprint $table) {
            $table->id();
            $table->string('operation_account_code')->nullable();
            $table->string('secret_key')->nullable(); // sk_live_xxx (on garde en clair si tu veux – sinon chiffrer)
            $table->integer('expires_in')->nullable(); // secondes
            $table->json('raw_payload')->nullable();   // trace complète
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pvit_secret_events');
    }
};