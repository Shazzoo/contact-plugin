<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * A site used to have one form, configured on a settings page. It can have as
 * many as it likes now, each placed by its own block, so the settings table
 * becomes a table of forms: a name to recognise it by, a key for the block to
 * point at, and the submissions attributed to the form they came from.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('contact_form_settings', 'contact_forms');

        Schema::table('contact_forms', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('key')->nullable()->after('name');
        });

        // De bestaande instellingen zijn het eerste formulier. De sleutel is
        // vast: blokken die nog geen keuze hebben vallen hierop terug.
        DB::table('contact_forms')->whereNull('key')->update([
            'name' => 'Contact',
            'key' => 'contact',
        ]);

        Schema::table('contact_forms', function (Blueprint $table) {
            $table->string('key')->nullable(false)->unique()->change();
            $table->string('name')->nullable(false)->change();
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->foreignId('contact_form_id')
                ->nullable()
                ->after('id')
                ->constrained('contact_forms')
                ->nullOnDelete();
        });

        // Alles wat er al ligt, kwam van het enige formulier dat er was.
        if (($first = DB::table('contact_forms')->orderBy('id')->value('id')) !== null) {
            DB::table('contact_submissions')->whereNull('contact_form_id')->update([
                'contact_form_id' => $first,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('contact_form_id');
        });

        Schema::table('contact_forms', function (Blueprint $table) {
            $table->dropUnique(['key']);
            $table->dropColumn(['name', 'key']);
        });

        Schema::rename('contact_forms', 'contact_form_settings');
    }
};
