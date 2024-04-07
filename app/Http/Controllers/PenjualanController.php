<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
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

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Transaksi',
            'list'  => ['Home', 'Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Penjualan'
        ];

        $barang = BarangModel::all();
        $penjualan = PenjualanModel::all(); 
        $activeMenu = 'penjualan';
        
        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'    => 'required|integer',
            'penjualan_id' => 'required|integer',
            'jumlah'       => 'required|integer'
            
        ]);

        $barang = BarangModel::find($request->barang_id);
        $harga = $barang->harga_jual * $request->jumlah;

        PenjualanDetailModel::create([
            'penjualan_id' => $request->penjualan_id,
            'barang_id'    => $request->barang_id,
            'jumlah'       => $request->jumlah,
            'harga'        => $harga,
            'created_at'   => now()
        ]);

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }

    public function show(string $id)
    {
        $detail = PenjualanDetailModel::with(['barang','sale'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list'  => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Penjualan Barang'
        ];

        $activeMenu = 'penjualan'; // set menu yang sedang aktif
        
        return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
     {
         $detail = PenjualanDetailModel::find($id); 
 
         $breadcrumb = (object) [
             'title' => 'Edit Penjualan',
             'list'  => ['Home', 'Penjualan', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit Penjualan barang'
         ];
 
         $barang = BarangModel::all();
         $penjualan = PenjualanModel::all(); 
         $activeMenu = 'penjualan';
         
         return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'penjualan' => $penjualan,'detail'=>$detail, 'activeMenu' => $activeMenu]);
     }

     public function update(Request $request, string $id)
     {
         $request->validate([
            'barang_id'    => 'required|integer',
            'penjualan_id' => 'required|integer',
            'jumlah'       => 'required|integer'
         ]);

         $barang = BarangModel::find($request->barang_id);
        $harga = $barang->harga_jual * $request->jumlah;
 
         PenjualanDetailModel::find($id)->update([
            'penjualan_id' => $request->penjualan_id,
            'barang_id'    => $request->barang_id,
            'jumlah'       => $request->jumlah,
            'harga'        => $harga,
            'updated_at'   => now()
         ]);
 
         return redirect('/penjualan')->with('success', 'Data penjualan barang berhasil diubah');
     }

     public function destroy(string $id)
    {
        $check = PenjualanDetailModel::find($id); 
        if (!$check) {
            return redirect('/penjualan')->with('error', 'Data penjualan barang tidak ditemukan');
        }

        try {
            PenjualanDetailModel::destroy($id);

            return redirect('/penjualan')->with('success', 'Data penjualan barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/penjualan')->with('error', 'Data penjualan barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
