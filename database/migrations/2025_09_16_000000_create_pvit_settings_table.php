<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('pvit_settings', function (Blueprint $table) {
            $table->id();
            // Identifiants fixes fournis par PVit (aucun .env)
            $table->string('merchant_slug')->nullable(); // MR_...
            $table->string('operation_account_code')->nullable(); // ACC_...
            $table->string('renew_password')->nullable(); // password pour /renew-secret
            // Codes d’URL (visibles dans ton espace marchand)
            $table->string('codeurl_renew')->nullable();   // ex: UGCEAAFRYROGTXPH
            $table->string('codeurl_rest')->nullable();    // ex: KJDQ3XD7VBTTCUCL
            $table->string('codeurl_link')->nullable();    // ex: FOSVZOX8OOCJELGS
            $table->string('codeurl_balance')->nullable(); // ex: 1ZM5Q15FPCM0FP61
            $table->string('codeurl_status')->nullable();  // ex: MCKN226GODJ6UPLU

            // Codes spéciaux configurés côté PVit
            $table->string('callback_url_code')->nullable();     // ex: GP7VJ
            $table->string('success_redirect_code')->nullable(); // ex: MMIJA
            $table->string('failed_redirect_code')->nullable();  // ex: IHIU8
            $table->string('secret_reception_code')->nullable(); // ex: GH8CQ (pour /receive-secret)

            // Secret courant & méta
            $table->string('current_secret')->nullable();
            $table->timestamp('secret_expires_at')->nullable();

            // Divers
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pvit_settings');
    }
};