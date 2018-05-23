<?php

use Illuminate\Database\Seeder;
use App\Region;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Region::truncate();

        factory(Region::class)->create([
        	'name' => 'I- Tarapacá'
        ]);
        factory(Region::class)->create([
        	'name' => 'II- Antofagasta'
        ]);
        factory(Region::class)->create([
        	'name' => 'III- Atacama'
        ]);
        factory(Region::class)->create([
        	'name' => 'IV- Coquimbo'
        ]);
        factory(Region::class)->create([
        	'name' => 'V- Valparaíso'
        ]);
        factory(Region::class)->create([
        	'name' => 'VI- Lib.Gral. Bdo.O´Higgins'
        ]);
        factory(Region::class)->create([
        	'name' => 'VII- Región del Maule'
        ]);
        factory(Region::class)->create([
        	'name' => 'VIII- Región del Bio-bio'
        ]);
        factory(Region::class)->create([
        	'name' => 'IX- La Araucanía'
        ]);
        factory(Region::class)->create([
        	'name' => 'X- Región de Los Lagos'
        ]);
        factory(Region::class)->create([
        	'name' => 'XI- Aysén del Gral.Carlos Ibáñez del Campo'
        ]);
        factory(Region::class)->create([
        	'name' => 'XII- Magallanes y Antártica'
        ]);
        factory(Region::class)->create([
        	'name' => 'RM- Metropolitana'
        ]);
        factory(Region::class)->create([
        	'name' => 'XIV- Región de Los Ríos'
        ]);
        factory(Region::class)->create([
        	'name' => 'XV- Arica y Parinacota'
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
