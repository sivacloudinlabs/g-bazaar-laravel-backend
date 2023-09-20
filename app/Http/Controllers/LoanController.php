<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Models\Loan;
use App\Models\Offer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class LoanController extends Controller
{
    public function index()
    {
        try {
            $loan = Loan::all();

            return DataTables::of($loan)
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(LoanRequest $request)
    {
        try {
            $offer = Offer::find($request->offer_id);
            $isExistsLoan = Loan::where('offer_id', $offer->id)
            ->where('applied_user_id', $request->applied_user_id ??auth()->user()->id)
            ->exists();
            if($isExistsLoan) {
                return response([
                    RESPONSE_MESSAGE => ALREADY_SEND_INTEREST,
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $loan = Loan::create(Loan::inputDetails($request));
            $offerCategoryName = $offer?->offer_category?->name;
            preg_match_all('/(?<=\b)\w/iu', $offerCategoryName ?? 'Loan', $matches);
            $getShotNameForTemporaryCode = mb_strtoupper(implode('', $matches[0]));

            $loan->temporary_code = Str::upper('TMP' . $loan->id . $getShotNameForTemporaryCode . Str::random(7));
            $loan->save();

            return response([
                RESPONSE_MESSAGE => CREATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'loan' => $loan,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $loanId)
    {
        try {
            $offer = Loan::findOrFail($loanId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'offer' => $offer,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(string $loanId)
    {
        try {
            $offer = Loan::findOrFail($loanId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'offer' => $offer,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $loanId)
    {
        try {
            $offer = Loan::findOrFail($loanId);
            $offer->update(Loan::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'offer' => $offer,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $loanId)
    {
        try {
            $offer = Loan::findOrFail($loanId);
            $offer->delete();

            return response([
                RESPONSE_MESSAGE => DELETED_SUCCESSFUL
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}