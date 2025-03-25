<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	/** @use HasFactory<\Database\Factories\UserFactory> */
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var list<string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'random_key',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var list<string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array {
		return [
			'email_verified_at' => 'datetime',
			'password'          => 'hashed',
		];
	}

	public function heroSection() {
		return $this->hasOne(HeroSection::class);
	}

	public function heroSectionSkills(): HasMany {
		return $this->hasMany(HeroSectionSkills::class);
	}

	public function heroSectionProfessions(): HasMany {
		return $this->hasMany(HeroSectionProfession::class);
	}

	public function aboutSection() {
		return $this->hasOne(AboutSection::class);
	}

	public function aboutSectionSkills(): HasMany {
		return $this->hasMany(AboutSectionSkills::class);
	}

	public function serviceSection(): HasMany {
		return $this->hasMany(ServiceSection::class);
	}

	public function projectSection(): HasMany {
		return $this->hasMany(ProjectSection::class);
	}
}
