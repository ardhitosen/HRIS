<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{
    use HasFactory;
    protected $primaryKey = "reimburse_id";
    protected $fillable = [
        'status', 
    ];
}
