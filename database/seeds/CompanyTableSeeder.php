<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Company::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(Company::class)->create([
        	'main' => true,
        	'name' => 'Peluquería',
        	'email' => 'admin@root.com',
        	'phone' => '+0',
        	'secondary_phone' => NULL,
        	'image' => NULL,
        	'website' => 'peluqueria.com',
        	'shortname' => 'Peluqueria',
        	'commune_id' => 1,
        	'boxes' => 30,
        	'color' => '#FFFFFF',
        	'address' => 'Calle 1',
        ]);
    }
}
