<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokModel extends Model
{
    use HasFactory;

    protected $table = 't_stok'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'stok_id'; //Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = ['stok_id','barang_id','user_id','stok_tanggal','stok_jumlah'];

    public function barang(): BelongsTo{
        return $this->belongsTo(BarangModel::class,'barang_id','barang_id');
    }
    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class,'user_id','user_id');
    }
}
