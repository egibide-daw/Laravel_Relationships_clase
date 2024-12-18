<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{



    public function list_users(Event $event = null)
    {
        if ($event != null) {
            $users = $event->users;
            return response()->json(['message'=>'Usuarios nuevo evento', 'data'=>$users], 200);
        }
        return response()->json(['message'=>'No se encuentra el evento', 'data'=>[]], 404);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'event_detail' => 'required',
            'event_type_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        $event= Event::create([
            'event_name' => $request->get('event_name'),
            'event_detail' => $request->get('event_detail'),
            'event_type_id' => $request->get('event_type_id'),
        ]);
        return response()->json(['message' => '', 'data' => $event], 200);
    }
}
