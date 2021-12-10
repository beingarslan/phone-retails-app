<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role as Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Role::create(['name' => User::ADMIN_ROLE]);
        $Admin = Role::create(['name' => User::USER_ROLE]);
    }
}
