<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use App\Repository\UserRepository;
use App\Repository\UsertypeRepository;



class AuthController extends Controller
{

    public static function register()
    {
        // render register from
        $usertypes = UsertypeRepository::getAllUsertype();
        return view('auth/register', compact('usertypes'));
    }

    public static function registerPost(Request $req)
    {
        // recive from save to db
        $username = $req->username;
        $password = $req->password;
        $userTypeId = $req->userTypeId;
        $department = $req->department;
        $phone = $req->phone;

        // UserRepository::save($email, $password, $username, $firstName, $lastName, $userTypeId);
        UserRepository::save( $password,$username,  $userTypeId , $department, $phone);

        return redirect('/register');
    }

    public static function login()
    {
        // render login from
        return view('auth/login');
    }

    public static function loginPost(Request $req)
    {
        // recive data to login
        $credetials = [
            'username' => $req->username,
            'password' => $req->password,
        ];

        if (Auth::attempt($credetials)) {
            $req->session()->regenerate();
            return redirect('/home');
        }
        return redirect('/login')->with('message', 'กรอกข้อมูลผู้ใช้ผิดหรือยังไม่ได้ลงทะเบียน');
    }


    public static function loginRoomId($roomId)
    {
        return view('auth/loginbooking', compact('roomId'));
    }


    public static function loginPostRoomId(Request $req)
    {
        $roomId = $req->roomId;
        $credetials = [
            'username' => $req->username,
            'password' => $req->password,
        ];

        if (Auth::attempt($credetials)) {
            $req->session()->regenerate();
            return redirect('/booking/' . $roomId);
        }

        // return redirect('/login/'.$roomId)->with('message','กรอกข้อมูลผู้ใช้ผิดหรือยังไม่ได้ลงทะเบียน');
        return redirect('/login/' . $roomId)->with('message', 'กรุณากรอกข้อมูลใหม่');
    }


    public static function home()
    {
        $department = Auth::user()->department;
        $phone = Auth::user()->phone;

        // echo "Name is: ".$firstName." ".$lastName;

        if (Auth::user()->userTypeId == 1) {
            return redirect('/admin/dashbord');
        } elseif (Auth::user()->userTypeId == 2) {
            return redirect('/user/dashbord');
        }
    }


    public static function logout()
    {
        Auth::logout();
        // return redirect('/login');
        return redirect('/');
    }
    public static function updatepassword(Request $req)
    {
        $req->validate([
            // 'old_password' => 'required',
            // 'comfirm_password' => 'required|comfirmed',
            // 'password' => 'required|comfirmed',
                // 'new_password' => 'required'
            // 'new_password' => 'required'
            // 'comfirm_password' => 'required'
        'new_password' => 'required|confirmed',
        'new_password_confirmation' => 'required'

        ]);
        // if (!Hash::check($req->old_password, auth()->user()->getAuthPassword())) {
        //     // if(!Hash::check($req->old_password,auth()->user()->getAuthPasswordrd())){
        //     return back()->with("error", "Old password not match");
        // }
        User::where('userId','=',Auth::user()->userId)->update([
            'password' => Hash::make($req->new_password)
        ]);

        // return back()->with("status", "Password changed successfully!");
        return redirect('/setting')->with('success', 'Password updated successfully!');
        // return view('/setting',compact('user'));
    }
    public static function settingpassword() {
        // $email = Auth::user()->email;
        $username = Auth::user()->username;
        return view('auth/setting',compact('username'));
    }


    public static function changePassword(){
        return view('auth/newpassword');
    }

    public static function changePasswordPost(Request $req){
        User::where('username','=',$req->username)->update([
            'password' => Hash::make($req->password)
        ]);

        return redirect('/login')->with('messageok', 'เปลี่ยนรหัสผ่านแล้วกรุณา login');
    }

}
