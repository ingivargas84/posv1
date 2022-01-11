<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\User;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		$this->call('UserTableSeeder');
		$this->command->info('User table seeded!');
	}
}

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        User::create([
        	'name' => 'admin',
        	'email' => 'admin@pos.com',
        	'password' => bcrypt('admin'),
        	'remember_token' => '',
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now()
        	]);
    }
}
