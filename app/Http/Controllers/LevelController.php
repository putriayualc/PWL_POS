<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Monolog\Level;

class LevelController extends Controller
{
   public function index(){
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)',['CUS', 'Pelanggan', now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?' , ['Customer', 'CUS']);
        // return 'update data berhasil. Jumlah daya yang diupdate: ' . $row.' baris';

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row. ' baris';

        $data = DB::select('select * from m_level');
        return view('level', ['data' => $data]);

   }

   public function tambah(){
      return view('level_tambah');
  }

  public function tambah_simpan(Request $request){
   LevelModel::create([
       'level_kode' => $request->level_kode,
       'level_nama' => $request->level_nama,
   ]);

   return redirect('/level');
}
}
