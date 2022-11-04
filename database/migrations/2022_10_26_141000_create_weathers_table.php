<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeathersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weathers', function (Blueprint $table) {
            $table->id();
            $table->string("lat", 50);
            $table->string("lon", 50);
            $table->string("timezone", 50);
            $table->integer("pressure");
            $table->integer("humidity");
            $table->integer("wind_speed");

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
        Schema::dropIfExists('weather');
    }
}
