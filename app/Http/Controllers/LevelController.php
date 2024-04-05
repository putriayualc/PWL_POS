<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Monolog\Level;
use Yajra\DataTables\Facades\DataTables;


class LevelController extends Controller
{
   public function index(){
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)',['CUS', 'Pelanggan', now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?' , ['Customer', 'CUS']);
        // return 'update data berhasil. Jumlah daya yang diupdate: ' . $row.' baris';

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row. ' baris';

        // $data = DB::select('select * from m_level');
        // return view('level', ['data' => $data]);

        $breadcrumb = (object)[
            'title' => 'Daftar Level User',
            'list' => ['Home','Level']
        ];

        $page = (object)[
            'title' => 'Daftar Level user yang tersimpan'
        ];

        $activeMenu = 'level'; //set menu yang aktif

        $level = LevelModel::all(); 

        return view('level.index',['breadcrumb'=>$breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
   }

   public function list(Request $request)
    {
        $levels = LevelModel::select('level_id','level_kode','level_nama');

        if($request->level_id){
            $levels->where('level_id',$request->level_id);
        }
    
        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/'.$level->level_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

//    public function tambah(){
//       return view('level_tambah');
//     }

//   public function tambah_simpan(Request $request){
//     $request->validate([
//         'level_kode' => 'bail|required|string|max:10',
//         'level_nama' => 'bail|required|string|max:100',
//     ]);

//     LevelModel::create([
//        'level_kode' => $request->level_kode,
//        'level_nama' => $request->level_nama,
//     ]);

//     return redirect('/level');
//     }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user level baru'
        ];

        $level = LevelModel::all(); 
        $activeMenu = 'level';
        
        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_kode'    => 'required|string|min:2',
            'level_nama'    => 'required|min:3',
        ]);

        LevelModel::create([
            'level_kode'  => $request->level_kode,
            'level_nama'  => $request->level_nama,
            'created_at'  => now(),
            'updatet_at'  => now()
        ]);

        return redirect('/level')->with('success', 'Data user level berhasil disimpan');
    }

    public function show(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User Level',
            'list'  => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user Level'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif
        
        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
     {
         $level = LevelModel::find($id);
 
         $breadcrumb = (object) [
             'title' => 'Edit Level',
             'list'  => ['Home', 'Level', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit user level'
         ];
 
         $activeMenu = 'level'; // set menu yang sedang aktif
         
         return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
     }
 
     public function update(Request $request, string $id)
     {
        $request->validate([
            'level_kode'    => 'required|string|min:2',
            'level_nama'    => 'required|min:3',
        ]);
 
         LevelModel::find($id)->update([
            'level_kode'  => $request->level_kode,
            'level_nama'  => $request->level_nama,
            'updated_at'  => now()
         ]);
 
         return redirect('/level')->with('success', 'Data level berhasil diubah');
     }

     public function destroy(string $id)
    {
        $check = LevelModel::find($id); 
        if (!$check) {
            return redirect('/level')->with('error', 'Data tidak ditemukan');
        }

        try {
            LevelModel::destroy($id); // hapus data level

            return redirect('/level')->with('success', 'Data berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/level')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
