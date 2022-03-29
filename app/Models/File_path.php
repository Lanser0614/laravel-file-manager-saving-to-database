<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File_path extends Model
{
    use HasFactory;

    protected $table = 'file_paths';

    protected $fillable = ['user_id', 'path'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
