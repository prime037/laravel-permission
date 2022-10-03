<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'barang';
    protected $fillable = [
        'name' , 'jumlah','deleted_at'
    ];
    public $timestamps = false;
    protected $dates = ['deleted_at'];
}
