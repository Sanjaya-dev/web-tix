<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableArrangeMovieToStudios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('ALTER TABLE `arrange_movie` DROP FOREIGN KEY `arrange_movie_movies_id_foreign`; ALTER TABLE `arrange_movie` ADD CONSTRAINT `studios_movies_id_foreign` FOREIGN KEY (`movies_id`) REFERENCES `movies`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;');
        DB::unprepared('ALTER TABLE `arrange_movie` DROP FOREIGN KEY `arrange_movie_theater_id_foreign`; ALTER TABLE `arrange_movie` ADD CONSTRAINT `studios_theater_id_foreign` FOREIGN KEY (`theater_id`) REFERENCES `theaters`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;');
        
        Schema::table('arrange_movie',function(Blueprint $table){
            $table->renameIndex('arrange_movie_theater_id_foreign','studios_theater_id_foreign');
            $table->renameIndex('arrange_movie_movies_id_foreign','studios_movies_id_foreign');

        });


        Schema::rename('arrange_movie', 'studios');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('studios', 'arrange_movie');

        Schema::table('arrange_movie',function(Blueprint $table){
            $table->renameIndex('studios_theater_id_foreign','arrange_movie_theater_id_foreign');
            $table->renameIndex('studios_movies_id_foreign','arrange_movie_movies_id_foreign');

        });

        DB::unprepared('ALTER TABLE `arrange_movie` DROP FOREIGN KEY `studios_movies_id_foreign`; ALTER TABLE `arrange_movie` ADD CONSTRAINT `arrange_movie_movies_id_foreign` FOREIGN KEY (`movies_id`) REFERENCES `movies`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;');
        DB::unprepared('ALTER TABLE `arrange_movie` DROP FOREIGN KEY `studios_theater_id_foreign`; ALTER TABLE `arrange_movie` ADD CONSTRAINT `arrange_movie_theater_id_foreign` FOREIGN KEY (`theater_id`) REFERENCES `theaters`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;');

    }
}
