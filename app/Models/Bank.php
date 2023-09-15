<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function inputDetails($request, $id = null)
    {
        return [
            'type' => $request->type,
            'name' => $request->name,
            'logo' => $request->logo,
        ];
    }
}