<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->delete();

		$users = array(
			array(
					'name' => 'Admin',
					'email' => 'admin@app.com',
					'email_verified_at' => NULL,
					'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',		//password
					'remember_token' => 'Q968kHJq1cdlBjjPgnxvfyINaGH7grEwRTpcDD7V4mNtIvWFJk7LP9tVWqOS'
				)
		);

		DB::table('users')->insert($users);
    }
}
