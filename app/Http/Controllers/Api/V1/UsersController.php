<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $validator = Validator::make(request()->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());
        $users = User::orderBy('name')->where('id', '!=', $user_id)->get();

        $result['users'] = $users;
        return response()->json(['status' => 200, 'title' => 'Users list', "result" => $result]);
    }
}
