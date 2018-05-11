<?php

use Illuminate\Database\Seeder;
use App\TransactionType;

class TransactionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TransactionType::truncate();

        factory(TransactionType::class)->create([
        	'name' => 'Recepción',
        	'description' => 'Cuando un producto nuevo es ingresado al stock',
        	'io' => 'I'
        ]);

        factory(TransactionType::class)->create([
            'name' => 'Despacho',
            'description' => 'Cuando un producto es vendido',
            'io' => 'O'
        ]);

        factory(TransactionType::class)->create([
        	'name' => 'Venta',
        	'description' => 'Cuando se realiza una venta a un cliente',
            'sell' => true,
        	'io' => 'O'
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
