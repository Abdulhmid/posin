<?php

use Illuminate\Database\Seeder;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $connection = \Config::get('database.default');

        if ($connection=="pgsql") {
            /* City and States */
            \DB::statement('TRUNCATE TABLE cities CASCADE');
            \DB::statement('ALTER SEQUENCE cities_city_id_seq RESTART WITH 1;');

            \DB::statement('TRUNCATE TABLE states CASCADE');
            \DB::statement('ALTER SEQUENCE states_state_id_seq RESTART WITH 1;');
        }

        if ($connection=="mysql") {
            \DB::table('states')->insert(
                [
                    'country' => 'ID',
                    'name' => 'Jawa Tengah',
                    'description' =>'description',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]
            );

            \DB::table('cities')->insert(
                [
                    'state_id' => \DB::table('states')->first()->state_id,
                    'name' => 'Klaten',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]
            );

        }else{
            \DB::unprepared(file_get_contents(base_path().'/resources/files/states.sql'));
            \DB::unprepared(file_get_contents(base_path().'/resources/files/cities.sql'));
        }

        \DB::table('clients')->insert(
            [
                'name' => 'Owner',
                'email' => 'owner@email.com',
                'handphone' => '-',
                'telp' => '-',
                'address' => 'Klaten',
                'city_id' => \DB::table('cities')->first()->city_id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );

        \DB::table('outlets')->insert(
            [
                'name' => 'Outlets 1',
                'email' => 'outlets@admin.com',
                'handphone' => '-',
                'telp' => '-',
                'city_id' => \DB::table('cities')->first()->city_id,
                'id_client' => \DB::table('clients')->first()->id,
                'address' => '-',
                'description' => '-',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );

        \DB::table('roles_client')->insert(
            [
                'id_role' => \DB::table('roles')->first()->id,
                'id_client' => \DB::table('clients')->first()->id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );

        \DB::table('users')->insert(
            [
                'username' => 'superadmin',
                'name' => 'Superadmin',
                'email' => 'superadmin@admin.com',
                'password' => bcrypt('12345'),
                'id_role' => \DB::table('roles_client')->first()->id,
                'id_outlet' => \DB::table('outlets')->first()->id,
                'id_client' => \DB::table('clients')->first()->id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );
    }
}
