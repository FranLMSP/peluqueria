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
        Company::truncate();

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
