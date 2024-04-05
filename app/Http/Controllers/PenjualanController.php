<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Transaksi Penjualan',
            'list' => ['Home','Penjualan']
        ];

        $page = (object)[
            'title' => 'Transaksi Penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan'; //set menu yang aktif

        $barang = BarangModel::all(); //untuk filter

        return view('penjualan.index',['breadcrumb'=>$breadcrumb, 'page' => $page,'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $sales = PenjualanDetailModel::select('detail_id','penjualan_id','barang_id','harga','jumlah')
            ->with(['barang', 'sale']);

        //filter data
        if($request->barang_id){
            $sales->where('barang_id',$request->barang_id);
        }
    
        return DataTables::of($sales)
            ->addIndexColumn()
            ->addColumn('aksi', function ($sale) {
                $btn = '<a href="' . url('/penjualan/' . $sale->detail_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/penjualan/' . $sale->detail_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/'.$sale->detail_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
