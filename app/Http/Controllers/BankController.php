<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankRequest;
use App\Models\Bank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'search' => ['sometimes', 'nullable', 'string'],
            'per_page' => ['sometimes', 'nullable', 'numeric', 'max:50'],
            'type' => ['sometimes', 'nullable', 'in:' . implode(',', BANK_TYPES)],
        ]);

        try {
            $banks = Bank::when(($request->search ?? false), function ($query) use ($request) {
                 $query->where(function ($whereQuery) use ($request) {
                     $whereQuery->whereLike(['type', 'name', 'code'], $request->search);
                 });
             })->when($request->type ?? false, function ($query) use ($request) {
                 $query->where('type', $request->type);
             })->paginate($request->per_page ?? DEFAULT_PER_PAGE);
 
             return response([
                 RESPONSE_MESSAGE => RETRIEVAL_SUCCESSFUL,
                 RESPONSE_DATA => [
                     'banks' => $banks,
                     'filters' => $request->all()
                 ],
             ], Response::HTTP_OK);;
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(BankRequest $request)
    {
        try {
            $bank = Bank::create(Bank::inputDetails($request));
            $bank->code = Str::upper($bank->name . '_' . $bank->id);
            $bank->save();

            return response([
                RESPONSE_MESSAGE => CREATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'bank' => $bank,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(string $bankId)
    {
        try {
            $bank = Bank::findOrFail($bankId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'bank' => $bank,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(BankRequest $request, string $bankId)
    {
        try {
            $bank = Bank::findOrFail($bankId);
            $bank->update(Bank::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'bank' => $bank,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $bankId)
    {
        try {
            $bank = Bank::findOrFail($bankId);
            $bank->delete();

            return response([
                RESPONSE_MESSAGE => DELETED_SUCCESSFUL
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function onHold(string $bankId)
    {
        try {
            $bank = Bank::findOrFail($bankId);
            $bank->update([
                'is_active' => $bank->is_active ? 0 : 1
            ]);

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'bank' => $bank,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function options()
    {
        try {
            $banks = Bank::query()->selectRaw('name as label, id as value')
                ->where('is_active', 1)
                ->get();

            return response([
                RESPONSE_MESSAGE => RETRIEVAL_SUCCESSFUL,
                RESPONSE_DATA => [
                    'banks' => $banks,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}