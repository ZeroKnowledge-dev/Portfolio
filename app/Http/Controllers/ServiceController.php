<?php

namespace App\Http\Controllers;

use App\Models\ServiceSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ServiceController extends Controller {
	/**
	 * Display a listing of the resource.
	 */
	public function index() {
		return Inertia::render('Frontend/Service/CreateService', [
			'services' => ServiceSection::where('user_id', Auth::id())->get(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request) {
		$validated = $request->validate([
			'service_name'        => 'required',
			'service_description' => 'required',
			'service_icon_class'  => 'required',
		]);

		ServiceSection::create([
			'user_id'             => Auth::id(),
			'service_name'        => $request->service_name,
			'service_description' => $request->service_description,
			'service_icon_class'  => $request->service_icon_class,
		]);

		return response()->json(['message' => 'Service created successfully']);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id) {
		$validated = $request->validate([
			'service_name'        => 'required',
			'service_description' => 'required',
			'service_icon_class'  => 'required',
		]);

		ServiceSection::where('id', $id)->update([
			'service_name'        => $request->service_name,
			'service_description' => $request->service_description,
			'service_icon_class'  => $request->service_icon_class,
		]);

		return response()->json(['message' => 'Service updated successfully']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id) {
		ServiceSection::where('id', $id)->delete();
		return response()->json(['message' => 'Service deleted successfully']);
	}
}
