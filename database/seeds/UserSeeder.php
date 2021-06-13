<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => bcrypt(12345678),
            'level' => 'Admin',
            'id_posko' => null,
        ]);

        $user->createToken('LogistikBrebes')->accessToken;
    }
}
