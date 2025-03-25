<?php

namespace App\Http\Controllers;

use App\Models\HeroSectionSkills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HeroSkillsController extends Controller {
	/**
	 * Show the form for creating a new resource.
	 */
	public function index() {
		return Inertia::render('Frontend/Hero/CreateHeroSkills', [
			'skills' => HeroSectionSkills::where('user_id', Auth::id())->get(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		$userId = Auth::id(); // Get the authenticated user's ID

		// Validate incoming request, no need for user_id validation since it's derived from Auth::id()
		$validated = $request->validate([
			'icon_class' => 'required|string|max:255', // Added string|max:255 for better validation
		]);

		// Add user_id to the validated data
		$validated['user_id'] = $userId;

		// Create the HeroSectionProfession record
		HeroSectionSkills::create($validated);

		// Redirect to the hero index page
		return redirect()->route('hero.index');
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id) {
		//Update the skill
		$validated = $request->validate([
			'icon_class' => 'required|string|max:255',
		]);

		$skill = HeroSectionSkills::findOrFail($id);
		$skill->update($validated);

		return response()->json(['message' => 'Skill updated successfully']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id) {
		//delete the skill
		$skill = HeroSectionSkills::findOrFail($id);
		$skill->delete();

		return response()->json(['message' => 'Skill deleted successfully']);
	}
}
