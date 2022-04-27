<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
     * Show the user dashboard page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::user();
        $admins = User::all()->where('level', 0);
        $users = User::all()->where('level', ">", 0)->sortBy('level');
        return view('user.elevate', ['users'=> $users, 'admins'=>$admins]);
    }

    /**
     * increase the user lever to admin.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function promoteUser(Request $request)
    {

        $authUser = Auth::user();
        
        if($authUser->level === 0)
        {
            //there is probably a better way to do this but for the purposes of time I will do this workaround
            DB::update('update users set level = 0 where id = ?', [$request->id]);
        }
       // return redirect()->route('user');
    }

    /**
     * Show lower the user level.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function demoteUser(Request $request)
    {

        $userId = Auth::user();
        $authUser = User::find($userId)->first();
        if($authUser->level == 0)
        {
            //there is probably a better way to do this but for the purposes of time I will do this workaround
            DB::update('update users set level = 1 where id = ?', [$request->id]);
        }
        return redirect()->route('user');
    }
}

