<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::user();
        $user = User::find($userId)->first();
        if($user->level > 0) {
            $messages = Message::where('user_id', $userId)->get()->sortBy('reply_to_id');
        }
        else {
            $messages = Message::all()->sortBy('reply_to_id');    
        }
        
        $arr = [];
        foreach($messages as $message) {
            
            if($message->reply_to_id === null)
            {
                $line = [
                    "body" => $message->body,
                    'reply_to_id' => null,
                    'id' => $message->id,
                ];
                array_push($arr, $line);
            }
            else {
                foreach($arr as $key=>$rootMessage) {
                    if($rootMessage['id'] === $message->reply_to_id)
                    {
                        $line = [
                            "body" => $message->body,
                            'reply_to_id' => null,
                            'id' => $message->id,
                        ];
                        
                       $arr[$key]['messages'][0] = $line;

                   //     array_push($arr[$key], $line);
                        
                    }
                }
            }
            
        }
   

        return view('home', ['messages'=> $arr, 'level' => $user->level]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createMessage(Request $request)
    {
        if ($request->isMethod('post')) {
            $userId = Auth::id();
            $message = new Message;
            $message->body = $request->input('body');
            $message->user_id = $userId;
            $message->save();
            return redirect()->route('home');
            
        }
        return view('message.create');
        
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editMessage(Request $request)
    {
        $message = Message::find($request->id);
        if ($request->isMethod('post')) {
            $message->body = $request->body;
            $message->save();
            return redirect()->route('home');
        }
        return view('message.edit', ['message' => $message ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteMessage(Request $request)
    {
        $message = Message::find($request->id);
        $message->delete();
        return redirect()->route('home');
    }
    
    public function replyToMessage(Request $request)
    {
        
        if ($request->isMethod('post')) {
            
            $userId = Auth::id();
            $message = new Message;
            $message->body = $request->input('body');
            $message->user_id = $userId;
            $message->reply_to_id = $request->replyToId;  
            $message->save();       
            return redirect()->route('home');
            
        }
        $message = Message::find($request->id);
        return view('message.reply', ['message' => $message ]);
    }


}
