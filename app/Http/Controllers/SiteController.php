<?php

namespace App\Http\Controllers;

use App\Article;
use App\Expected_tank_values;
use App\Tank;
use Illuminate\Http\Request;

class SiteController extends Controller
{

    public function index(){

        $articles = Article::all();

        return view('welcome', compact('articles'));
    }

    public function analiz(Request $request){
//        dd($request->all());
        $user_account_info = $this->parse_curl('https://api.worldoftanks.ru/wot/account/info/?application_id=df13c5fa140af811b023333b08201ab5&amp;account_id='.$request->account_id);
        $user_random_stat = $user_account_info['data'][$request->account_id]['statistics']['all'];

        $user_tanks_stats = $this->parse_curl('https://api.worldoftanks.ru/wot/tanks/stats/?application_id=df13c5fa140af811b023333b08201ab5&amp;account_id='.$request->account_id.'&fields=-clan,-stronghold_skirmish,-regular_team,-company,-stronghold_defense,-team,-globalmap');
        $user_tanks_stats = $user_tanks_stats['data'][$request->account_id];


//        $exp_tank_values = Expected_tank_values::all();


        $WN8_all = 0;
        $tanks = array();
        foreach ($user_tanks_stats as $tank_stat){
            $battles = $tank_stat['all']['battles'];
            $avg_dam = $tank_stat['all']['damage_dealt']/$battles;
            $avg_def = ($tank_stat['all']['capture_points']/$battles);
            $avg_frags = ($tank_stat['all']['frags']/$battles);
            $avg_win = ($tank_stat['all']['wins']/$battles)*100;
            $avg_spot = ($tank_stat['all']['spotted']/$battles);
            $PP = ($battles/$user_random_stat['battles']);

            $tank = Tank::find($tank_stat['tank_id']);
            $exp_tank_values = $tank->expected_tank_values;

            $rDamage = ($avg_dam/$exp_tank_values['expDamage']);
            $rSpot = ($avg_spot/$exp_tank_values['expSpot']);
            $rFrag = ($avg_frags/$exp_tank_values['expFrag']);
            $rDef = ($avg_def/$exp_tank_values['expDef']);
            $rWIN = ($avg_win/$exp_tank_values['expWinRate']);

            $rWINc = max(0, (($rWIN-0.71)/(1-0.71)));
            $rDamagec = max(0, ($rDamage-0.22)/(1-0.22));
            $rFragc = min($rDamagec+0.2, max(0, ($rFrag-0.12)/(1-0.12)));
            $rSpotc = min($rDamagec+0.1, max(0, ($rSpot-0.38)/(1-0.38)));
            $rDefc = min($rDamagec+0.1, max(0, ($rDef-0.1)/(1-0.1)));

            $WN8=980*$rDamagec+210*$rDamagec*$rFragc+155*$rFragc*$rSpotc+75*$rDefc*$rFragc+145*min(1.8, $rWINc);
            $WN8_all += $WN8*$PP;

            $array = ['name' => $exp_tank_values['name'], 'battles' => $battles, 'damage' => $avg_dam, 'frags' => $avg_frags, 'wn8' => $WN8, 'exp_dam' => $exp_tank_values['expDamage'], 'exp_frags' => $exp_tank_values['expFrag']];
            $tanks[] = $array;
        }

        return view('analiz', compact('tanks', 'WN8_all'));
    }

    public function refresh(){

        Tank::truncate();
        $table = Expected_tank_values::all();
        foreach ($table as $item){
            $item->delete();
        }


        $etw = $this->parse_curl('http://www.wnefficiency.net/exp/expected_tank_values_30.json');
        $name_t = $this->parse_curl('https://api.worldoftanks.ru/wot/encyclopedia/vehicles/?application_id=df13c5fa140af811b023333b08201ab5&fields=name,tank_id');
        $name_t = $name_t['data'];

//        dd($etw);

        foreach ($etw['data'] as $exp_tank_values){
            if (isset($name_t[$exp_tank_values['IDNum']]['name']))
                $exp_tank_values['name'] = $name_t[$exp_tank_values['IDNum']]['name'];
            Expected_tank_values::create($exp_tank_values);
        }

        $default = Expected_tank_values::first();
        $default = $default->IDNum;

        foreach ($name_t as $item){
            $item['exp_tank_id'] = Expected_tank_values::find($item['tank_id']) ? $item['tank_id'] : $default;
            Tank::create($item);
        }

        $exp_tank_values_without_names = Expected_tank_values::where('name', 'xxx_xxx')->get();

        foreach ($exp_tank_values_without_names as $tank){
            $same_tank = Expected_tank_values::where('expFrag', $tank->expFrag)
                                                ->where('expDamage', $tank->expDamage)
                                                ->where('expSpot', $tank->expSpot)
                                                ->where('expDef', $tank->expDef)
                                                ->where('expWinRate', $tank->expWinRate)->get();
            if(isset($same_tank[1]))
                $tank->name = $same_tank[1]->name;
            $tank->save();
        }


        return redirect()->back();
    }

    public function change_similar(Request $request){
        
        if($request->isMethod('post')){
            $tank = Tank::find($request->tank_id);
            $tank->exp_tank_id = $request->exp_tank_id;
            $tank->save();
            return redirect()->back();
        }

        $tanks_without_exp = Tank::whereRaw('tank_id <> exp_tank_id')->get();

        $exp_tanks = Expected_tank_values::all(['IDNum', 'name']);
        $tanks = array();
        foreach ($exp_tanks as $tank){
            $tanks[$tank->IDNum] = $tank->name;
        }

//        dd($tanks);

        return view('admin.change_similar', compact('tanks_without_exp', 'tanks'));
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
