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
            $messages = Message::all();    
        }
        
        $arr = $this->buildTree($messages->toArray() , 0);
    
        return view('home', ['messages'=> $arr, 'level' => $user->level, 'user_id' => $user->id]);
    }

    /**
     * Show add a new message.
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
     * edit an existing message.
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
        return view('message.edit', ['message' => $message]);
    }

    /**
     * delete a message.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteMessage(Request $request)
    {
        $this->deleteMessageRecursive($request->id);
        return redirect()->route('home');
    }
    
    private function deleteMessageRecursive($messageId)
    {
        $messages = Message::all()->where('reply_to_id' , $messageId);
        if(!empty($messages)) {
            foreach($messages as $message) {
                $this->deleteMessageRecursive($message->id);
            }
        } else {
            $message->delete();
        }

        $message = Message::find($request->id);
        $message->delete();
    }

    /**
     * admin reply to message.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
        return view('message.reply', ['message' => $message]);
    }

    /**
     * build a recursive message tree
     *
     * @return array
     */
    function buildTree(array $elements, $parentId = 0) {
    
        $branch = array();
    
        foreach ($elements as $element) 
        {
            if ($element['reply_to_id'] == $parentId) 
            {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) 
                {
                    $element['messages'] = $children;
                }
                $branch[] = $element;
            }
        }
    
        return $branch;
    }


}
