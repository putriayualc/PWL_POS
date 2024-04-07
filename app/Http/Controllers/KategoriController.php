<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        // $data = [
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now()
        //      ];
        //     DB::table('m_kategori') -> insert($data);
        //     return 'insert data baru berhasil';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row. ' baris';

        // $row = DB::table('m_kategori')->where('kategori_kode','SNK')->delete();
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row. ' baris';

        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data' => $data]);

        // return $dataTable->render('kategori.index');

        $breadcrumb = (object)[
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object)[
            'title' => 'Daftar Kategori Barang yang tersimpan'
        ];

        $activeMenu = 'kategori'; //set menu yang aktif

        return view('category.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Show the form to create a new post
    // public function create(): View{
    //     return view('kategori.create');
    // }

    // public function store(Request $request): RedirectResponse{
    //     $validated = $request->validate([
    //         'kodeKategori' => 'bail|required|min:3|string|max:10',
    //         'namaKategori' => 'bail|required|string|max:100',
    //     ]);

    //     KategoriModel::create([
    //         'kategori_kode' => $request->kodeKategori,
    //         'kategori_nama' => $request->namaKategori
    //     ]);

    //     return redirect('/kategori');
    // }

    // public function edit($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     return view('kategori.edit', ['data' => $kategori]);
    // }

    // public function save_edit($id, Request $request)
    // {
    //     $kategori = KategoriModel::find($id);

    //     $kategori->kategori_kode = $request->kategori_kode;
    //     $kategori->kategori_nama = $request->kategori_nama;

    //     $kategori->save();

    //     return redirect('/kategori');
    // }

    // public function deleteKtg($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     $kategori->delete();

    //     return redirect('/kategori');
    // }


    public function list(Request $request)
    {
        $category = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama')->get();

        return DataTables::of($category)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list'  => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kategori baru'
        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif
        
        return view('category.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode'    => 'required|string|min:2',
            'kategori_nama'    => 'required|min:3',
        ]);

        KategoriModel::create([
            'kategori_kode'  => $request->kategori_kode,
            'kategori_nama'  => $request->kategori_nama,
            'created_at'  => now(),
            'updatet_at'  => now()
        ]);

        return redirect('/kategori')->with('success', 'Data user kategori berhasil disimpan');
    }

    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list'  => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif
        
        return view('category.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
     {
        $kategori = KategoriModel::find($id);
 
         $breadcrumb = (object) [
             'title' => 'Edit Kategori',
             'list'  => ['Home', 'Kategori', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit kategori'
         ];
 
         $activeMenu = 'kategori'; // set menu yang sedang aktif
         
         return view('category.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
     }
 
     public function update(Request $request, string $id)
     {
        $request->validate([
            'kategori_kode'    => 'required|string|min:2',
            'kategori_nama'    => 'required|min:3',
        ]);
 
        KategoriModel::find($id)->update([
            'kategori_kode'  => $request->kategori_kode,
            'kategori_nama'  => $request->kategori_nama,
            'updated_at'  => now()
         ]);
 
         return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
     }

     public function destroy(string $id)
    {
        $check = KategoriModel::find($id); 
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id); // hapus data kategori

            return redirect('/kategori')->with('success', 'Data berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
