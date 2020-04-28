<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'kuba';
        $user->email = 'kuba@example.com';
        $user->password = bcrypt('d!etetyK');
        $user->save();
    }
}
