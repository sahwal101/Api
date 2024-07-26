<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->get();
        $response =[
            'succes' => true,
            'message' => 'Data Kategori',
            'data' => $kategori,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
{
    //validasi data
    $validator = Validator::make($request->all(), [
        'nama_kategori' => 'required|unique:kategoris',
    ], [
        'nama_kategori.required' => 'Masukan kategori',
        'nama_kategori.unique' => 'kategori Sudah Digunakan',

    ]);

    if($validator->fails()){
        return response()->json([
            'succes' => false,
            'message' => 'Silahkan Isi Dengan Benar',
            'data' => $validator->erors(),
        ], 400);
    } else {
        $kategori = new Kategori;
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();
    }

    if($kategori){
        return response()->json([
            'succes' => true,
            'message' => 'Data Berhasil Disimpan',
        ], 200);
    } else {
        return response()->json([
            'succes' => false,
            'message' => 'data gagal disimpan',
        ], 400);
    }
}
    public function show($id)
    {
        $kategori = Kategori::find($id);

        if($kategori) {
            return response()->json([
                'succes' => true,
                'message' => 'Detail Kategori',
                'data' => $kategori,
            ], 200);
        } else {
            return response()->json([
                'succes' => false,
                'message' => 'kategori tidak ditemukan',
                'data' => '',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        //validasi data
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategoris',
        ], [
            'nama_kategori.required' => 'Masukan kategori',
            'nama_kategori.unique' => 'kategori Sudah Digunakan',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Dengan Benar',
                'data' => $validator->erors(),
            ], 400);
        } else {
            $kategori = Kategori::find($id);
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();
        }

        if($kategori){
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbarui',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data gagal disimpan',
            ], 400);
        }
    }
    public function destroy($id)
    {
    $kategori = Kategori::find($id);
    if($kategori) {
    $kategori ->delete();
    return response()->json([
        'success' => true,
        'message' => 'data' .$kategori->nama_kategori . 'berhasil',
    ], 200);

    } else {
        return response()->json([
            'success' => true,
            'message' => 'tidak ditemukan',
        ], 404);
    }

    }
}
