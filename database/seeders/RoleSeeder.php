<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_superadmin = Role::create(['name' => 'superadmin']);
        $role_admin = Role::create(['name' => 'admin']);
        $role_interview = Role::create(['name' => 'interview']);
        $role_bendahara = Role::create(['name' => 'bendahara']);
        $role_anggota = Role::create(['name' => 'anggota']);
        $role_user = Role::create(['name' => 'non-anggota']);

        $permission = Permission::create(['name' => 'view user']);
        $permission = Permission::create(['name' => 'edit user']);
        $permission = Permission::create(['name' => 'view menu']);
        $permission = Permission::create(['name' => 'view meeting']);
        $permission = Permission::create(['name' => 'edit meeting']);
        $permission = Permission::create(['name' => 'view pengajuan']);
        $permission = Permission::create(['name' => 'edit pengajuan']);
        $permission = Permission::create(['name' => 'iuran']);
        $permission = Permission::create(['name' => 'view pembayaran']);
        $permission = Permission::create(['name' => 'edit pembayaran']);
        $permission = Permission::create(['name' => 'submission anggota']);
        $permission = Permission::create(['name' => 'submission nonanggota']);
        $permission = Permission::create(['name' => 'edit susunan']);
        $permission = Permission::create(['name' => 'change role']);
        $permission = Permission::create(['name' => 'delete data']);

        $role_superadmin->givePermissionTo('view user');
        $role_superadmin->givePermissionTo('edit user');
        $role_superadmin->givePermissionTo('view menu');
        $role_superadmin->givePermissionTo('view pengajuan');
        $role_superadmin->givePermissionTo('edit pengajuan');
        $role_superadmin->givePermissionTo('view meeting');
        $role_superadmin->givePermissionTo('edit meeting');
        $role_superadmin->givePermissionTo('view pembayaran');
        $role_superadmin->givePermissionTo('edit susunan');
        $role_superadmin->givePermissionTo('change role');
        $role_superadmin->givePermissionTo('delete data');

        $role_admin->givePermissionTo('view user');
        $role_admin->givePermissionTo('edit user');
        $role_admin->givePermissionTo('view menu');
        $role_admin->givePermissionTo('view pengajuan');
        $role_admin->givePermissionTo('edit pengajuan');
        $role_admin->givePermissionTo('view meeting');
        $role_admin->givePermissionTo('edit meeting');
        $role_admin->givePermissionTo('iuran');
        $role_admin->givePermissionTo('view pembayaran');
        $role_admin->givePermissionTo('submission anggota');
        $role_admin->givePermissionTo('edit susunan');

        $role_interview->givePermissionTo('view user');
        $role_interview->givePermissionTo('iuran');
        $role_interview->givePermissionTo('view menu');
        $role_interview->givePermissionTo('view pengajuan');
        $role_interview->givePermissionTo('view meeting');
        $role_interview->givePermissionTo('edit meeting');
        $role_interview->givePermissionTo('submission anggota');

        $role_bendahara->givePermissionTo('view user');
        $role_bendahara->givePermissionTo('iuran');
        $role_bendahara->givePermissionTo('view menu');
        $role_bendahara->givePermissionTo('edit pembayaran');
        $role_bendahara->givePermissionTo('submission anggota');

        $role_anggota->givePermissionTo('iuran');
        $role_anggota->givePermissionTo('submission anggota');

        $role_user->givePermissionTo('submission nonanggota');
    }
}
