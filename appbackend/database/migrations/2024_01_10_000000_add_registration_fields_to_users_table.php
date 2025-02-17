<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, add new columns
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->boolean('has_completed_questionnaire')->default(false)->after('avatar');
            $table->timestamp('last_login_at')->nullable()->after('has_completed_questionnaire');
            $table->string('registration_ip')->nullable()->after('last_login_at');
            $table->string('registration_source')->nullable()->after('registration_ip');
            $table->json('preferences')->nullable()->after('registration_source');
        });

        // Then, copy existing name data to first_name and last_name
        DB::table('users')->whereNotNull('name')->chunk(100, function ($users) {
            foreach ($users as $user) {
                $nameParts = explode(' ', $user->name);
                $firstName = $nameParts[0];
                $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'registration_source' => $user->google_id ? 'google' : 'email'
                    ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, copy first_name and last_name back to name
        DB::table('users')->whereNotNull('first_name')->chunk(100, function ($users) {
            foreach ($users as $user) {
                $fullName = trim($user->first_name . ' ' . $user->last_name);
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['name' => $fullName]);
            }
        });

        // Then drop the new columns
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'has_completed_questionnaire',
                'last_login_at',
                'registration_ip',
                'registration_source',
                'preferences'
            ]);
        });
    }
};
