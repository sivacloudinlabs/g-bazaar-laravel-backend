<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function inputDetails($request)
    {
        return [
            'name' => $request->name,
            'category_image' => $request->category_image ?? NULL,
            'selected_category_image' => $request->selected_category_image ?? NULL,
        ];
    }
}