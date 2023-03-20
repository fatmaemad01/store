<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            /*
            Any id must be BIGINT  UNSIGNED  AUTO_INCREMENT  PRIMARY. 
            We Can Define id by 4 way , all do same thing :
            1- $table->bigInteger('id')->unsigned()->autoIncrement();
            2- $table->unsignedBigInteger('id')->autoIncrement();
            3- $table->bigIncrements('id');
            4- $table->id();   
            */
            $table->id();

            /* 
            $table->unsignedBigInteger('parent_id')->nullable();// here we define the column
            $table->foreign('parent_id')     // here we define relation
            ->references('id')         // foreign to the id column
            ->on('categories')
            ->onDelete('restrict')      // to don't allow delete primary key related with another foreign key (this is default state)
            ->onUpdate('restrict')
            ;        // from categories table
            */
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories', 'id')
                ->NullOnDelete()
                ->NullOnUpdate();

            // name VARCHAR(255) NOT NULL 
            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description')->nullable();
            $table->string('image')->nullable();

            /* 
            TIMESTAMP Method create 2 auto_column :
            -- created_at  type=> TIMESTAMP 
            -- updated_at  type=> TIMESTAMP  
            */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};