<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Type;

class EventTypeController extends Controller
{
    public function create(Request $request)
    {
        if (!auth()->check() || auth()->user()->cannot('create', EventType::class)) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        $event= EventType::create([
            'description' => $request->get('description'),
        ]);
        return response()->json(['message' => '', 'data' => $event], 200);
    }
    public function listTypes()
    {
        $events = EventType::all();
        return response()->json(['message' => '', 'data' => $events], 200);
    }
    public function events(Type $type = null)
    {
        if ($type != null) {
            $event = $type->event;
            return response()->json(['message'=>'Tipos de Eventos', 'data'=>$event], 200);
        }
        return response()->json(['message'=>'No se encuentra el tipo de evento', 'data'=>[]], 404);
    }
}
