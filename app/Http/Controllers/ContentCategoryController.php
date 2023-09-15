<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentCategoryRequest;
use App\Models\ContentCategory;
use App\Models\ContentType;
use Exception;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class ContentCategoryController extends Controller
{

    public function index(string $contentTypeId)
    {
        try {
            $contentCategorys = ContentCategory::all();

            return DataTables::of($contentCategorys)
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(ContentCategoryRequest $request, string $contentTypeId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);
            $contentCategory = $contentType->content_categories()->create(ContentCategory::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => CREATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_category' => $contentCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(string $contentTypeId, string $contentCategoryId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);
            $contentCategory = $contentType->content_categories()->findOrFail($contentCategoryId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_category' => $contentCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(ContentCategoryRequest $request, string $contentTypeId, string $contentCategoryId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);
            $contentCategory = $contentType->content_categories()->findOrFail($contentCategoryId);
            $contentCategory->update(ContentCategory::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_category' => $contentCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $contentTypeId, string $contentCategoryId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);
            $contentCategory = $contentType->content_categories()->findOrFail($contentCategoryId);
            $contentCategory->delete();

            return response([
                RESPONSE_MESSAGE => DELETED_SUCCESSFUL
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function onHold(string $contentTypeId, string $contentCategoryId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);
            $contentCategory = $contentType->content_categories()->findOrFail($contentCategoryId);
            $contentCategory->update([
                'is_active' => $contentCategory->is_active ? 0 : 1
            ]);

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_category' => $contentCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function options(string $contentTypeId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);
            $contentCategory = $contentType->content_categories()->selectRaw('name as label, id as value')
                ->where('is_active', 1)
                ->get();

            return response([
                RESPONSE_MESSAGE => RETRIEVAL_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_category' => $contentCategory,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}