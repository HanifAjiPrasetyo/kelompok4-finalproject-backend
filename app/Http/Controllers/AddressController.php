<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;

class AddressController extends Controller
{
    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => Config::get('app.rajaongkir_key')
        ])->get('https://api.rajaongkir.com/starter/province')->json();

        return response()->json([
            $response['rajaongkir']
        ]);
    }
    public function getCities(string $id)
    {
        $response = Http::withHeaders([
            'key' => Config::get('app.rajaongkir_key'),
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $id
        ])->json();

        return response()->json([
            $response['rajaongkir']
        ]);
    }
    public function getPostalCode(string $id)
    {
        $response = Http::withHeaders([
            'key' => Config::get('app.rajaongkir_key'),
        ])->get('https://api.rajaongkir.com/starter/city', [
            'id' => $id
        ])->json();

        return response()->json([
            $response['rajaongkir']
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        //
    }
}
