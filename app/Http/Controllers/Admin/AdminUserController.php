<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use Mail,Hash,File,Auth,DB,Helper,Exception,Session,Redirect,Validator;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\NotificationUser;

class AdminUserController extends Controller
{
    //========================= User Member Funcations ========================//

    public function index() {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();
        return view('admin.users.index',compact('users'));
    }

    public function userStatus(Request $request) {
        try
        {
            $userid = $request->userid;
            $status = $request->status;
            $user = User::find($userid);
            $user->status = $status;
            $user->save();
            return response()->json(['success' => true]);

        }catch(Exception $e){
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }


    public function profile(){
        $user = Auth::user();
        return view('web.auth.profile',compact('user'));
    }

    public function show($id) {
        try {
            $user = User::findOrFail($id);

            // Get all bookings for this user
            $bookings = Booking::where('user_id', $id)
                ->with('slot') // eager load slot details if relation exists
                ->latest()
                ->get();

            return view('admin.users.show', compact('user', 'bookings'));

        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }



}
