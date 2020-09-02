<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name')->unique();
            $table->string('location');
            $table->integer('area_in_bigha');
            $table->integer('company_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::table('projects', function (Blueprint $table) {
        
        //     $table->foreign('company_id')
        //     ->references('company_id')
        //     ->on('companies')
        //     ->onDelete('cascade');;
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
