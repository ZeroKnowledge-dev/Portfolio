<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HeroController extends Controller {
	/**
	 * Display a listing of the resource.
	 */
	public function index() {
		$hero = HeroSection::where('user_id', Auth::id())->first();
		return Inertia::render('Frontend/Hero/CreateHero', [
			'hero' => $hero,
		]);
	}

/**
 * Store a newly created resource in storage.
 */
	public function store(Request $request) {
		// Validate incoming request
		$validated = $request->validate([
			'website_name' => 'required',
			'website_logo' => 'nullable|image',
			'person_name'  => 'required',
			'person_image' => 'nullable|image',
			'description'  => 'required',
		]);

		//Retrieve the existing hero section
		$heroSection = HeroSection::where('user_id', Auth::id())->first();

		// Handle the website_logo file upload
		if ($request->hasFile('website_logo')) {
			// Delete the old logo if it exists
			if ($heroSection && $heroSection->website_logo) {
				$oldLogo = public_path('storage/logos/' . $heroSection->website_logo);
				if (file_exists($oldLogo)) {
					unlink($oldLogo);
				}
			}

			$file = $request->file('website_logo');
			$name = time() . '.' . $file->getClientOriginalExtension();
			$file->move(public_path('storage/logos'), $name);
			$validated['website_logo'] = $name;
		}

		// Handle the person_image file upload
		if ($request->hasFile('person_image')) {
			// Delete the old image if it exists
			if ($heroSection && $heroSection->person_image) {
				$oldImage = public_path('storage/images/' . $heroSection->person_image);
				if (file_exists($oldImage)) {
					unlink($oldImage);
				}
			}
			$file = $request->file('person_image');
			$name = time() . '.' . $file->getClientOriginalExtension();
			$file->move(public_path('storage/images'), $name);
			$validated['person_image'] = $name;
		}

		// Add user_id to the validated data
		$validated['user_id'] = Auth::id();

		// Update or create a new HeroSection
		$hero = HeroSection::updateOrCreate(
			['user_id' => Auth::id()], // Condition to check for existing hero
			$validated // Data to insert or update
		);

		// Redirect to the hero index page
		return redirect()->route('hero.index');
	}
}
