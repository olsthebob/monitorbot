<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('tests', function (Blueprint $table) {
			$table->uuid('id')->primary()->unique();
			$table->uuid('site_id');
      $table->uuid('organisation_id');
      $table->string('test_url')->nullable();
      $table->string('type')->nullable();
			$table->string('element')->nullable();
      $table->boolean('status')->nullable();
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
		Schema::dropIfExists('tests');
    }
}
