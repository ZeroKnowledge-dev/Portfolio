<?php

namespace App\Http\Controllers;

use App\Models\AboutSectionSkills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AboutSkillsController extends Controller {
	/**
	 * Display a listing of the resource.
	 */
	public function index() {
		return Inertia::render('Frontend/About/CreateAboutSkills', [
			'skill' => AboutSectionSkills::where('user_id', Auth::id())->get(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		$validated = $request->validate([
			'skill_name'       => 'required',
			'skill_percentage' => 'required',
		]);

		AboutSectionSkills::create([
			'user_id'          => Auth::id(),
			'skill_name'       => $request->skill_name,
			'skill_percentage' => $request->skill_percentage,
		]);

		return response()->json(['message' => 'Skill created successfully']);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id) {
		//update
		$validated = $request->validate([
			'skill_name'       => 'required',
			'skill_percentage' => 'required',
		]);

		AboutSectionSkills::where('id', $id)->update([
			'skill_name'       => $request->skill_name,
			'skill_percentage' => $request->skill_percentage,
		]);

		return response()->json(['message' => 'Skill updated successfully']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id) {
		AboutSectionSkills::where('id', $id)->delete();
		return response()->json(['message' => 'Skill deleted successfully']);
	}
}
