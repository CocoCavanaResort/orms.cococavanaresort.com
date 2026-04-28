<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name' => 'superadmin']);
        $superAdminRole->syncPermissions(Permission::all());

        $superAdmin = User::create([
            'name' => 'superadmin',
            'email' => 'admin@cococavanaresort.com',
            'password' => bcrypt('admin')
        ]);
        $superAdmin->syncRoles($superAdminRole);
    }
}
