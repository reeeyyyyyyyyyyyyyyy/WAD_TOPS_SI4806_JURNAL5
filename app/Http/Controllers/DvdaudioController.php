<?php

namespace App\Http\Controllers;

use App\Models\DvdAudio;
use App\Http\Resources\DvdaudioResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DvdaudioController extends Controller
{
    /**
     * ===========1================
     * Buat fungsi index yang mengembalikan semua data dvdaudio
     */
    public function index()
    {
        // ambil semua data dvdaudio
        // $dvdaudios = ....
        $items = Dvdaudio::all();
        return ItemResource::collection($items);
        // return koleksi dvdaudio
        // return ....

    }

    /**
     * ===========2================
     * Buat fungsi store untuk menambahkan data dvdaudio baru
     */
    public function store(Request $request)
    {
        // Request body berisi title, artist dan year
        $validator = Validator::make($request->all(), [
            'title' =>'required|string|max:255',
            'artist' => 'required|string|max:225',
            'year'=>'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                // 'success' => false,
                // 'errors' => ....
                'message' => 'Please check your request',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat data dvdaudio
        // $dvdaudio = ....
        $item = item::create($validator->validated())
        // return dvdaudio yang dibuat sebagai resource
        // return ....
        return (new itemReesource($item))
        ->additional(['message => 'item created successfully])
        ->response()
        ->setStatusCode(201);

    }

    /**
     * ===========3================
     * Buat fungsi show untuk menampilkan satu data dvdaudio berdasarkan ID
     */
    public function show(string $id)
    {
        // Cari data dvdaudio berdasarkan ID
        // $dvdaudio = ....

        if (!$dvdaudio) {
            return response()->json([
                // 'success' => false,
                // 'message' => ....
                return response()->json(['message' => 'Item bot found'], 404);
            ], 404);
        }

        // return dvdaudio sebagai resource
        // return ....
        return new DvdaudioResource($dvdaudio)
    }

    /**
     * ===========4================
     * Buat fungsi update untuk mengubah data dvdaudio yang ada
     */
    public function update(Request $request, string $id)
    {
        // Request body berisi title, artist dan year
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:225',
            'artist'=> 'sometimes|nullable|string',
            'year'=> 'sometimes|required|integer|min:0',
        ]);

        // Cari data dvdaudio berdasarkan ID
        // $dvdaudio = ....
        $dvdaudio =$dvdaudio::find($id);

        if (!$dvdaudio) {
            return response()->json([
                // 'success' => false,
                // 'message' => ....
                'message' => "Item not found",
                'errors' => $validator->errors()
            ], 404);
        }


        if ($validator->fails()) {
            return response()->json([
                // 'success' => false,
                // 'errors' => ....
                'message' => "Please check your request",
                'errors' => $validator->errors()
            ], 422);
        }

        // Update data dvdaudio
        // $dvdaudio->....
        $dvdaudio->update($validator->validated());
        // return dvdaudio yang diupdate sebagai resource
        // return ....
        return (new DvdaudioResource(($dvdaudio)))
        ->additional(['message' => 'Item updated successfully'])
        ->response()
        ->setStatusCode(200);
    }

    /**
     * ===========5================
     * Buat fungsi destroy untuk menghapus data dvdaudio
     */
    public function destroy(string $id)
    {
        // Cari data dvdaudio berdasarkan ID
        // $dvdaudio = ....
        $dvdaudio = dvdaudio::find($id);
        if (!$dvdaudio) {
            return response()->json([
                // 'success' => false,
                // 'message' => ....
                return response()->json(['message' => 'item not found']);
            ], 404);
        }

        // Hapus data dvdaudio
        // $dvdaudio->....
        $dvdaudio->delete();
        // return message sukses
        // return ....
        return response()->json(['message' => 'item deleted sucessfully'], 200);
    }
}
