<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WGAuthController extends Controller
{
    public function auth(Request $request){

        $application_id = "df13c5fa140af811b023333b08201ab5";

        Validator::extend('expires_at_check', function($attribute, $value, $validator) {
            return $value > time();
        });

        $validator = Validator::make($request->all(), [
           'status' => 'required',
           'access_token' => 'required',
           'nickname' => 'required',
           'account_id' => 'required',
           'expires_at' => 'required|expires_at_check',
        ]);

        if($validator->fails()){
            return redirect()->back();
        }

        $check = $this->parse_curl('https://api.worldoftanks.ru/wot/account/info/?application_id=' . $application_id . '&amp;account_id='.$request->account_id. "&amp;access_token=".$request->access_token);

        if($check['status'] == "ok") {

            if (!$user = User::where('account_id', $request->account_id)->first()) {
                if (User::orderBy('id', 'desc')->first())
                    $lastId = User::orderBy('id', 'desc')->first()->id;
                else
                    $lastId = 0;

                $random_pass = Str::random(10);

                $user = User::create([
                    'name' => 'guest' . $lastId,
                    'account_id' => $request->account_id,
                    'nickname' => $request->nickname,
                    'password' => bcrypt($random_pass),
                ]);

                Auth::login($user, true);
                return redirect('/home')->with('random_pass', $random_pass);
            }

            Auth::login($user, true);
            return redirect('home');

        }
        else{
            return redirect()->back();
        }
    }

    public function addAccount(Request $request){

        if(Auth::user()->account_id){
            return redirect()->back();
        }

        $application_id = "df13c5fa140af811b023333b08201ab5";

        Validator::extend('expires_at_check', function($attribute, $value, $validator) {
            return $value > time();
        });

        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'access_token' => 'required',
            'nickname' => 'required',
            'account_id' => 'required',
            'expires_at' => 'required|expires_at_check',
        ]);

        if($validator->fails()){
            return redirect()->back();
        }

        $check = $this->parse_curl('https://api.worldoftanks.ru/wot/account/info/?application_id=' . $application_id . '&amp;account_id='.$request->account_id. "&amp;access_token=".$request->access_token);

        if($check['status'] == "ok") {
            $user = Auth::user();

            if (!$user->account_id) {
            $user->account_id =  $request->account_id;
            $user->nickname = $request->nickname;
            $user->save();
            }

            return redirect()->route('home');
        }
        else{
            return redirect()->back();
        }
    }

    public function changeNickname(Request $request){

        if(!preg_match("~^guest\d+~", Auth::user()->name)){
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha_dash',
        ]);

        if($validator->fails()){
            return redirect()->back();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();
        return redirect()->route('home');
    }

    public function setPassword(Request $request){

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);

        if($validator->fails()){
            return redirect()->back();
        }

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('home');
    }

    public function parse_curl ($link){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $result=json_decode($result, true);
        curl_close($curl);

        return $result;
    }
}
