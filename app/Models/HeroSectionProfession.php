<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSectionProfession extends Model {
	use HasFactory;

	protected $fillable = [
		'user_id',
		'profession_name',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}
}
