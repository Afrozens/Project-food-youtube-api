<?php

namespace App\Helpers;

use App\Models\Message;

class MessageHelpers
{

    public static function get_messages()
    {
        $message_list = Message::all();
        $messages = collect();
        $messages->push($message_list);
        $messages->collapse();
        return $messages;
    }


    public static function get_inbox_user($user_id, $user_receiver)
    {

        $message_lists_user = Message::where('user_id', $user_id)
            ->where('user_receiver', $user_receiver)->get();
        return $message_lists_user;
    }

    public static function get_message($id)
    {
        $message = Message::find($id);
        return $message;
    }
}
