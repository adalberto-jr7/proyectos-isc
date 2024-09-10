<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activity_types = [
            'Concursos',
            'Convocatorias',
            'Premios artísticos y culturales',
            'Congresos y conferencias',
            'Cursos y talleres',
            'Diplomados y seminarios',
            'Divulgación artística y cultural',
            'Encuentros artísticos y culturales',
            'Exposiciones, bienales y muestras',
            'Fomento a la cultura',
            'Foros',
            'Giras y presentaciones artísticas',
            'Industria cultural',
            'Investigaciones artísticas y culturales',
            'Muestras de cine',
            'Programas Culturales de Fiestas y Ferias',
            'Otros',
        ];
        foreach($activity_types as $at)
        {
            DB::table('activity_types')->insert([
                'name' => $at
            ]);
        }
    }
}
