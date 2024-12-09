<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentTasksLocTable extends Migration
{

    /**
     * The meaning of the columns in the table
     * 
     * - The run_time column is used to capture the actual time when the tool is running (when the change file is obtained, it indicates that the tool has run). 
     * (The update_date column is not used because the time recorded may not be accurate compared to the actual time measured.)
     *
     * - The update_date column will be used to check the timestamp at step 2 when updating a large volume of data.
     * 
     */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_tasks_loc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('index_key_id');
            $table->smallInteger('project_type');
            $table->string('number_task');
            $table->smallInteger('status');
            $table->smallInteger('source_type');
            $table->smallInteger('file_change');
            $table->smallInteger('php');
            $table->smallInteger('js');
            $table->smallInteger('css');
            $table->smallInteger('tpl');
            $table->smallInteger('total');
            $table->string('branch')->nullable(true);
            $table->string('notes')->nullable(true);
            $table->string('path')->nullable(true);
            $table->string('run_time')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('index_key_id')->references('id')->on('index_keys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parent_tasks_loc');
    }
}
