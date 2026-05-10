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
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions(Permission::all());

        $superAdmin = User::firstOrCreate([
            'name' => 'Super Admin',
            'email' => 'admin@cococavanaresort.com',
        ], [
            'password' => bcrypt('admin')
        ]);
        $superAdmin->syncRoles($superAdminRole);

        $defaultRole = Role::firstOrCreate(['name'=> 'User']);
        
        $defaultUser = User::firstOrCreate([
            'name' => 'User',
            'email' => 'user@cococavanaresort.com',
        ], [
            'password' => bcrypt('user')
        ]);
        $defaultUser->syncRoles($defaultRole);
    }
}
