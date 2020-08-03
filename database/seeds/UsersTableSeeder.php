<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('popo97');
        $user->save();

        $users = [];

        $password = Hash::make('popo97');

        for ($i = 0; $i < 40; $i++) {
            $name = $faker->name;

            $user = [
                'name' => $name,
                'email' => sprintf('%s@%s', $name, $faker->safeEmailDomain),
                'password' => $password,
                'created_at' => now(),
                'updated_at' => now()
            ];

            array_push($users, $user);
        }

        DB::table('users')->insert($users);
    }
}
