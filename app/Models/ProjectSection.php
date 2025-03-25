<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSection extends Model {
	use HasFactory;

	protected $fillable = [
		'user_id',
		'project_name',
		'project_category',
		'technology_used',
		'live_demo_link',
		'additional_link',
		'project_description',
		'project_image',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}
}
