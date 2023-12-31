<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Top5Climas extends Model
{
    protected $table = 'top5_climas';
    protected $fillable = ['temp','cp','ciudad'];
    use HasFactory;
}
