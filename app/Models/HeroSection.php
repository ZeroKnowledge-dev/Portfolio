<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeroSection extends Model {
	use HasFactory;

	protected $fillable = [
		'user_id',
		'website_name',
		'website_logo',
		'person_name',
		'person_image',
		'description',
	];

	protected $nullable = [
		'website_logo',
		'person_image',
	];

	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}
}
