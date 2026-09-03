<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Fields are configured in the admin now, so an answer no longer maps to a
 * fixed column. Existing rows keep their content: the old columns are folded
 * into the payload before they are dropped.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->json('data')->nullable()->after('id');
        });

        DB::table('contact_submissions')->orderBy('id')->each(function ($row) {
            DB::table('contact_submissions')->where('id', $row->id)->update([
                'data' => json_encode(array_filter([
                    'name' => $row->name ?? null,
                    'email' => $row->email ?? null,
                    'phone' => $row->phone ?? null,
                    'subject' => $row->subject ?? null,
                    'message' => $row->message ?? null,
                ], fn ($value) => $value !== null && $value !== '')),
            ]);
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropColumn(['phone', 'message']);
        });

        // Name, e-mail and subject survive as denormalised columns: the admin
        // list and the mail's reply-to need them without unpacking the payload.
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
            $table->dropColumn('data');
        });
    }
};
