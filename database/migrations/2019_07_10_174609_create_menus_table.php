<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('max_depth');
            $table->integer('max_children');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
