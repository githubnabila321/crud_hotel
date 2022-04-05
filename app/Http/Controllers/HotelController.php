<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Hotel::all();
        return view('detail', ['datas' => $datas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_hotel' => 'required',
            'lokasi' => 'required',
            'harga' => 'required',
            'image_hotel' => 'required |image|mimes:jpeg,png,jpg|max:2048',
            'fasilitas' => 'required',
            'sinopsis' => 'required',
        ]);
        $hotel = Hotel::create([
            'nama_hotel' => $request['nama_hotel'],
            'lokasi' => $request['lokasi'],
            'harga' => $request['harga'],
            'fasilitas' => $request['fasilitas'],
            'sinopsis' => $request['sinopsis'],
            'image' => $request->hasFile('image_hotel') ? $request->file('image_hotel')->store('foto-hotel', 'public') : null,
        ]);
        return redirect('hotel');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotel = Hotel::findorFail($id);
        $hotels = Hotel::all();
        return view('detail', [
            'hotel' => $hotel,
            'hotels' => $hotels

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);

        return view('edit', [
            'hotel' => $hotel
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_hotel' => 'required',
            'lokasi' => 'required',
            'harga' => 'required',
            'image' => 'required |image|mimes:jpeg,png,jpg|max:2048',
            'fasilitas' => 'required',
            'sinopsis' => 'required',
        ]);

        $hotel = Hotel::find($id)->update([
            'nama_hotel' => $request['nama_hotel'],
            'lokasi' => $request['lokasi'],
            'harga' => $request['harga'],
            'fasilitas' => $request['fasilitas'],
            'sinopsis' => $request['sinopsis'],
            'image' => $request->hasFile('image_hotel') ? $request->file('image_hotel')->store('foto-hotel', 'public') : null,
        ]);

        return redirect('detail');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Hotel::find($id);
        $item->delete();
        return redirect('hotel');
    }
}
