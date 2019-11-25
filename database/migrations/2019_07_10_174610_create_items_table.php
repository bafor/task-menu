<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('items')->onDelete('cascade');
            $table->string('field', 255);
            $table->integer('max_dDepth');
            $table->integer('max_children');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
