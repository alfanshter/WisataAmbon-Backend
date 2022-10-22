<?php

namespace App\Http\Controllers;

use App\Models\event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    public function tambah_event(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'deskripsi' => ['required'],
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $upload_data = $request->except('foto');

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->file('foto')) {
            $upload_data = $request->file('foto')->store('foto', 'public');
            $save_foto = event::create([
                'foto' => $upload_data,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);

            $response = [
                'message' => 'berhasil',
                'data' => $save_foto
            ];

            return response()->json($response, Response::HTTP_CREATED);
        }
    }

    public function data_event()
    {
        $data = event::all();
        $response = [
            'message' => 'berhasil',
            'data' => $data
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function delete_event(Request $request)
    {
        $hapus = event::where('id', $request->id)->delete();
        Storage::disk('public')->delete($request->foto);

        $response = [
            'message' => 'wisata di hapus',
            'data' => 'done'
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
