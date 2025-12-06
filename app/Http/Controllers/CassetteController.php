<?php

namespace App\Http\Controllers;

use App\Models\Cassette;
use App\Http\Resources\CassetteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CassetteController extends Controller
{
    /**
     * ===========1================
     * Buat fungsi index yang mengembalikan semua data cassette
     */
    public function index()
    {
        // ambil semua data cassette
        // $cassettes = ....
        $cassettes = Cassette::all();
        // return koleksi cassette
        // return ....
        return CassetteResource::collection($cassettes);
    }
     
    /**
     * ===========2================
     * Buat fungsi store untuk menambahkan data cassette baru
     */
    public function store(Request $request)
    {
        // Request body berisi title, artist dan year
        $validator = Validator::make($request->all(), [
            'title'  => 'required|string',
            'artist' => 'required|string',
            'year'   => 'required|integer'
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Buat data cassette
        // $cassette = ....
        $cassette = Cassette::create($request->only(['title', 'artist', 'year']));

        // return cassette yang dibuat sebagai resource
        // return ....
        return new CassetteResource($cassette);

    }

    /**
     * ===========3================
     * Buat fungsi show untuk menampilkan satu data cassette berdasarkan ID
     */
    public function show(string $id)
    {
        // Cari data cassette berdasarkan ID
        // $cassette = ....
        $cassette = cassette::find($id);

        if (!$cassette) {
            return response()->json([
                'success' => false,
                'message' => 'Cassette not found'
            ], 404);
        }

        // return cassette sebagai resource
        // return ....
        return new CassetteResource($cassette);
    }

    /**
     * ===========4================
     * Buat fungsi update untuk mengubah data cassette yang ada
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title'  => 'required',
            'artist' => 'required',
            'year'   => 'required'
        ]);

        $cassette = Cassette::find($id);

        if (!$cassette) {
            return response()->json([
                'success' => false,
                'message' => 'Cassette not found'
            ], 404);
        }


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $cassette->update($request->only(['title', 'artist', 'year']));

        return new CassetteResource($cassette);
    }

  
    /**
     * ===========5================
     * Buat fungsi destroy untuk menghapus data cassette
     */
    public function destroy(string $id)
    {
        $cassette = Cassette::find($id);

        if (!$cassette) {
            return response()->json([
                'success' => false,
                'message' => 'Cassette not found'
            ], 404);
        }
       
        $cassette->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cassette deleted successfully'
        ]);
    }
}
