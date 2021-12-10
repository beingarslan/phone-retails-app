<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        
        
        $user = User::create([
            'name' => $faker->name, 
            'email' => 'user@user.com', 
            'password' => Hash::make('1234567890') 
        ]);
        $user->assignRole(User::USER_ROLE);

        $user = User::create([
            'name' => $faker->name, 
            'email' => 'admin@admin.com', 
            'password' => Hash::make('1234567890') 
        ]);
        $user->assignRole(User::ADMIN_ROLE);

        for ($i=0; $i < rand(10, 15); $i++) { 
            $user = User::create([
                'name' => $faker->name, 
                'email' => $faker->email,
                'password' => Hash::make('1234567890'),
                'status' => rand(0, 1)
            ]);
            $user->assignRole(User::USER_ROLE);
        }
    }
}
