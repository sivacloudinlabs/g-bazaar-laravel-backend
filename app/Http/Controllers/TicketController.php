<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $banks = Ticket::all();

            return DataTables::of($banks)
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(TicketRequest $request)
    {
        try {
            $ticket = Ticket::create(Ticket::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => CREATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'ticket' => $ticket,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $ticketId)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);

            return response([
                RESPONSE_MESSAGE => EDITED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'ticket' => $ticket,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, string $ticketId)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);
            $ticket->update(Ticket::inputDetails($request));

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'ticket' => $ticket,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ticketId)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);
            $ticket->delete();

            return response([
                RESPONSE_MESSAGE => DELETED_SUCCESSFUL
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateStatus(Request $request, string $ticketId)
    {
        $this->validate($request, [
            'status' => ['required']
        ]);
        
        try {
            $ticket = Ticket::findOrFail($ticketId);
            $ticket->update(['status' => $request->status]);

            return response([
                RESPONSE_MESSAGE => UPDATED_SUCCESSFUL,
                RESPONSE_DATA => [
                    'ticket' => $ticket,
                ],
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response(internalServerError500($exception, static::class, __FUNCTION__), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
