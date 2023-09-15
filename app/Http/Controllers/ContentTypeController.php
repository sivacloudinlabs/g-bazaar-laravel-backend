<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentTypeRequest;
use App\Models\ContentType;
use Exception;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class ContentTypeController extends Controller
{
    public function index()
    {
        try {
            $contentTypes = ContentType::all();

            return DataTables::of($contentTypes)
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(ContentTypeRequest $request)
    {
        try {
            $contentType = ContentType::create(ContentType::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => CREATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_type' => $contentType,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(string $contentTypeId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_type' => $contentType,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(ContentTypeRequest $request, string $contentTypeId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);
            $contentType->update(ContentType::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_type' => $contentType,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $contentTypeId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);
            $contentType->delete();

            return response([
                RESPONSE_MESSAGE => DELETED_SUCCESSFUL
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function onHold(string $contentTypeId)
    {
        try {
            $contentType = ContentType::findOrFail($contentTypeId);
            $contentType->update([
                'is_active' => $contentType->is_active ? 0 : 1
            ]);

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_type' => $contentType,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function options()
    {
        try {
            $contentTypes = ContentType::query()->selectRaw('name as label, id as value')
                ->where('is_active', 1)
                ->get();

            return response([
                RESPONSE_MESSAGE => RETRIEVAL_SUCCESSFUL,
                RESPONSE_DATA => [
                    'content_types' => $contentTypes,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
