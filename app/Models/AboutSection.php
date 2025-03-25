<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model {
	use HasFactory;

	protected $fillable = [
		'user_id',
		'about_image',
		'job_title',
		'experience_years',
		'gmail',
		'phone',
		'address',
		'work_type',
		'total_project',
		'total_client',
		'cv',
		'description',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}
}
