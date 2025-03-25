<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AboutController extends Controller {
	/**
	 * Display a listing of the resource.
	 */
	public function index() {
		return Inertia::render('Frontend/About/CreateAbout', [
			'about' => AboutSection::where('user_id', Auth::id())->first(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		//Validate incoming request
		$validated = $request->validate([
			'about_image'      => 'nullable|image|mimes:jpeg,png,gif|max:2048', // Validate image (max 2MB)
			'job_title'        => 'required|string|max:255',
			'experience_years' => 'required|string|max:255',
			'gmail'            => 'required|email|max:255',
			'phone'            => 'required|string|max:20',
			'address'          => 'required|string|max:255',
			'work_type'        => 'required|string|max:255',
			'total_project'    => 'required|string|max:255',
			'total_client'     => 'required|string|max:255',
			'cv'               => 'nullable|mimes:pdf,doc,docx|max:5120', // Validate CV (max 5MB)
			'description'      => 'required|string',
		]);

		// Retrieve the existing about section
		$aboutSection = AboutSection::where('user_id', Auth::id())->first();

		// Store the about_image file
		if ($request->hasFile('about_image')) {
			if ($aboutSection && $aboutSection->about_image) {
				$oldImage = public_path('storage/images/' . $aboutSection->about_image);
				if (file_exists($oldImage)) {
					unlink($oldImage);
				}
			}

			// Store new image
			$file = $request->file('about_image');
			$name = time() . '_about_image' . '.' . $file->getClientOriginalExtension();
			$file->move(public_path('storage/images'), $name);
			$validated['about_image'] = $name;
		}

		// Store the CV file
		if ($request->hasFile('cv')) {
			if ($aboutSection && $aboutSection->cv) {
				$oldCV = public_path('storage/cv/' . $aboutSection->cv);
				if (file_exists($oldCV)) {
					unlink($oldCV);
				}
			}

			// Store new CV
			$file = $request->file('cv');
			$name = time() . '_cv' . '.' . $file->getClientOriginalExtension();
			$file->move(public_path('storage/cv'), $name);
			$validated['cv'] = $name;
		}

		// Add user id to the validated data
		$validated['user_id'] = Auth::id();

		// Create the new AboutSection entry
		$aboutSection = AboutSection::updateOrCreate(
			['user_id' => Auth::id()], // Search condition
			$validated // Data to create or update
		);

		// Return a success response
		return response()->json([
			'message' => 'About section saved successfully!',
			'data'    => $aboutSection,
		], 201);
	}
}
