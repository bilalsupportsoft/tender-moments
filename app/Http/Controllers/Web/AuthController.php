<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use  Session;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ], [
            'password.confirmed' => 'Password and Repeat Password does not match.',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::login($user);
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully!',
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('my-booking')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ]);
        }
    }


    public function logout()
    {
        try {
            Session::flush();
            Auth::logout();
            return redirect()->route("/")->withSuccess('Logout Successful!');
        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }


//......................user-profile.................................///

    public function editprofile()
    {
        return view('web.pages.edit-profile');
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;

        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($user->avatar && File::exists(public_path($user->avatar))) {
                File::delete(public_path($user->avatar));
            }

            // Store new image
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $folder = 'uploads/profile/';
            $path = public_path($folder);

            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $file->move($path, $filename);
            $user->avatar = $folder . $filename;
        }

        $user->save();

        return response()->json(['status' => 'success']);
    }



}
