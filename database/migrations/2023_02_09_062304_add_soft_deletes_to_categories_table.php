<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            // this mean that we need to update the table we need
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // عكس ما قمنا به في الاب  
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // this will be run when we rollback the database , if we create new column and we do rollback -> this function response of delete the column  
            $table->dropSoftDeletes();
        });
    }
};
