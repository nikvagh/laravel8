<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $validator = Validator::make(request()->all(), [
            'sender_id' => 'required',
            'receiver_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());

        $user = User::where('id',$receiver_id)->get()->first();
        $messageData = $user->messages()
            ->where(function ($query) use($sender_id,$receiver_id) {
                $query->bySender($sender_id)
                    ->byReceiver($receiver_id);
            })
            ->orWhere(function ($query) use($sender_id,$receiver_id) {
                $query->bySender($receiver_id)
                    ->byReceiver($sender_id);
            })->limit(30)
            ->get();

        $result['messageData'] = $messageData;

        return response()->json(['status' => 200, 'title' => 'Users list', "result" => $result]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'title' => $validator->errors()->first()]);
        }

        extract(request()->all());

        $message = Message::create([
            'sender_id'   => $sender_id,
            'receiver_id' => $receiver_id,
            'message'     => $message,
        ]);
        
        // broadcast(new MessageSent($message));

        $result['messageCreated'] = $message->fresh();
        return response()->json(['status' => 200, 'title' => 'Users list', "result" => $result]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
