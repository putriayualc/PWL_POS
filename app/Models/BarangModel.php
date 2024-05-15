<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'barang_id'; //Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = ['kategori_id','barang_kode','barang_nama','harga_beli','harga_jual','image'];

    public function barang(): BelongsTo{
        return $this->belongsTo(KategoriModel::class,'kategori_id','kategori_id');
    }

    public function image(): Attribute{
        return Attribute::make(
            get: fn ($image) => url('/storage/'. $image)
        );
    }
}