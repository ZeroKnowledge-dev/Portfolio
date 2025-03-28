<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('hero_sections', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

			$table->string('website_name');
			$table->string('website_logo')->nullable();
			$table->string('person_name');
			$table->string('person_image')->nullable();
			$table->longText('description');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('hero_sections');
	}
};
