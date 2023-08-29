<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $roles = [
            'Superadmin',
            'Admin',
            'Moderator',
            'Editor',
            'Superuser',
            'User',
            'Guest'
        ];

        foreach ($roles as $index => $role) {
            $newRole = new Role();
            $newRole->name = $role;
            $newRole->level = $index + 1;
            $newRole->save();
        }
        //
    }
}
