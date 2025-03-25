<?php

namespace App\Http\Controllers;

use App\Models\ProjectSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectController extends Controller {
	/**
	 * Display a listing of the resource.
	 */
	public function index() {
		return Inertia::render('Frontend/Project/CreateProject', [
			'projects' => ProjectSection::where('user_id', Auth::id())->get(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		$validated = $request->validate([
			'project_name'        => 'required|string|max:255',
			'project_category'    => 'required|string|max:255',
			'technology_used'     => 'required|string|max:255',
			'live_demo_link'      => 'nullable|url|max:255',
			'additional_link'     => 'nullable|url|max:255',
			'project_description' => 'required|string',
			'project_image'       => 'required|image|max:5120', // 5MB max
		]);

		// Check if the project name already exists
		$existingProject = ProjectSection::where('project_name', $validated['project_name'])->first();
		if ($existingProject) {
			return response()->json([
				'message' => 'Project name already exists',
			], 400);
		}

		// Handle image upload
		if ($request->hasFile('project_image')) {
			$file = $request->file('project_image');
			$name = time() . '_project_image' . '.' . $file->getClientOriginalExtension();
			$file->move(public_path('storage/images'), $name);
			$validated['project_image'] = $name;
		}

		// Add current user ID
		$validated['user_id'] = Auth::id();

		$project = ProjectSection::create($validated);

		return response()->json([
			'message' => 'Project created successfully',
			'project' => $project,
		], 201);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, $id) {
		$validatedData = $request->validate([
			'project_name'        => 'required|string|max:255',
			'project_category'    => 'required|string|max:255',
			'technology_used'     => 'nullable|string|max:255',
			'live_demo_link'      => 'nullable|url',
			'additional_link'     => 'nullable|url',
			'project_description' => 'required|string|max:500',
			'project_image'       => 'nullable|image|max:5120', // 5MB max image size
		]);

		if ($request->hasFile('project_image')) {
			// Delete the old image if it exists
			$project = ProjectSection::findOrFail($id);
			if ($project->project_image) {
				$oldImage = public_path('storage/images/' . $project->project_image);
				if (file_exists($oldImage)) {
					unlink($oldImage);
				}
			}
			// Handle image upload
			$file = $request->file('project_image');
			$name = time() . '_project_image' . '.' . $file->getClientOriginalExtension();
			$file->move(public_path('storage/images'), $name);
			$validatedData['project_image'] = $name;
		}

		$project = ProjectSection::findOrFail($id);
		$project->update($validatedData);

		return response()->json(['message' => 'Project updated successfully'], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id) {
		ProjectSection::where('id', $id)->delete();
		return response()->json(['message' => 'Projects deleted successfully']);
	}
}
