<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AboutSkillsController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\HeroProfessionController;
use App\Http\Controllers\HeroSkillsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Models\AboutSection;
use App\Models\AboutSectionSkills;
use App\Models\HeroSection;
use App\Models\HeroSectionProfession;
use App\Models\HeroSectionSkills;
use App\Models\ProjectSection;
use App\Models\ServiceSection;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
	return Inertia::render('Welcome', [
		'canLogin'       => Route::has('login'),
		'canRegister'    => Route::has('register'),
		'laravelVersion' => Application::VERSION,
		'phpVersion'     => PHP_VERSION,
	]);
});

Route::get('/dashboard', function () {
	return Inertia::render('Dashboard', [
		'user'   => User::where('id', Auth::id())->first(),
		'appURL' => env('APP_URL'),
	]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/portfolio/{random_key}', function () {
	$random_key = request('random_key');

	$id = User::where('random_key', $random_key)->first()->id;
	return Inertia::render('Portfolio', [
		'heroSection'            => HeroSection::where('user_id', $id)->first(),
		'heroSectionSkills'      => HeroSectionSkills::where('user_id', $id)->get(),
		'heroSectionProfessions' => HeroSectionProfession::where('user_id', $id)->get(),
		'aboutSection'           => AboutSection::where('user_id', $id)->first(),
		'aboutSectionSkills'     => AboutSectionSkills::where('user_id', $id)->get(),
		'projectSection'         => ProjectSection::where('user_id', $id)->get(),
		'serviceSection'         => ServiceSection::where('user_id', $id)->get(),
	]);
});

// Recourse Route

Route::middleware('auth')->group(function () {
	Route::resource('hero', HeroController::class)->only('index', 'store');
	Route::resource('hero-profession', HeroProfessionController::class)->only('index', 'store', 'update', 'destroy');
	Route::resource('hero-skill', HeroSkillsController::class)->only('index', 'store', 'update', 'destroy');
	Route::resource('about', AboutController::class)->only('index', 'store');
	Route::resource('about-skill', AboutSkillsController::class)->only('index', 'store', 'update', 'destroy');
	Route::resource('project', ProjectController::class)->only('index', 'store', 'update', 'destroy');
	Route::resource('service', ServiceController::class)->only('index', 'store', 'update', 'destroy');
});

require __DIR__ . '/auth.php';
