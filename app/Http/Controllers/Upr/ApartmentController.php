<?php

namespace App\Http\Controllers\upr;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Apartment;
use App\Service;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$apartments = Apartment::where('user_id', Auth::id())->get();
		return view('upr.apartments.index', compact('apartments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$services = Service::all();
		return view('upr.apartments.create', compact("services"));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = $request->all();

		if (empty($data["cover_img"])) {
			$path = null;
		} else {
			$path = Storage::disk('public')->put('images', $data['cover_img']);
		}

		$idUser = Auth::user()->id;
		$request->validate([
			'title' => 'string|max:70',
			'description' => 'string|nullable|max:2000',
			'n_rooms' => 'numeric|required|min:1',
			'n_baths' => 'numeric|required|min:1',
			'sq_meters' => 'numeric|required|min:10',
			'address' => 'string|required|max:110',
			'price' => 'numeric|required|min:0|max:9999',
			'active' => 'required|boolean',
			'cover_img' => 'image|nullable'
		]);

		$newApartment = new Apartment;

		$newApartment->title = $data['title'];
		$newApartment->description = $data['description'];
		$newApartment->n_rooms = $data['n_rooms'];
		$newApartment->n_baths = $data['n_baths'];
		$newApartment->sq_meters = $data['sq_meters'];
		$newApartment->address = $data['address'];
		$newApartment->latitude = $data['latitude'];
		$newApartment->longitude = $data['longitude'];
		$newApartment->price = $data['price'];
		$newApartment->user_id = $idUser;
		$newApartment->cover_img = $path;

		$saved = $newApartment->save();
		$apartmentId = $newApartment->id;

		if (!$saved) {
			return redirect()->back()->withInput();
		}

		if (!empty($data['services'])) {
			$newApartment->services()->attach($data['services']);
		}

			return view('upr.image-upload', compact("apartmentId"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Apartment  $apartment
	 * @return \Illuminate\Http\Response
	 */
	public function show(Apartment $apartment)
	{
		if (empty($apartment)) {
			abort('404');
		}
		// $apartment->views += 1;
		// $apartment->update();

		return view('upr.apartments.show', compact('apartment'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Apartment  $apartment
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Apartment $apartment)
	{

		if (empty($apartment)) {
			abort('404');
		}
		$services = Service::all();
		$data = [
			'apartment' => $apartment,
			'services' => $services
		];
		return view('upr.apartments.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Apartment  $apartment
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Apartment $apartment)
	{
		$data = $request->all();
		if (empty($data["cover_img"])) {
			$path = $apartment->cover_img;
		} else {
			$path = Storage::disk('public')->put('images', $data['cover_img']);
		}

		$idUser = Auth::user()->id;
		if (empty($apartment)) {
			abort(404);
		}

		if ($apartment->user->id != $idUser) {
			abort(404);
		}

		$request->validate([
			'title' => 'string|max:70',
			'description' => 'string|nullable|max:2000',
			'n_rooms' => 'numeric|required|min:1',
			'n_baths' => 'numeric|required|min:1',
			'sq_meters' => 'numeric|required|min:10',
			'address' => 'string|required|max:110',
			'price' => 'numeric|required|min:0|max:9999',
			'active' => 'required|boolean',
			'cover_img' => 'image|nullable'
		]);

		$apartment->title = $data['title'];
		$apartment->description = $data['description'];
		$apartment->n_rooms = $data['n_rooms'];
		$apartment->n_baths = $data['n_baths'];
		$apartment->sq_meters = $data['sq_meters'];
		$apartment->address = $data['address'];
		$apartment->latitude = $data['latitude'];
		$apartment->longitude = $data['longitude'];
		$apartment->price = $data['price'];

		$apartment->cover_img = $path;

		$updated = $apartment->update();

		if (!$updated) {
			return redirect()->back();
		}

		if (!empty($data['services'])) {
			$apartment->services()->sync($data['services']);
		}

		return redirect()->route('upr.apartments.show', $apartment);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Apartment  $apartment
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Apartment $apartment)
	{
		$apartment->services()->detach();
		$apartment->delete();
		return redirect()->route('upr.apartments.index');
	}
}
