<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Stok Barang',
            'list' => ['Home','Stok']
        ];

        $page = (object)[
            'title' => 'Stok barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok'; //set menu yang aktif

        $user = UserModel::all(); //untuk filter

        return view('stok.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id','barang_id','user_id','stok_tanggal','stok_jumlah')
            ->with(['barang', 'user']);

        //filter data user berdasarkan kategori_id
        if($request->user_id){
            $stoks->where('user_id',$request->user_id);
        }
    
        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/'.$stok->stok_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
