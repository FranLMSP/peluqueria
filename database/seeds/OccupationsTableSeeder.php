<?php

use Illuminate\Database\Seeder;
use App\Occupation;

class OccupationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Occupation::truncate();

        factory(Occupation::class)->create([
        	'name' => 'Peluquero',
        	'description' => 'Encargado de hacer cortes de cabello a los clientes'
        ]);

        factory(Occupation::class)->create([
        	'name' => 'Administrador',
        	'description' => 'Encargado de llevar las cuentas'
        ]);

        factory(Occupation::class)->create([
            'name' => 'Cajero',
            'description' => 'Encargado de cobrarle a los clientes'
        ]);

        factory(Occupation::class)->create([
        	'name' => 'Otro',
        	'description' => 'Ocupación sin especificar'
        ]);
    }
}
