<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferCategoryRequest;
use App\Models\OfferCategory;
use App\Models\OfferType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class OfferCategoryController extends Controller
{
    public function index(string $offerTypeId)
    {
        try {
            $typeCategorys = OfferCategory::all();

            return DataTables::of($typeCategorys)
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(OfferCategoryRequest $request, string $offerTypeId)
    {
        try {
            $offerType = OfferType::findOrFail($offerTypeId);
            $typeCategory = $offerType->offer_categories()->create(OfferCategory::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => CREATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'type_category' => $typeCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(string $offerTypeId, string $typeCategoryId)
    {
        try {
            $offerType = OfferType::findOrFail($offerTypeId);
            $typeCategory = $offerType->offer_categories()->findOrFail($typeCategoryId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'type_category' => $typeCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(OfferCategoryRequest $request, string $offerTypeId, string $typeCategoryId)
    {
        try {
            $offerType = OfferType::findOrFail($offerTypeId);
            $typeCategory = $offerType->offer_categories()->findOrFail($typeCategoryId);
            $typeCategory->update(OfferCategory::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'type_category' => $typeCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $offerTypeId, string $typeCategoryId)
    {
        try {
            $offerType = OfferType::findOrFail($offerTypeId);
            $typeCategory = $offerType->offer_categories()->findOrFail($typeCategoryId);
            $typeCategory->delete();

            return response([
                RESPONSE_MESSAGE => DELETED_SUCCESSFUL
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function onHold(string $offerTypeId, string $typeCategoryId)
    {
        try {
            $offerType = OfferType::findOrFail($offerTypeId);
            $typeCategory = $offerType->offer_categories()->findOrFail($typeCategoryId);
            $typeCategory->update([
                'is_active' => $typeCategory->is_active ? 0 : 1
            ]);

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'type_category' => $typeCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function options(string $offerTypeId)
    {
        try {
            $offerType = OfferType::findOrFail($offerTypeId);
            $typeCategory = $offerType->offer_categories()->selectRaw('name as label, id as value')
                ->where('is_active', 1)
                ->get();

            return response([
                RESPONSE_MESSAGE => RETRIEVAL_SUCCESSFUL,
                RESPONSE_DATA => [
                    'type_category' => $typeCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
