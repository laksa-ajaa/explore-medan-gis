<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\LineJalur;
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
        $this->data['point_start'] = PointStart::select('id', 'name', 'alamat', 'type', DB::raw('ST_AsGeoJSON(geom) as geojson'))
            ->get();

        $this->data['point_wisata'] = PointWisata::select('id', 'name', 'rating', 'desc', 'alamat', 'category', DB::raw('ST_AsGeoJSON(geom) as geojson'))
            ->get();
        $this->data['kecamatan'] = Kecamatan::select('id', 'name', 'code', DB::raw('ST_AsGeoJSON(geom) as geojson'))
            ->get();

        $this->data['title'] = 'Peta';
        return view('pages.web.peta', $this->data);
    }

    public function getJalurByStartAndWisata($start_id, $wisata_id)
    {
        $jalur = LineJalur::select(
            'id',
            'start_id',
            'wisata_id',
            DB::raw('ST_AsGeoJSON(geom) as geom'),
            DB::raw('ST_Length(ST_Transform(geom, 3857)) / 1000 as panjang_km')
        )
            ->where('start_id', $start_id)
            ->where('wisata_id', $wisata_id)
            ->first();

        if (!$jalur) {
            return response()->json(['message' => 'Jalur tidak ditemukan'], 404);
        }

        return response()->json([
            'geom' => json_decode($jalur->geom),
            'panjang_km' => $jalur->panjang_km
        ]);
    }
}
