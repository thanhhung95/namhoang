<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    	$this->call(User::class);

    }
}
/**
 *  
 */
class User extends Seeder
{
	
	public function run()
	{
		DB::table('users')->insert([
			['email'=>'phamthanhhung94tn@gmail.com','name'=>'chiperlove1','password'=>bcrypt('123456'),'phone'=>'01627113888','avatar'=>'abc.jpg'],
			['email'=>'phamthanhhung96tn@gmail.com','name'=>'chiperlove2','password'=>bcrypt('anhhuan1'),'phone'=>'01627113888','avatar'=>'abc.jpg'],
			['email'=>'phamthanhhung97tn@gmail.com','name'=>'chiperlove3','password'=>bcrypt('123456'),'phone'=>'01627113888','avatar'=>'abc.jpg'],
			['email'=>'phamthanhhung98tn@gmail.com','name'=>'chiperlove4','password'=>bcrypt('123456'),'phone'=>'01627113888','avatar'=>'abc.jpg'],
		]);
	}
}
