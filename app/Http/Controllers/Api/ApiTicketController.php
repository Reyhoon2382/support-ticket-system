<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTicketController extends Controller
{
    public function index()
    {
        return Ticket::paginate(10);
    }

    public function store(Request $request)
    {
        $ticket= Ticket::create([
            'ticket_number'=>'TCK-' . strtoupper(Str::random(8)),
            'user_id'=>auth()->id(),
            'title'=>$request->title,
            'description'=>$request->description,
        ]);

        return response()->json($ticket, 201);
    }
}
