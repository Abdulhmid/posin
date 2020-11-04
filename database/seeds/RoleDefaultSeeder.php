<?php

use Illuminate\Database\Seeder;

class RoleDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('clients')->delete();
        \DB::table('roles_client')->delete();
        \DB::table('users')->delete();
    	\DB::table('roles')->delete();
        \DB::table('roles')->insert(
            [
                'label' => 'superadmin',
                'name' => 'Superadmin',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );

        \DB::table('roles')->insert(
            [
                'label' => 'admin',
                'name' => 'Admin',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );
        \DB::table('roles')->insert(
            [
                'label' => 'cashier',
                'name' => 'Kasir',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );
    }
}
