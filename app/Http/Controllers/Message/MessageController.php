<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Helpers\MessageHelpers;
use App\Models\User;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return inertia('admin/other/template');
    }

    public function getMessages()
    {
        $message_list = MessageHelpers::get_messages();
        return response()->json($message_list);
    }

    public function inbox_user($user_id, $user_receiver)
    {
        $mensaje_list_user = MessageHelpers::get_inbox_user($user_id, $user_receiver);
        return response()->json($mensaje_list_user);
    }

    public function store(Request $request)
    {
        $message = new Message();
        $message->user_id = $request->user()->id;
        $message->receiver_id = $request->user()->receiver_id;
        $message->content = $request->content;
        $message->save();
        return response()->json(MessageHelpers::get_inbox_user($message->user_id, $message->receiver_id));
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
        $message = MessageHelpers::get_message($id);
        $message->content = $request->content;
        $message->save();
        return response()->json(MessageHelpers::get_inbox_user($message->user_id, $message->receiver_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = MessageHelpers::get_message($id);
        $message->delete();
        return response()->json(MessageHelpers::get_inbox_user($message->user_id, $message->receiver_id));
    }
}
