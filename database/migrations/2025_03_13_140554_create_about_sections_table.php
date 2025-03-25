<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('about_sections', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

			$table->string('about_image')->nullable();
			$table->string('job_title');
			$table->string('experience_years')->default(1);
			$table->string('gmail');
			$table->string('phone');
			$table->string('address');
			$table->string('work_type');
			$table->string('total_project')->default(1);
			$table->string('total_client')->default(1);
			$table->string('cv')->nullable();
			$table->longText('description');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('about_sections');
	}
};
