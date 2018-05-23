<?php

use Illuminate\Database\Seeder;
use App\Commune;

class CommunesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Commune::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //1
		factory(Commune::class)->create([
			'name' => 'Alto Hospicio',
			'region_id' => 1,
		]);

		factory(Commune::class)->create([
			'name' => 'Camiña',
			'region_id' => 1,
		]);

		factory(Commune::class)->create([
			'name' => 'Colchane',
			'region_id' => 1,
		]);

		factory(Commune::class)->create([
			'name' => 'Huara',
			'region_id' => 1,
		]);

		factory(Commune::class)->create([
			'name' => 'Iquique',
			'region_id' => 1,
		]);

		factory(Commune::class)->create([
			'name' => 'Pica',
			'region_id' => 1,
		]);

		factory(Commune::class)->create([
			'name' => 'Pozo Almonte',
			'region_id' => 1,
		]);


		//2
		factory(Commune::class)->create([
			'name' => 'Antofagasta',
			'region_id' => 2,
		]);
		factory(Commune::class)->create([
			'name' => 'Calama',
			'region_id' => 2,
		]);
		factory(Commune::class)->create([
			'name' => 'María Elena',
			'region_id' => 2,
		]);
		factory(Commune::class)->create([
			'name' => 'Mejillones',
			'region_id' => 2,
		]);
		factory(Commune::class)->create([
			'name' => 'Ollagüe',
			'region_id' => 2,
		]);
		factory(Commune::class)->create([
			'name' => 'San Pedro de Atacama',
			'region_id' => 2,
		]);
		factory(Commune::class)->create([
			'name' => 'Sierra Gorda',
			'region_id' => 2,
		]);
		factory(Commune::class)->create([
			'name' => 'Taltal',
			'region_id' => 2,
		]);
		factory(Commune::class)->create([
			'name' => 'Tocopilla',
			'region_id' => 2,
		]);


		//3
		factory(Commune::class)->create([
			'name' => 'Alto del Carmen',
			'region_id' => 3,
		]);
		factory(Commune::class)->create([
			'name' => 'Caldera',
			'region_id' => 3,
		]);
		factory(Commune::class)->create([
			'name' => 'Chañaral',
			'region_id' => 3,
		]);
		factory(Commune::class)->create([
			'name' => 'Copiapó',
			'region_id' => 3,
		]);
		factory(Commune::class)->create([
			'name' => 'Diego de Almagro',
			'region_id' => 3,
		]);
		factory(Commune::class)->create([
			'name' => 'Freirina',
			'region_id' => 3,
		]);
		factory(Commune::class)->create([
			'name' => 'Huasco',
			'region_id' => 3,
		]);
		factory(Commune::class)->create([
			'name' => 'Tierra Amarilla',
			'region_id' => 3,
		]);
		factory(Commune::class)->create([
			'name' => 'Vallenar',
			'region_id' => 3,
		]);


		//4
		factory(Commune::class)->create([
			'name'=> 'Andacollo',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Canela',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Combarbalá',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Coquimbo',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Illapel',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'La Higuera',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'La Serena',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Los Vilos',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Monte Patria',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Ovalle',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Paiguano',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Punitaqui',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Río Hurtado',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Salamanca',
			'region_id' => 4,
		]);
		factory(Commune::class)->create([
			'name'=> 'Vicuña',
			'region_id' => 4,
		]);


		//5
		factory(Commune::class)->create([
			'name' => 'Algarrobo',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Cabildo',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Calera',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Calle Larga',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Cartagena',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Casablanca',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Catemu',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Concón',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'El Quisco',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'El Tabo',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Hijuelas',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Isla de Pascua',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Juan Fernández',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'La Cruz',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'La Ligua',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Limache',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Llaillay',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Los Andes',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Nogales',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Olmué',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Panquehue',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Papudo',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Petorca',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Puchuncaví',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Putaendo',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Quillota',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Quilpué',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Quintero',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Rinconada',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'San Antonio',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'San Esteban',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'San Felipe',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Santa María',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Santo Domingo',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Valparaíso',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Villa Alemana',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Viña del Mar',
			'region_id' => 5,
		]);
		factory(Commune::class)->create([
			'name' => 'Zapallar',
			'region_id' => 5,
		]);


		//6
		factory(Commune::class)->create([
			'name' => 'Chépica',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Chimbarongo',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Codegua',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Coinco',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Coltauco',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Doñihue',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Graneros',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'La Estrella',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Las Cabras',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Litueche',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Lolol',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Machalí',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Malloa',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Marchihue',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Mostazal',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Nancagua',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Navidad',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Olivar',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Palmilla',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Paredones',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Peralillo',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Peumo',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Pichidegua',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Pichilemu',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Placilla',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Pumanque',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Quinta de Tilcoco',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Rancagua',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Rengo',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Requínoa',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'San Fernando',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'San Vicente',
			'region_id' => 6,
		]);
		factory(Commune::class)->create([
			'name' => 'Santa Cruz',
			'region_id' => 6,
		]);


		//7
		factory(Commune::class)->create([
			'name' => 'Cauquenes',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Chanco',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Colbún',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Constitución',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Curepto',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Curicó',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Empedrado',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Hualañé',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Licantén',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Linares',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Longaví',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Maule',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Molina',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Parral',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Pelarco',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Pelluhue',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Pencahue',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Rauco',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Retiro',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Río Claro',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Romeral',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Sagrada Familia',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'San Clemente',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'San Javier',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'San Rafael',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Talca',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Teno',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Vichuquén',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Villa Alegre',
			'region_id' => 7,
		]);
		factory(Commune::class)->create([
			'name' => 'Yerbas Buenas',
			'region_id' => 7,
		]);


		//8
		factory(Commune::class)->create([
			'name' => 'Alto Biobío',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Antuco',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Arauco',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Bulnes',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Cabrero',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Cañete',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Chiguayante',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Chillán',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Chillán Viejo',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Cobquecura',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Coelemu',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Coihueco',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Concepción',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Contulmo',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Coronel',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Curanilahue',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'El Carmen',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Florida',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Hualpén',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Hualqui',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Laja',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Lebu',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Los Álamos',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Los Ángeles',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Lota',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Mulchén',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Nacimiento',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Negrete',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Ninhue',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Ñiquén',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Pemuco',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Penco',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Pinto',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Portezuelo',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Quilaco',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Quilleco',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Quillón',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Quirihue',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Ránquil',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'San Carlos',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'San Fabián',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'San Ignacio',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'San Nicolás',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'San Pedro de la Paz',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'San Rosendo',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Santa Bárbara',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Santa Juana',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Talcahuano',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Tirúa',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Tomé',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Treguaco',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Tucapel',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Yumbel',
			'region_id' => 8,
		]);
		factory(Commune::class)->create([
			'name' => 'Yungay',
			'region_id' => 8,
		]);

		//9
		factory(Commune::class)->create([
			'name' => 'Angol',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Carahue',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Cholchol',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Collipulli',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Cunco',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Curacautín',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Curarrehue',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Ercilla',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Freire',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Galvarino',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Gorbea',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Lautaro',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Loncoche',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Lonquimay',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Los Sauces',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Lumaco',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Melipeuco',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Nueva Imperial',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Padre Las Casas',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Perquenco',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Pitrufquén',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Pucón',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Purén',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Renaico',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Saavedra',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Temuco',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Teodoro Schmidt',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Toltén',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Traiguén',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Victoria',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Vilcún',
			'region_id' => 9,
		]);
		factory(Commune::class)->create([
			'name' => 'Villarrica',
			'region_id' => 9,
		]);


		//10
		factory(Commune::class)->create([
			'name' => 'Ancud',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Calbuco',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Castro',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Chaitén',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Chonchi',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Cochamó',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Curaco de Vélez',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Dalcahue',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Fresia',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Frutillar',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Futaleufú',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Hualaihué',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Llanquihue',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Los Muermos',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Maullín',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Osorno',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Palena',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Puerto Montt',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Puerto Octay',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Puerto Varas',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Puqueldón',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Purranque',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Puyehue',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Queilén',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Quellón',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Quemchi',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Quinchao',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'Río Negro',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'San Juan de la Costa',
			'region_id' => 10,
		]);
		factory(Commune::class)->create([
			'name' => 'San Pablo',
			'region_id' => 10,
		]);


		//11
		factory(Commune::class)->create([
			'name' => 'Aysén',
			'region_id' => 11,
		]);
		factory(Commune::class)->create([
			'name' => 'Chile Chico',
			'region_id' => 11,
		]);
		factory(Commune::class)->create([
			'name' => 'Cisnes',
			'region_id' => 11,
		]);
		factory(Commune::class)->create([
			'name' => 'Cochrane',
			'region_id' => 11,
		]);
		factory(Commune::class)->create([
			'name' => 'Coyhaique',
			'region_id' => 11,
		]);
		factory(Commune::class)->create([
			'name' => 'Guaitecas',
			'region_id' => 11,
		]);
		factory(Commune::class)->create([
			'name' => 'Lago Verde',
			'region_id' => 11,
		]);
		factory(Commune::class)->create([
			'name' => 'O´Higgins',
			'region_id' => 11,
		]);
		factory(Commune::class)->create([
			'name' => 'Río Ibáñez',
			'region_id' => 11,
		]);
		factory(Commune::class)->create([
			'name' => 'Tortel',
			'region_id' => 11,
		]);


		//12
		factory(Commune::class)->create([
			'name' => 'Antártica',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'Cabo de Hornos (Ex - Navarino)',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'Laguna Blanca',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'Natales',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'Porvenir',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'Primavera',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'Punta Arenas',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'Río Verde',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'San Gregorio',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'Timaukel',
			'region_id' => 12,
		]);
		factory(Commune::class)->create([
			'name' => 'Torres del Paine',
			'region_id' => 12,
		]);

		//13
		factory(Commune::class)->create([
			'name' => 'Alhué',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Buin',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Calera de Tango',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Cerrillos',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Cerro Navia',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Colina',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Conchalí',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Curacaví',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'El Bosque',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'El Monte',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Estación Central',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Huechuraba',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Independencia',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Isla de Maipo',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'La Cisterna',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'La Florida',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'La Granja',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'La Pintana',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'La Reina',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Lampa ',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Las Condes',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Lo Barnechea',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Lo Espejo',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Lo Prado',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Macul',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Maipú',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'María Pinto',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Melipilla',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Ñuñoa',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Padre Hurtado',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Paine',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Pedro Aguirre Cerda',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Peñaflor',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Peñalolén',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Pirque',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Providencia',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Pudahuel',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Puente Alto',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Quilicura',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Quinta Normal',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Recoleta',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Renca',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'San Bernardo',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'San Joaquín',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'San José de Maipo',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'San Miguel',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'San Pedro',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'San Ramón',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Santiago',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Talagante',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Tiltil',
			'region_id' => 13,
		]);
		factory(Commune::class)->create([
			'name' => 'Vitacura',
			'region_id' => 13,
		]);


		//14
		factory(Commune::class)->create([
			'name' => 'Corral',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Futrono',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'La Unión',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Lago Ranco',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Lanco',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Los Lagos',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Máfil',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Mariquina',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Paillaco',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Panguipulli',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Río Bueno',
			'region_id' => 14,
		]);
		factory(Commune::class)->create([
			'name' => 'Valdivia',
			'region_id' => 14,
		]);


		//15
		factory(Commune::class)->create([
			'name' => 'Arica',
			'region_id' => 15,
		]);
		factory(Commune::class)->create([
			'name' => 'Camarones',
			'region_id' => 15,
		]);
		factory(Commune::class)->create([
			'name' => 'General Lagos',
			'region_id' => 15,
		]);
		factory(Commune::class)->create([
			'name' => 'Putre',
			'region_id' => 15,
		]);
    }
}
