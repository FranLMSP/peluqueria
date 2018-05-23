<?php

use Illuminate\Database\Seeder;
use App\CalendarStatus;

class CalendarStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CalendarStatus::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(CalendarStatus::class)->create([
        	'name' => 'Confirmado',
        	'description' => 'Cita confirmada',
        	'active' => true
        ]);

        factory(CalendarStatus::class)->create([
        	'name' => 'No confirmado',
        	'description' => 'Cita aun no confirmada',
        	'active' => false
        ]);

        factory(CalendarStatus::class)->create([
        	'name' => 'Hora cancelada',
        	'description' => 'Cita con la hora no fija',
        	'active' => false
        ]);

        factory(CalendarStatus::class)->create([
        	'name' => 'Confirmado por email',
        	'description' => 'Cita confirmada por email',
        	'active' => true
        ]);

        factory(CalendarStatus::class)->create([
        	'name' => 'Cancelado por email',
        	'description' => 'Cita cancelada por email',
        	'active' => false
        ]);

        factory(CalendarStatus::class)->create([
        	'name' => 'Atendido',
        	'description' => 'Cita ya atendida',
        	'active' => true
        ]);
    }
}
