<?php

namespace App\Http\Controllers;

use App\Models\HeroSectionProfession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HeroProfessionController extends Controller {

	/**
	 * Show the form for creating a new resource.
	 */
	public function index() {
		return Inertia::render('Frontend/Hero/CreateHeroProfessions', [
			'professions' => HeroSectionProfession::where('user_id', Auth::id())->get(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		$userId = Auth::id(); // Get the authenticated user's ID

		// Validate incoming request, no need for user_id validation since it's derived from Auth::id()
		$validated = $request->validate([
			'profession_name' => 'required|string|max:255', // Added string|max:255 for better validation
		]);

		// Add user_id to the validated data
		$validated['user_id'] = $userId;

		// Create the HeroSectionProfession record
		HeroSectionProfession::create($validated);

		// Redirect to the hero index page
		return response()->json(['message' => 'Profession created successfully']);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id) {
		//update profession
		$validated = $request->validate([
			'profession_name' => 'required|string|max:255',
		]);

		$profession = HeroSectionProfession::find($id);

		$profession->update($validated);

		return response()->json(['message' => 'Profession updated successfully']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id) {
		$profession = HeroSectionProfession::find($id);
		$profession->delete();

		return response()->json(['message' => 'Profession deleted successfully']);
	}
}
