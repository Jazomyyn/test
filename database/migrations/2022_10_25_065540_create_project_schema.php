<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSchema extends Migration
{
    CONST CATEGORIES = 'categories',
          ITEM_ACTIVITIES = 'items',
          ACTIVITIES = 'activities',
          LIST_ACTIVITIES = 'activities_items',
          RESERVATIONS = 'reservations';



    /**
     * Run the migrations.
     *
     * ****** First catalog tables, then relationated tables
     * @return void
     */
    public function up()
    {
        self::createCatalogTable(self::CATEGORIES);
        self::createCatalogTable(self::ITEM_ACTIVITIES);
        self::createActivitiesTable();
        self::createReservationsTable();
        self::createActivitiesItemsTable();
    }

    /**
     * Reverse the migrations.
     *
     * ****** First catalog tables, then catalog tables
     * @return void
     */
    public function down()
    {
        $drops = [
            self::LIST_ACTIVITIES,
            self::RESERVATIONS,
            self::ACTIVITIES,
            self::ITEM_ACTIVITIES,
            self::CATEGORIES,
        ];

        self::dropTables($drops);

    }

     /**
     * Drop tables section.
     *
     *
     */
    private static function dropTables($arrayTables){
        foreach ($arrayTables as $table){
            Schema::dropIfExists($table);
         }
      }

    /**
     * Create tables section.
     *
     *
     */
    private static function createCatalogTable($tableName){
        Schema::create($tableName,function (Blueprint $table){
            $table->id();
            $table->string('name', 64);
        });
    }

    private static function createActivitiesTable(){
        Schema::create(self::ACTIVITIES,function (Blueprint $table){
            $table->id();
            $table->string('title', 64);
            $table->longText('description');
            $table->date('init_date');
            $table->date('finish_date');
            $table->double('unit_price');
            $table->integer('popularity');
            $table->string('image');
            $table->boolean('active')->default(true);

            $table->unsignedBigInteger('fk_id_category');
            $table->foreign('fk_id_category')->references('id')->on(self::CATEGORIES);
            
            $table->timestamps();
        });
    }

    private static function createReservationsTable(){
        Schema::create(self::RESERVATIONS,function (Blueprint $table){
            $table->id();
            $table->double('total_price');
            $table->integer('quantity_person');
            $table->date('reservation_date');
            $table->date('activity_date');
    
            $table->unsignedBigInteger('fk_id_activity');
            $table->foreign('fk_id_activity')->references('id')->on(self::ACTIVITIES);
        });
    }

    private static function createActivitiesItemsTable(){
        Schema::create(self::LIST_ACTIVITIES,function (Blueprint $table){
            $table->id();
            
            $table->unsignedBigInteger('fk_id_activity');
            $table->foreign('fk_id_activity')->references('id')->on(self::ACTIVITIES);

            $table->unsignedBigInteger('fk_id_item');
            $table->foreign('fk_id_item')->references('id')->on(self::ITEM_ACTIVITIES);
        });
    }

}
