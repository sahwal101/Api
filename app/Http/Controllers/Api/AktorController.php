<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\Aktor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AktorController extends Controller
{
    public function index(){
        $aktor = Aktor::latest()->get();
        $response = [
            'success' =>true,
            'message' => 'Data aktor',
            'data' => $aktor,
        ];
        return response()->json($response, 200);
    }
    public function store(Request $request)
    {
        //validasi
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required|unique:aktors',
            'biodata' => 'required',

        ], [
            'nama_aktor.required' => 'Masukan Aktor',
            'nama_aktor.unique' => 'Aktor Sudah Digunakan!',
            'biodata.required' => 'Masukan Aktor',
            'biodata.unique' => 'Aktor Sudah Digunakan!',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $aktor = new Aktor;
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->biodata = $request->biodata;
            $aktor->save();
        }
        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil di simpan',
            ], 201);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'data gagal di simpan',
            ], 400);
        }
    }

    public function show($id)
    {
        $aktor = Aktor::find($id);

        if($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Aktor',
                'data' => $aktor,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Aktor tidak di temukan',
            ], 400);
        }
    }
    public function update(Request $request, $id)
    {
        //validasi
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required',
            'biodata' => 'required'
        ], [
            'nama_aktor.required' => 'Masukan Aktor',
            'biodata.required' => 'Masukan Aktor',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $aktor = Aktor::find($id);
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->biodata = $request->biodata;
            $aktor->save();
        }
        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil di pembaharui',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'data gagal di pembaharui',
            ], 400);
        }
    }
    public function destroy($id){
        $aktor = Aktor::find($id);
        if ($aktor) {
        $aktor->delete();
        return response()->json([
            'success' => true,
            'message' => 'data' . $aktor->nama_aktor . ' berhasil di hapus',
        ], 200);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'data Tidak di temukan',
        ], 404);
    }
    }
}
