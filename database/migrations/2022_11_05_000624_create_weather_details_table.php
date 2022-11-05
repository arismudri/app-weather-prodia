<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("weather_id")->nullable();
            $table->foreign("weather_id")->references("id")->on("weathers")->onUpdate("cascade")->onDelete("restrict");
            $table->integer("weather_detail_id");
            $table->string("main", 50);
            $table->string("description", 100);

            $table->unsignedBigInteger("created_by")->nullable();
            $table->foreign("created_by")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->foreign("updated_by")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
            $table->unsignedBigInteger("deleted_by")->nullable();
            $table->foreign("deleted_by")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_details');
    }
}
