<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
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
            'requested_by' => $request->requested_by,
            'assign_to' => $request->assign_to,
            'closed_by' => $request->closed_by,
            'title' => $request->title,
            'priority' => $request->priority,
            'status' => $request->status ?? NULL,
            'issue' => $request->issue,
            'attachment' => $request->attachment ?? NULL,
        ];
    }
}