<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $guarded = [];

    protected $fillable = [
        'user_id','image','alamat','kelas','phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function savings()
    {
        return $this->belongsTo(User::class);
    }

}
