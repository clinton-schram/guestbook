<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
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
        $userId = Auth::id();
        $messages = Message::all();
        return view('home', ['messages'=> $messages]);
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

}
