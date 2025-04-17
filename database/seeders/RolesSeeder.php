<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Modules\User\Enums\UserType;
use Modules\User\Models\Role;

class RolesSeeder extends Seeder
{
    private static array $OUTPUT_TABLE_HEADERS = [
        '#',
        'Name',
        'Guard',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [];

        Collection::make(UserType::cases())
            ->each(
                static function (UserType $userType) use (&$roles): void {
                    $roles[] = Role::firstOrCreate(
                        [
                            'name' => $userType->value,
                            'guard_name' => $userType->getDefaultGuard(),
                        ]
                    );
                },
            );

        $this->command->getOutput()->comment('<info>Newly created roles</info>');
        $this->command->getOutput()->table(
            self::$OUTPUT_TABLE_HEADERS,
            array_map(
                static fn (Role $role): array => [
                    $role->id,
                    $role->name,
                    $role->guard_name,
                ],
                $roles,
            ),
        );
    }
}
