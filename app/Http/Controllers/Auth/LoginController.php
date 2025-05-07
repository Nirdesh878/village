<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }

    // protected function authenticated(Request $request, $user)
    // {

    //     $user = Auth::user();

    //     if ($user->u_type == 'F') {
    //         $this->logout($request);
    //         $this->sendFailedLoginRoleResponse($request, 1);
    //     } elseif (in_array($user->u_type, ['M', 'QA'])) {
    //         return redirect('/qualitycheck');
    //     }
    // }

    protected function sendFailedLoginRoleResponse(Request $request, $cc = 0)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => ['Facilitators are not authorized to login.'],
        ]);
    }

    protected function attemptLogin(Request $request)
    {

        $credentials = $this->credentials($request);
        // prd($credentials);
        $user = User::where($this->username(), $request->{$this->username()})
            ->where('is_deleted', 0)
            ->where('status', 'A')
            ->first();
        // prd($user);
        if ($user && Hash::check($request->password, $user->password)) {


            if ($user->u_type == 'CEO') {
                Auth::login($user);
                return true;
            }elseif($user->u_type == 'F'){
                $this->sendFailedLoginRoleResponse($request, 1);
            }elseif($user->u_type =='M' ){
                session(['otp_user_id' => $user->id, 'email' => $user->email]);
                return redirect('/otp_login');
            }

            return $this->guard()->attempt($credentials, $request->filled('remember'));
        }

        return false;
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }











}
