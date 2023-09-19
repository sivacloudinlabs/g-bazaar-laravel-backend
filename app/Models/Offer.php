<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
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
            'offer_type_id' => $request->offer_type_id ?? null,
            'offer_category_id' => $request->offer_category_id ?? null,
            'bank_id' => $request->bank_id ?? null,
            'starting_date' => $request->starting_date ?? null,
            'ending_date' => $request->ending_date ?? null,
            'min_cibil' => $request->min_cibil ?? null,
            'max_cibil' => $request->max_cibil ?? null,
            'offer_title' => $request->offer_title ?? null,
            'secondary_title' => $request->secondary_title ?? null,
            'offer_banner' => $request->offer_banner ?? null,
            'offer_description' => $request->offer_description ?? null,
            'offer_terms' => $request->offer_terms ?? null,
            'feature_list' => json_encode($request->feature_list) ?? null,
        ];
    }

    public function offer_category()
    {
        return $this->belongsTo(OfferCategory::class, 'offer_category_id', 'id')->selectRaw('id, name');
    }

    public function offer_type()
    {
        return $this->belongsTo(OfferType::class, 'offer_type_id', 'id')->selectRaw('id, name');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id')->selectRaw('id, name');
    }

    public function offer_interest_users()
    {
        return $this->hasMany(OfferInterestUser::class, 'offer_id', 'id');
    }
}