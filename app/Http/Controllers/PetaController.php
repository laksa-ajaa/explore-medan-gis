<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PointStart;
use App\Models\PointWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['point_start'] = PointStart::select('id', 'name', 'desc', 'type', DB::raw('ST_AsGeoJSON(geom) as geojson'))
            ->get();

        $this->data['point_wisata'] = PointWisata::select('id', 'name', 'desc', 'category', DB::raw('ST_AsGeoJSON(geom) as geojson'))
            ->get();
        $this->data['kecamatan'] = Kecamatan::select('id', 'name', 'code', DB::raw('ST_AsGeoJSON(geom) as geojson'))
            ->get();

        $this->data['title'] = 'Peta';
        return view('pages.web.peta', $this->data);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
