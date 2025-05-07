<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;



class AuthOtpController extends Controller
{
    protected function username()
    {
        return 'email'; // Or 'username', depending on your authentication field
    }

    // public function __construct()
    // {
    //     $this->middleware('guest')->except(['logout']);
    // }


    // Return View of OTP Login Page
    public function login()
    {

        return view('auth.otp-login');
    }



    // Generate OTP
    public function generate(Request $request)
    {

            $user = User::where($this->username(), $request->{$this->username()})
                ->where('is_deleted', 0)
                ->where('status', 'A')
                ->first();

            if(!empty($user)){
                if ($user && Hash::check($request->password, $user->password)) {
                    if ($user->u_type == 'CEO') {
                        Auth::login($user);
                        $time=date_default_timezone_set("Asia/Kolkata");
                        $action=1;
                        $user_id=$user->id;
                        $u_type=$user->u_type;
                        $time=date('H:i a');
                        $user_ip = request()->header('X-Forwarded-For') ?? request()->ip();
                        logindetails($user_id,$action,$u_type,$user_ip,$time);
                        return redirect('/home');
                    }elseif($user->u_type == 'F'){
                        return redirect()->back()->with('error', 'FF are not authorized to login.');
                    }elseif($user->u_type =='M' || $user->u_type =='QA' || $user->u_type == 'A'){
                        # Generate An OTP
                        $verificationCode = $this->generateOtp($request);

                        $email = $user->email;
                        $data['otp'] =  $verificationCode->otp;
                        $data['name'] = $user->name;
                        // send_otp($email, $data);
                        session(['user_id' => $user->id, 'email' => $user->email]);
                        $message = "Otp Sent Succesfully.";
                        return redirect()->route('otp.login')->with('success',  $message);
                    }
                }else{
                     return redirect()->back()->with('error', 'Invalid login credentials.');
                }
            }else{

                return redirect()->back()->with('error', 'Invalid login credentials.');
            }



    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function generateOtp(Request $request)
    {
        $user = User::where($this->username(), $request->{$this->username()})
            ->where('is_deleted', 0)
            ->where('status', 'A')
            ->first();

        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();
        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }

        if ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
            // Update the existing OTP
            $verificationCode->otp = 123456; // Generate a new OTP or use a fixed one
            $verificationCode->expire_at = Carbon::now()->addMinutes(10);
            $verificationCode->save();

            return $verificationCode;
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $user->id,
            // 'otp' => rand(123456, 999999),
            'otp' => 123456,
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }


    // Re Generate OTP
    public function regenerate(Request $request)
    {

        # Generate An OTP
        $verificationCode = $this->generateOtp($request);


        $message = "Re-Send OTP Succesfully. ";
        # Return With OTP

        return redirect()->route('otp.login')->with('success',  $message);
    }





    public function loginWithOtp(Request $request)
    {
        #Validation
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);

        #Validation Logic
        $verificationCode   = VerificationCode::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

        $now = Carbon::now();
        if (!$verificationCode) {
            return redirect()->back()->with('error', 'Your OTP is not correct');
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            return redirect()->back()->with('error', 'Your OTP has been expired');
        }

        $user = User::whereId($request->user_id)->first();

        if($user){
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);

            Auth::login($user);

            if($user->u_type == 'M' || $user->u_type == 'QA')
            {
                $user_otp=User::find($user->id);
                $user_otp->save();
                VerificationCode::where('user_id', '=', $user->id)->delete();
                $time=date_default_timezone_set("Asia/Kolkata");
                $action=1;
                $user_id=$user->id;
                $u_type=$user->u_type;
                $time=date('H:i a');
                $user_ip = request()->header('X-Forwarded-For') ?? request()->ip();
                logindetails($user_id,$action,$u_type,$user_ip,$time);
                return redirect('/qualitycheck');

            }
            else
            {
                $user_otp=User::find($user->id);
                $user_otp->save();
                VerificationCode::where('user_id', '=', $user->id)->delete();
                $time=date_default_timezone_set("Asia/Kolkata");
                $action=1;
                $user_id=$user->id;
                $u_type=$user->u_type;
                $time=date('H:i a');
                $user_ip = request()->header('X-Forwarded-For') ?? request()->ip();
                logindetails($user_id,$action,$u_type,$user_ip,$time);
                return redirect('/home');
            }

        }

        return redirect('/otp_login')->with('error', 'Your Otp is not correct');
    }
}
