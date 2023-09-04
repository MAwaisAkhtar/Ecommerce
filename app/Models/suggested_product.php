<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suggested_product extends Model
{
    use HasFactory;
    protected $fillable=['user_id','product_id','product_name','category_id','category_name'];
}
