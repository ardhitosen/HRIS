<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeoff extends Model
{
    use HasFactory;
    protected $primaryKey = "timeoff_id";
    protected $fillable = [
        'status', 
    ];
}
