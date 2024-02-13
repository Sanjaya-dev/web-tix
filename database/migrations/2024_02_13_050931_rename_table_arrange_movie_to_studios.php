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
        Schema::table('arrange_movie',function(Blueprint $table){
            $table->renameIndex('studios_theater_id_foreign','arrange_movie_theater_id_foreign');
            $table->renameIndex('studios_movies_id_foreign','arrange_movie_movies_id_foreign');

        });

        Schema::rename('studios', 'arrange_movie');
    }
}
