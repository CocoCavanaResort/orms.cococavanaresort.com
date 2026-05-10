<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ["name"=> "manage-booking", "guard_name" => "web"],
            ["name"=> "access-system-settings", "guard_name" => "web"],
            ["name"=> "manage-branches", "guard_name" => "web"],
            ["name"=> "manage-rooms", "guard_name" => "web"],
            ["name"=> "manage-users", "guard_name" => "web"],
            ["name"=> "manage-roles", "guard_name" => "web"],
            ["name"=> "manage-permissions", "guard_name" => "web"],
        ];

        Permission::insertOrIgnore($permissions);
    }
}
