<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status'
    ];

    protected $casts = [
        'created_at' => 'date:d/m/Y'
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
