<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class Product extends Model
{
    use HasFactory;

    public mixed $user_id;
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'price',
        'status'
    ];

    protected $casts = [
        'created_at' => 'date:d/m/Y'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
