<?php

namespace App\Http\Controllers;

use App\Models\OfferType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class OfferTypeController extends Controller
{
    public function index()
    {
        try {
            $offerTypes = OfferType::all();

            return DataTables::of($offerTypes)
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'unique:offer_types,name,null']
        ]);

        try {
            $offerType = OfferType::create(['name' => $request->name]);

            return response([
                RESPONSE_MESSAGE => CREATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'offer_type' => $offerType,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(string $offerTypeId)
    {
        try {
            $offerType = OfferType::findOrFail($offerTypeId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'offer_type' => $offerType,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $offerTypeId)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'unique:offer_types,name,' . $offerTypeId]
        ]);

        try {
            $offerType = OfferType::findOrFail($offerTypeId);
            $offerType->update(['name' => $request->name]);

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'offer_type' => $offerType,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $offerTypeId)
    {
        try {
            $offerType = OfferType::findOrFail($offerTypeId);
            $offerType->delete();

            return response([
                RESPONSE_MESSAGE => DELETED_SUCCESSFUL
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function onHold(string $offerTypeId)
    {
        try {
            $offerType = OfferType::findOrFail($offerTypeId);
            $offerType->update([
                'is_active' => $offerType->is_active ? 0 : 1
            ]);

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'offer_type' => $offerType,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function options()
    {
        try {
            $offerTypes = OfferType::query()->selectRaw('name as label, id as value')
                ->where('is_active', 1)
                ->get();

            return response([
                RESPONSE_MESSAGE => RETRIEVAL_SUCCESSFUL,
                RESPONSE_DATA => [
                    'offer_types' => $offerTypes,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}