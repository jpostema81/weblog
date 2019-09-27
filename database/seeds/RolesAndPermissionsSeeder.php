<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();

        // create permissions
        $adminPermission = Permission::create(['guard_name' => 'api', 'name' => 'Administer roles & permissions']);

        // create roles
        $userRole = Role::create(['guard_name' => 'api', 'name' => 'user']);
        $adminRole = Role::create(['guard_name' => 'api', 'name' => 'admin']);   

        // assing permissions to roles
        $adminRole->givePermissionTo($adminPermission);
        
        // assign roles to users
        //$user->assignRole('user');  
        User::first()->assignRole('admin'); 
    }
}
