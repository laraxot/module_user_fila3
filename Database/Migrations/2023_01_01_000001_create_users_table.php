<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateLiveuserUsersTable.
 */
class CreateUsersTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->uuid('id')->primary();

                $table->string('name'); // questo e' il nickname non nome
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->foreignId('current_team_id')->nullable();
                $table->string('profile_photo_path', 2048)->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('first_name')) {
                    $table->string('first_name')->after('name');
                }
                if (! $this->hasColumn('last_name')) {
                    $table->string('last_name')->after('name');
                }

                if (! $this->hasColumn('current_team_id')) {
                    $table->foreignId('current_team_id')->nullable();
                }

                if (! $this->hasColumn('profile_photo_path')) {
                    $table->string('profile_photo_path', 2048)->nullable();
                }

                if (! $this->hasColumn('lang')) {
                    $table->string('lang', 3)->nullable();
                }

                if (! $this->hasColumn('is_active')) {
                    $table->boolean('is_active')->default(true);
                }
                if (! $this->hasColumn('deleted_at')) {
                    $table->softDeletes();
                }

                $this->updateUser($table);
            }
        );
    }
}