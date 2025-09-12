<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('pvit_secrets', function (Blueprint $t) {
            $t->id();
            $t->string('account_code')->unique(); // ex: ACC_68B6AA786474B
            $t->longText('secret_encrypted');     // encrypt() avec APP_KEY
            $t->unsignedInteger('expires_in')->nullable();
            $t->dateTime('expires_at')->nullable();
            $t->dateTime('received_at');          // quand MyPVit nous l’a envoyée
            $t->string('source_ip')->nullable();  // IP du callback MyPVit
            $t->unsignedInteger('version')->default(1); // incrément à chaque rotation
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pvit_secrets');
    }
};
