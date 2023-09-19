<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OfferInterestUserController extends Controller
{
    public function store(Request $request, $offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            $isExists = $offer->offer_interest_users()->where('user_id', auth()->user()->id)->exists();

            if($isExists){
                return response([
                    RESPONSE_MESSAGE => ALREADY_SEND_INTEREST,
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $offer->offer_interest_users()->create([
                'user_id' => auth()->user()->id
            ]);

            return response([
                RESPONSE_MESSAGE => SEND_INTEREST_SUCCESSFUL,
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
