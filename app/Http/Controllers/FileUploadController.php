<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload(){
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request){
        // dump($request->berkas);
        // dump($request->file('berkas'));
        // return "Pemrosesan file upload di sini";

        // if($request->hasFile('berkas')) {
        //     echo "path(): ".$request->berkas->path();
        //     echo "<br>";
        //     echo "extension(): ".$request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension(): ".
        //     $request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType(): ".$request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getClientOriginalName(): ".
        //     $request->berkas->getClientOriginalName();
        //     echo "<br>";
        //     echo "getSize(): ".$request->berkas->getSize();
        // }

        $request->validate([
            'berkas'=>'required|file|image|max:5000'
        ]);

        // $path = $request->berkas->store('uploads');
        $extFile=$request->berkas->getClientOriginalExtension();
        $namaFile ='web-'.time().".".$extFile;
        $path = $request->berkas->storeAs('public',$namaFile);

        $pathBaru=asset('storage/'.$namaFile);
        echo "proses upload berhasil, data disimpan di : $path";
        echo "<br>";
        echo "Tampilkan link:<a href='$pathBaru'>$pathBaru</a>";
        // echo $request->berkas->getClientOriginalName()."lolos validasi";
    }
}
