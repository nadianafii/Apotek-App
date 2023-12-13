<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'medicines', 'name_customer', 'total_price', 'create_at' , 'update_at'
    ];

    protected $casts = [
        'medicines' => 'array',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

  public function user()
  {
    //membuat relasi ke table lain dgn tipe one to many
    //dalam kurung merupakan nama model yang akan disambungkan (tempatFK)
    return $this->belongsTo(User::class);
  }
};