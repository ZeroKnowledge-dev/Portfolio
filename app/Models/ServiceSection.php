<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSection extends Model {
	use HasFactory;

	protected $fillable = [
		'user_id',
		'service_name',
		'service_description',
		'service_icon_class',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}
}
