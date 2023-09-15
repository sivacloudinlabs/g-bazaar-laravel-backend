<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();

            return DataTables::of($users)
                ->addIndexColumn()
                // ->addColumn('action', function($row){

                //        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                //         return $btn;
                // })
                // ->rawColumns(['action'])
                ->make(true);
            // return response([
            //     RESPONSE_MESSAGE => RETRIEVAL_SUCCESSFUL,
            //     RESPONSE_DATA => [
            //         'user' => $users,
            //     ],
            // ], Response::HTTP_OK);
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