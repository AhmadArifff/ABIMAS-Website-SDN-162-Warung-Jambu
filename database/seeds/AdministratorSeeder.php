<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\User;
        $admin->name        = "Administrator";
        $admin->email       = "admin@gmail.com";
        $admin->role        = "admin";
        $admin->password    = \Hash::make("admin");
        $admin->save();
        $this->command->info("User Admin berhasil diinsert");

        $test = new \App\User;
        $test->name         = "guru";
        $test->email        = "guru@gmail.com";
        $test->role         = "guru";
        $test->password     = \Hash::make("guru");
        $test->save();
        $this->command->info("User Test berhasil diinsert");
    }
}
