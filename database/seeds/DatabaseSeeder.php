<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->callSeeders([
        	UsersTableSeeder::class
        ]);
    }

    private function callSeeders(array $classes)
    {
    	foreach ($classes as $class) {
    		$this->call($class);
    	}
    }
}
