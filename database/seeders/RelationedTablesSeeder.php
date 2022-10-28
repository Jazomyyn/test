<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelationedTablesSeeder extends Seeder
{
    protected static $ACTIVITIES= 'activities',
                     $LIST_ACTIVITIES = 'activities_items';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addActivities();
        $this->addItemActivities();
    }

    private function addActivities(){
        $today = Carbon::now();
        DB::table(self::$ACTIVITIES)->insert([
            [   'title' => 'Visita Cancún',
                'description' => "Cancún se ubica en el estado de Quintana Roo y es mundialmente reconocido por sus impresionantes playas de arena blanca que dan hacia el mar caribe con sus distintos tonos de azul turquesa y sus playas cálidas todo el año.",
                'init_date' => Carbon::parse('2022-10-12'),
                'finish_date' => Carbon::parse('2022-10-28'),
                'unit_price' => 200,
                'popularity' => 5,
                'image' => '/img/activities/cancun.jpg',
                'active' => true,
                'fk_id_category' => Category::BEACH,
                'created_at' => $today
            ],
            [   'title' => 'Acapulco Express',
            'description' => "Sal de la rutina y escápate 1 día a disfrutar de las playas y atractivos que este tradicional destino ofrece.",
            'init_date' => Carbon::parse('2022-10-24'),
            'finish_date' => Carbon::parse('2022-11-21'),
            'unit_price' => 100,
            'popularity' => 3,
            'image' => '/img/activities/acapulco.jpg',
            'active' => true,
            'fk_id_category' => Category::FOREST,
            'created_at' => $today
            ],
            [   'title' => 'Avistamiento de Ballenas, Sayulita y Puerto Vallarta',
            'description' => "¡Disfruta de un descanso y grandes aventuras en estos paradisiacos destinos!",
            'init_date' => Carbon::parse('2022-09-08'),
            'finish_date' => Carbon::parse('2022-11-27'),
            'unit_price' => 300,
            'popularity' => 4,
            'image' => '/img/activities/ballena.jpg',
            'active' => true,
            'fk_id_category' => Category::BEACH,
            'created_at' => $today
            ],
            [   'title' => 'Rafting y Puerto Veracruz',
            'description' => "Vive una aventura extrema a bordo de una balsa en el río Pescados - Antigua y vence todos los obstáculos que encuentres en el camino mientras disfrutas de la naturaleza que te rodea.",
            'init_date' => Carbon::parse('2022-10-25'),
            'finish_date' => Carbon::parse('2022-12-24'),
            'unit_price' => 400,
            'popularity' => 2,
            'image' => '/img/activities/veracruz.jpg',
            'active' => true,
            'fk_id_category' => Category::BEACH,
            'created_at' => $today
            ],
            [   'title' => 'Villa del Carbón y Presas',
            'description' => "Vive una experiencia Villa del Carbón, un lugar ideal para pasar un gran momento rodeado de montañas y frondosa vegetación",
            'init_date' => Carbon::parse('2022-10-20'),
            'finish_date' => Carbon::parse('2022-11-12'),
            'unit_price' => 520,
            'popularity' => 1,
            'image' => '/img/activities/villa.jpg',
            'active' => true,
            'fk_id_category' => Category::FOREST,
            'created_at' => $today
            ],
            [   'title' => 'Aventura en Sierra Gorda',
            'description' => "Vive una experiencia increíble en la Reserva de la Biosfera más ecodiversa del país.",
            'init_date' => Carbon::parse('2022-10-20'),
            'finish_date' => Carbon::parse('2022-12-05'),
            'unit_price' => 260,
            'popularity' => 5,
            'image' => '/img/activities/sierra.jpg',
            'active' => true,
            'fk_id_category' => Category::FOREST,
            'created_at' => $today
            ],
            [   'title' => 'Senderismo en Cascadas paraíso',
            'description' => "Conéctate con la naturaleza admirando inigualables cascadas, a través de diversos senderos y puentes colgantes.",
            'init_date' => Carbon::parse('2022-10-24'),
            'finish_date' => Carbon::parse('2022-12-02'),
            'unit_price' => 350,
            'popularity' => 4,
            'image' => '/img/activities/cascada.jpg',
            'active' => true,
            'fk_id_category' => Category::FOREST,
            'created_at' => $today
            ],
            [   'title' => 'Volcanic Park',
            'description' => "Volcanic Park es considerado como el mejor parque de aventura, naturaleza y diversión en México, teniendo como principal objetivo promover el respeto a la naturaleza complementada con experiencias inolvidables.",
            'init_date' => Carbon::parse('2022-10-10'),
            'finish_date' => Carbon::parse('2022-11-30'),
            'unit_price' => 450,
            'popularity' => 3,
            'image' => '/img/activities/fun.jpg',
            'active' => true,
            'fk_id_category' => Category::PARK,
            'created_at' => $today
            ],
            
        ]);
    }

    private function addItemActivities(){
        DB::table(self::$LIST_ACTIVITIES)->insert([
            [   'fk_id_activity' => 1,
                'fk_id_item' => 1
            ],
            [   'fk_id_activity' => 1,
                'fk_id_item' => 2
            ],
            [   'fk_id_activity' => 1,
                'fk_id_item' => 3
            ],
            [   'fk_id_activity' => 1,
                'fk_id_item' => 13
            ],
            [   'fk_id_activity' => 1,
                'fk_id_item' => 14
            ],
            [   'fk_id_activity' => 4,
            'fk_id_item' => 4
            ],
            [   'fk_id_activity' => 4,
            'fk_id_item' => 5
            ],
            [   'fk_id_activity' => 4,
            'fk_id_item' => 8
            ],
            [   'fk_id_activity' => 4,
            'fk_id_item' => 6
            ],
            [   'fk_id_activity' => 5,
            'fk_id_item' => 1
            ],
            [   'fk_id_activity' => 5,
            'fk_id_item' => 2
            ],
            [   'fk_id_activity' => 5,
            'fk_id_item' => 3
            ],
            [   'fk_id_activity' => 5,
            'fk_id_item' => 6
            ],
            [   'fk_id_activity' => 5,
            'fk_id_item' => 13
            ],
            [   'fk_id_activity' => 5,
            'fk_id_item' => 14
            ],
            [   'fk_id_activity' => 6,
            'fk_id_item' => 12
            ],
            [   'fk_id_activity' => 7,
            'fk_id_item' => 4
            ],
            [   'fk_id_activity' => 7,
            'fk_id_item' => 6
            ],
            [   'fk_id_activity' => 8,
            'fk_id_item' => 12
            ],
            [   'fk_id_activity' => 8,
                'fk_id_item' => 11
            ],
            [   'fk_id_activity' => 8,
                'fk_id_item' => 10
            ],
            [   'fk_id_activity' => 8,
                'fk_id_item' => 9
            ],
        ]);
    }
}
