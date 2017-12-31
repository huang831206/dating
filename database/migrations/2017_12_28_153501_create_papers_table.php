<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ch')->nullable();
            $table->string('name_en')->nullable();
            $table->string('school')->nullable();
            $table->string('department')->nullable();
            $table->string('degree')->nullable();
            $table->string('author')->nullable();
            $table->string('teacher')->nullable();
            $table->string('uri')->nullable();  // with prefix: http://ndltd.ncl.edu.tw/r
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('papers');
    }
}
