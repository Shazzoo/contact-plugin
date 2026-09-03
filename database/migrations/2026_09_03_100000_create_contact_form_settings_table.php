<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_form_settings', function (Blueprint $table) {
            $table->id();
            $table->string('recipient')->nullable();
            $table->string('subject_prefix')->nullable();
            $table->string('button_label')->nullable();
            $table->text('success_message')->nullable();
            $table->text('privacy_note')->nullable();
            $table->json('fields')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_form_settings');
    }
};
