<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class WisataController extends Controller
{
    public function data_wisata()
    {
        $data = Wisata::with('foto')->get();
        $response = [
            'message' => 'berhasil',
            'data' => $data
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function data_wisata_kategori(Request $request)
    {
        $data = Wisata::where('kategori', $request->input('kategori'))->with('foto')->get();
        $response = [
            'message' => 'berhasil',
            'data' => $data
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function tambah_wisata(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'deskripsi' => ['required'],
            'kategori' => ['required'],
            'info' => ['required'],
            'foto.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $upload_data = $request->except('foto');

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $save = Wisata::create($upload_data);

        if ($request->file('foto')) {
            foreach ($request->file('foto') as $image) {
                $upload_foto = $image->store('foto', 'public');
                $save_foto = Foto::create([
                    'foto' => $upload_foto,
                    'id_wisata' => $save->id
                ]);
            }
        }


        $response = [
            'message' => 'berhasil',
            'data' => $upload_data
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function delete_wisata(Request $request)
    {
        $data = Wisata::where('id', $request->id)->with('foto')->first();
        $hapus = Wisata::where('id', $request->id)->delete();
        foreach ($data->foto as $arrayfoto) {
            Storage::disk('public')->delete($arrayfoto->foto);
        }

        $response = [
            'message' => 'wisata di hapus',
            'data' => $data
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
