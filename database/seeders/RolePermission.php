<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create Permission
        $permission = Permission::firstOrCreate(['name' => 'view dashboard']);
        $permission = Permission::create(['name' => 'view cr']);
        $permission = Permission::create(['name' => 'edit cr']);
        $permission = Permission::create(['name' => 'delete cr']);
        $permission = Permission::create(['name' => 'submit cr']);

        $permission = Permission::create(['name' => 'view wo']);
        $permission = Permission::create(['name' => 'delete wo']);
        $permission = Permission::create(['name' => 'submit wo']);
        $permission = Permission::create(['name' => 'edit wo']);

        $permission = Permission::create(['name' => 'view cr_ap']); 
        $permission = Permission::create(['name' => 'approve cr_ap']);

        $permission = Permission::create(['name' => 'view mr']);
        $permission = Permission::create(['name' => 'edit mr']);
        $permission = Permission::create(['name' => 'delete mr']);
        $permission = Permission::create(['name' => 'submit mr']);

        $permission = Permission::create(['name' => 'view mr_ap']);
        $permission = Permission::create(['name' => 'approve mr_ap']);
        
        $admin = Role::create(['name' => 'Admin']);

        $cr = Role::create(['name' => 'cr']);
        $cr_ap = Role::create(['name' => 'cr_ap']);

        $mr = Role::create(['name' => 'mr']);
        $mr_ap = Role::create(['name' => 'mr_ap']);

        $wo = Role::create(['name' => 'wo']);
        $wo_ap = Role::create(['name' => 'wo_ap']);

        // $admin->givePermissionTo('view dashboard', 'view cr', 'edit cr', 'delete cr', 'submit cr','view mr','view wo','view mr_ap','view cr_ap');

        $cr->givePermissionTo('view cr', 'edit cr', 'delete cr', 'submit cr');
        $cr_ap->givePermissionTo('view cr_ap', 'approve cr_ap');

        $mr->givePermissionTo('edit mr', 'view mr', 'delete mr', 'submit mr');
        $mr_ap->givePermissionTo('view mr_ap', 'approve mr_ap');

        $wo->givePermissionTo('view wo', 'edit wo', 'delete wo', 'submit wo');

          // Custom roles
        $superCreator = Role::firstOrCreate(['name' => 'SuperAdminCreator']);
        $superApprover = Role::firstOrCreate(['name' => 'SuperAdminApprover']);

        // Assign permissions to SuperAdminCreator
        $superCreator->givePermissionTo([
            'view cr', 'edit cr', 'delete cr', 'submit cr',
            'view wo', 'edit wo', 'delete wo', 'submit wo',
            'view mr', 'edit mr', 'delete mr', 'submit mr',
        ]);

        // Assign permissions to SuperAdminApprover
        $superApprover->givePermissionTo([
            'view cr_ap', 'approve cr_ap',
            'view mr_ap', 'approve mr_ap',
        ]);
    }
}   
