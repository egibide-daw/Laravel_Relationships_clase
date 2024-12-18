<?php

namespace App\Http\Controllers;

use App\Models\Address;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    //
    public function show(Address $address = null): \Illuminate\Http\JsonResponse
    {
        if ($address) {
            return response()->json(['message' => '', 'data' => $address], 200);
        }
        return response()->json(['message' => 'Address not found!'], 404);
    }
    public function show_user(Address $address = null)
    {
        if ($address) {
            return response()->json(['message' => '', 'data' =>$address->user], 200);
        }
        return response()->json(['message' => 'Address not found!'], 404);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        $address = Address::create([
            'user_id' => $request->get('user_id'),
            'country' => $request->get('country'),
            'zipcode' => $request->get('zipcode'),
        ]);
        return response()->json(['message' => '', 'data' => $address], 200);
    }
}
