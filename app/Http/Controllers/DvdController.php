<?php

namespace App\Http\Controllers;

use App\Models\Dvd;
use App\Http\Resources\DvdResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DvdController extends Controller
{
    /**
     * ===========1================
     * Buat fungsi index yang mengembalikan semua data dvd
     */
    public function index()
    {
        // ambil semua data dvd
        $dvds = Dvd::all();

        // return koleksi dvd
        return DvdResource::collection($dvds);
    }

    /**
     * ===========2================
     * Buat fungsi store untuk menambahkan data dvd baru
     */
    public function store(Request $request)
    {
        // Request body berisi title, director dan year
        $validator = Validator::make($request->all(), [
            'title ' => 'nullable',
            'director' => 'required',
            'year' => 'required',



            
        ]);

        if ($validator->fails()) {
            return response()->json([
             'message' => 'Please check your request',
             'errors' => $validator->errors()
            ], 422);
        }

        // Buat data dvd
         $dvd = Dvd::create($validator->validated());


        // return dvd yang dibuat sebagai resource
         return (new DvdResource($dvd))
            ->additional(['message' => 'Dvd Berhasil Dibuat'])
            ->response()
            ->setStatusCode(201);

    }

    /**
     * ===========3================
     * Buat fungsi show untuk menampilkan satu data dvd berdasarkan ID
     */
    public function show(string $dvd)
    {
        // Cari data dvd berdasarkan ID
         $dvd = Dvd::find($dvd);

        if (!$dvd) {
            return response()->json(['message' => 'item not found'], 404);
        }

        // return dvd sebagai resource
         return new DvdResource($dvd);
    }

    /**
     * ===========4================
     * Buat fungsi update untuk mengubah data dvd yang ada
     */
    public function update(Request $request, string $dvd)
    {
        // Request body berisi title, director dan year
        $validator = Validator::make($request->all(), [
           'title ' => 'required5',
            'director' => 'required',
            'year' => 'required'

        ]);

        // Cari data dvd berdasarkan ID
         $dvd =  Dvd::find($dvd);

        if (!$dvd) {
            return response()->json([
               'message' => 'item not found'
            ], 404);
        }


        if ($validator->fails()) {
            return response()->json([
              'message' => 'Please check your request',
             'errors' => $validator->errors()
            ], 422);
        }

        // Update data dvd
        $dvd->  update($validator->validated());
        // return dvd yang diupdate sebagai resource
        return (new  DvdResource($dvd))
            ->additional(['message' => 'Dvd Berhasil Dibuat'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * ===========5================
     * Buat fungsi destroy untuk menghapus data dvd
     */
    public function destroy(string $dvd)
    {
        // Cari data dvd berdasarkan ID
        $dvd = Dvd::find($dvd);

        if (!$dvd) {
            return response()->json([
                'message' => 'Item Not Found'
            ], 404);
        }

        // Hapus data dvd
         $dvd->delete();

        // return message sukses
         return response()->json(['Message'=>'item deleted successfully'], 200);
    }
}
