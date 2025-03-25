<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSectionSkills extends Model {
	use HasFactory;

	protected $fillable = [
		'user_id',
		'skill_name',
		'skill_percentage',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}
}
