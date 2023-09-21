<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Models\Loan;
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
            $loan = loan::find($request->loan_id);
            $isExistsLoan = Loan::where('loan_id', $loan->id)
                ->where('applied_user_id', $request->applied_user_id ?? auth()->user()->id)
                ->exists();
            if ($isExistsLoan) {
                return response([
                    RESPONSE_MESSAGE => ALREADY_SEND_INTEREST,
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $loan = Loan::create(Loan::inputDetails($request));
            $loanCategoryName = $loan?->loan_category?->name;
            preg_match_all('/(?<=\b)\w/iu', $loanCategoryName ?? 'Loan', $matches);
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
            $loan = Loan::findOrFail($loanId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'loan' => $loan,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function applyLoan(string $loanId)
    {
        try {
            
            $loan = Loan::findOrFail($loanId);
            
            $loanCategoryName = $loan?->loan_category?->name;
            preg_match_all('/(?<=\b)\w/iu', $loanCategoryName ?? 'Loan', $matches);
            $getShotNameForTemporaryCode = mb_strtoupper(implode('', $matches[0]));

            $loan->update([
                'status' => LOAN_STATUS_APPLIED,
                'loan_code' => Str::upper($loan->id . $getShotNameForTemporaryCode . Str::random(7))
            ]);

            return response([
                RESPONSE_MESSAGE => SEND_INTEREST_SUCCESSFUL,
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(string $loanId)
    {
        try {
            $loan = Loan::findOrFail($loanId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'loan' => $loan,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $loanId)
    {
        try {
            $loan = Loan::findOrFail($loanId);
            $loan->update(Loan::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'loan' => $loan,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $loanId)
    {
        try {
            $loan = Loan::findOrFail($loanId);
            $loan->delete();

            return response([
                RESPONSE_MESSAGE => DELETED_SUCCESSFUL
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}