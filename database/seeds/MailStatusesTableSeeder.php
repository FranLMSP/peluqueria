<?php

use Illuminate\Database\Seeder;
use App\MailStatus;

class MailStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MailStatus::truncate();

        factory(MailStatus::class)->create([
        	'name' => 'Enviado',
        	'description' => 'Mail ha sido enviado correctamente',
        	'active' => true,
        ]);

        factory(MailStatus::class)->create([
        	'name' => 'No enviado',
        	'description' => 'Ocurrió un error al enviar el mail',
        	'active' => false,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
