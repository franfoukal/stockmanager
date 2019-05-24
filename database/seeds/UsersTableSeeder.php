<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();
        $employeeRole = Role::where('name', 'employee')->first();

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')

        ]);

        $user = User::create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('user')

        ]);
        $employee = User::create([
            'name' => 'employee',
            'email' => 'employee@employee.com',
            'password' => bcrypt('employee')

        ]);

        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
        $employee->roles()->attach($employeeRole);
        
    }
}
