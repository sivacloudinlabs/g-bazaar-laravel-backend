<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\UserDetail;
use App\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, ActivityTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'number',
        'password',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $guard_name = 'api';

    public function user_detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    public function reporting_to()
    {
        return $this->belongsTo(User::class, 'reporting_to', 'id');
    }

    public static function inputDetails($request)
    {
        return [
            'user' => [
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'gender' => $request->gender,
                'password' => Hash::make($request->number),
            ],
            'basic_details' => [
                'date_of_birth' => $request->date_of_birth ?? NULL,
                'pan_card_number' => $request->pan_card_number ?? NULL,
                'aadhar_card_number' => $request->aadhar_card_number ?? NULL,
                'occupation_type' => $request->occupation_type ?? NULL,
                'organization_name' => $request->organization_name ?? NULL,
                'monthly_income' => $request->monthly_income ?? NULL,
                'area' => $request->area ?? NULL,
                'landmark' => $request->landmark ?? NULL,
                'city' => $request->city ?? NULL,
                'district' => $request->district ?? NULL,
                'state' => $request->state ?? NULL,
                'pincode' => $request->pincode ?? NULL
            ]
        ];
    }
}