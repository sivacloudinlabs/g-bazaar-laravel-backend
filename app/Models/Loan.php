<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getPersonalInformationAttribute($value)
    {
        return json_decode($value, true);  
    }
    public function getCommunicationAddressAttribute($value)
    {
        return json_decode($value, true);  
    }
    public function getPermanentAddressAttribute($value)
    {
        return json_decode($value, true);  
    }
    public function getWorkInformationAttribute($value)
    {
        return json_decode($value, true);  
    }
    public function getUploadDocumentAttribute($value)
    {
        return json_decode($value, true);  
    }
    public function getOthersAttribute($value)
    {
        return json_decode($value, true);  
    }
    
    public function applied_user()
    {
        return $this->belongsTo(User::class, 'applied_user_id', 'id')->selectRaw('id, name, number, email');
    }

    public function processing_user()
    {
        return $this->belongsTo(User::class, 'processing_user_id', 'id')->selectRaw('id, name, number, email');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    public static function inputDetails($request)
    {
        return [
            'offer_id' => $request->offer_id,
            'applied_user_id' => $request->applied_user_id ?? auth()->user()->id,
            'requested_amount' => $request->requested_amount,
            'loan_term' => $request->loan_term,
            'quoted_amount' => $request->quoted_amount,
            'others' => json_encode($request->others),
            'personal_information' => json_encode($request->personal_information),
            'communication_address' => json_encode($request->communication_address),
            'permanent_address' => json_encode($request->permanent_address),
            'work_information' => json_encode($request->work_information),
            'upload_document' => json_encode($request->upload_document),
            'status' => $request->status ?? 'draft',
            'digital_signature' => $request->digital_signature
        ];
    }
}