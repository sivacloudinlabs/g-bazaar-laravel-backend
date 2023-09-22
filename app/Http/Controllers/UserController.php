<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'search' => ['sometimes', 'nullable', 'string'],
            'per_page' => ['sometimes', 'nullable', 'numeric', 'max:50'],
            'role' => ['sometimes', 'nullable', 'exists:roles,name'],
        ]);

        try {
            // TODO: toSqlWithBindings
            $users = User::with(['reporting_to'])->when(($request->search ?? false), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($whereQuery) use ($search) {
                    // TODO: This is custom function, the function given by AppServiceProvider
                    $whereQuery->multiWhereLike(['name', 'email', 'number', 'gender'], $search);
                    // Check relationship reporting_to
                    $whereQuery->orWhereHas('reporting_to', function ($whereHasQuery) use ($search) {
                        $whereHasQuery->where(function ($whereHasQuery) use ($search) {
                            $whereHasQuery->multiWhereLike(['name', 'email', 'number'], $search);
                        });
                    });
                });
            })->when($request->role ?? false, function ($query) use ($request) {
                $query->whereHas('roles', function ($whereHasQuery) use ($request) {
                    $whereHasQuery->where('name', $request->role);
                });
            })->paginate($request->per_page ?? DEFAULT_PER_PAGE);

            return response([
                RESPONSE_MESSAGE => RETRIEVAL_SUCCESSFUL,
                RESPONSE_DATA => [
                    'users' => $users,
                    'filters' => $request->all()
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();

            $input = User::inputDetails($request);

            $user = User::create($input['user']);
            $user->user_detail()->create($input['basic_details']);

            $user->assignRole([$request->role]);

            DB::commit();

            return response([
                RESPONSE_MESSAGE => CREATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'user' => $user,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();

            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(string $userId)
    {
        try {
            DB::beginTransaction();

            $user = User::with(['user_detail'])->findOrFail($userId);

            DB::commit();

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'user' => $user,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();

            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UserRequest $request, string $userId)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($userId);
            $input = User::inputDetails($request);
            $user->update($input['user']);
            $user->user_detail()->update($input['basic_details']);

            DB::commit();

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'user' => $user,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();

            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $userId)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($userId);
            $user->user_detail()->delete();
            $user->delete();
            DB::commit();

            return response([
                RESPONSE_MESSAGE => DELETED_SUCCESSFUL,
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            DB::rollBack();

            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}