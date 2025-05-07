<?php

namespace App\Http\Controllers;

use App\Models\ChangePassword;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{

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
        return view('users.changePassword');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation_arr = [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ];

        $validator = Validator::make($request->all(), $validation_arr);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::User();
        $newUser = User::find($user->id);
        if($request->post('new_confirm_password')!='')
        {
            $newUser->password = Hash::make($request->post('new_confirm_password'));
            $newUser->password_show = $request->post('new_confirm_password');
        }
        $result = $newUser->save();
        //User::find($user->id)->update(['password'=> Hash::make($request->new_password),'password_show'=>$request->post('new_confirm_password')]);
        // if((Hash::check('Password@123', $user->password)) && ($user->default_password == 1))
        // {
        //     $newUser = User::find($user->id);
        //     // DB::enableQueryLog();
        //     $newUser->password = Hash::make($request->new_password);
        //     $newUser->default_password = '0';
        //     $newUser->save();
        //     // $query = DB::getQueryLog();
        //     // prd($query);
        //     return redirect('login')->with(['message' => 'Password changed successfully.'],Auth::logout());

        // }
        // else
        // {
        //     User::find($user->id)->update(['password'=> Hash::make($request->new_password)]);
        // }
        // dd('sdfsdf');

        return redirect('change-password')->with(['message' => 'Password changed successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChangePassword  $changePassword
     * @return \Illuminate\Http\Response
     */
    public function show(ChangePassword $changePassword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChangePassword  $changePassword
     * @return \Illuminate\Http\Response
     */
    public function edit(ChangePassword $changePassword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChangePassword  $changePassword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChangePassword $changePassword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChangePassword  $changePassword
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChangePassword $changePassword)
    {
        //
    }
}
