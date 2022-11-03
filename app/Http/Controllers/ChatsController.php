<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use DB;
use Log;

class ChatsController extends Controller
{
    public function __construct()
    {
        // only allow authorised users to access ChatsController’s methods.
        $this->middleware('auth');
    }
    public function index()
    {
        return view('chat');
    }
    
    // all messages with the user that sent that message
    public function fetchMessages()
    {
        return Message::with('user')->from(function ($query) {
            $query->select('*')->orderBy('id','DESC')->take(10)->from('messages');
        }, 'a')->orderBy('id','ASC')->get();
    }

    //save the message into the database.
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);
        broadcast(new MessageSent($user, $message))->toOthers();

        return ['state' => "Message Sent"];
    }
}
