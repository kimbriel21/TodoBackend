<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seedOauthClientAccess();
        $this->seedAdminUser();
        // $this->call(UsersTableSeeder::class);
    }

    private function seedOauthClientAccess(): void
    {
        DB::table('oauth_clients')->insert([
            'name' => 'Laravel Password Grant Client',
            'secret' => 'PqEJf38eARKR9RqwSZyg25e8slQdXvKIRgPXjbz3',
            'redirect' => 'http://localhost	',
            'personal_access_client' => '0',
            'password_client' => '1',
            'revoked' => '0',
        ]);
    }

    private function seedAdminUser(): void
    {
        factory(\App\User::class)->create([
            'name' => 'cia',
            'email' => 'cia@gmail.com',
            'crypt' => Crypt::encrypt('Godisgood'),
            'password' => Hash::make('Godisgood'),
            'is_admin' => '1']);
    }
}
