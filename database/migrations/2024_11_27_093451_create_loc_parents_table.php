<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loc_parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('index_key_id');
            $table->smallInteger('project_type');
            $table->smallInteger('number_task');
            $table->smallInteger('status');
            $table->smallInteger('source_type');
            $table->smallInteger('file_change');
            $table->smallInteger('php');
            $table->smallInteger('js');
            $table->smallInteger('css');
            $table->smallInteger('tpl');
            $table->smallInteger('total');
            $table->string('branch');
            $table->string('notes');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('index_key_id')->references('id')->on('index_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loc_parents');
    }
}