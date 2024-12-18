<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        return response()->json(['message'=>'User Created', 'data'=>$user], 200);
    }
    public function show(User $user = null)
    {
        if($user){
            return response()->json(['message' => '', 'data' =>$user],200);
        }
        return response()->json(['message'=>'User not Found', 'data'=>null],404);
    }

    public function show2(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->first();

        return response()->json(['message' => '', 'data' =>$user],200);
    }

    public  function  show_address(User $user = null){
        if($user){
            return response()->json(['message' => '', 'data' =>$user->address],200);
        }
        return response()->json(['message'=>'User not Found', 'data'=>null],404);
    }
    public function list_events(User $user = null)
    {
        if ($user) {
            return response()->json(['message' => 'Eventos de un usuario', 'data' =>$user->events],200);
        }
        return response()->json(['message'=>'User not Found', 'data'=>null],404);
    }
    public function book_event(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'event_id' => 'required|int',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }
        $note = '';
        if ($request->has('note')) {
            $note = $request -> get('note');
        }
        try {
            $user = User::where('id', $request->get('user_id'))->first();
            $event = Event::where('id', $request->get('event_id'))->first();
            if ($user->events()->save($event, ['note' => $note])) {
              return response()->json(['message'=>'Evento reservado', 'data'=>$event],200);
            }
            return response()->json(['message'=>'Evento no reservado', 'data'=>null],400);
        } catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage(), 'data'=>null],400);
        }
    }
}
