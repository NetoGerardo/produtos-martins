<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Container;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@whatsz.com',
            'password' => Hash::make('admin'),
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@whatsz.com',
            'password' => Hash::make('123123123'),
        ]);

        $admin_role = Role::findByName('admin');
        $user_role = Role::findByName('user');

        $admin->assignRole($admin_role);
        $user->assignRole($user_role);
    }
}
