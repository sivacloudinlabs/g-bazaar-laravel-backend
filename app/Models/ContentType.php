<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
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
            'name' => $request->name,
            'slug' => $request->slug ?? NULL,
            'content_type_image' => $request->content_type_image ?? NULL,
            'selected_type_image' => $request->selected_type_image ?? NULL,
        ];
    }

    public function content_categories()
    {
        return $this->hasMany(ContentCategory::class, 'content_type_id', 'id');
    }
}