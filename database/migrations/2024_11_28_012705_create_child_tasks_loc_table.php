<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildTasksLocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_tasks_loc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');
            $table->smallInteger('project_type');
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
            $table->foreign('parent_id')->references('id')->on('loc_parents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_tasks_loc');
    }
}
