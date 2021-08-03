<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Option;
use App\Models\Param;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;

class ItemController extends Controller
{
    public function getItems($id)
    {

        $pp = Item::where('user_id', $id)->with("option")->get(['id', 'user_id', 'action', 'pin', 'value', 'position', 'o']);
        $pp = $pp->groupBy('position');
        return response()->json($pp);
    }
    public function setItems(Request $req)
    {


        foreach ($req["items"] as $key => $r) {
            //return $r['id'];
            if (!empty($r['id'])) {
                $i = Item::find($r['id']);
                $i->user_id =  $r["user_id"];
                $i->action =  $r["action"];
                $i->pin =  $r["pin"];
                $i->o =  $r["o"];
                $i->position =  $r["position"];
                //$item->update(['name' => 'Test']);
                $i->save();
                $op = $r["option"];
                $o = $i->option;
                $o->name = $op["name"];
                $o->top = $op["top"];
                $o->left = $op["left"];
                $o->width = $op["width"];
                $o->height = $op["height"];
                $o->color = $op["color"];

                $o->save();
            } else {

                $op = $r["option"];
                $i = new Item;
                $i->user_id =  $r["user_id"];
                $i->action =  $r["action"];
                $i->pin =  $r["pin"];
                $i->o =  isset($r["o"]) ? $r["o"] : "0";
                $i->value =  0;
                $i->position =  $r["position"];
                $i->save();

                $o = new Option;
                $o->item_id = $i->id;
                $o->name = $op["name"];
                $o->top = $op["top"];
                $o->left = $op["left"];
                $o->width = $op["width"];
                $o->height = $op["height"];
                $o->color = $op["color"];
                $o->save();
            }
        }

        $param = Param::find($req["params"]["id"]);
        $param->left = $req["params"]["left"];
        $param->right = $req["params"]["right"];
        $param->center = $req["params"]["center"];
        $param->save();

        $pp = Item::where('user_id', Auth::id())->with("option")->get(['id', 'user_id', 'action', 'pin', 'value', 'position', 'o']);
        $pp = $pp->groupBy('position');
        return response()->json($pp);
    }
    public function setting(Request $req)
    {
        $param = Param::find($req["id"]);
        $param->debug = $req["debug"];
        $param->host = $req["host"];
        $param->dark = $req["dark"];
        $param->save();
    }
    public function deleteItem(Request $req)
    {
        $i = Item::find($req['id']);
        $i->delete();
        $pp = Item::where('user_id', Auth::id())->with("option")->get(['id', 'user_id', 'action', 'pin', 'value', 'position', 'o']);
        $pp = $pp->groupBy('position');
        return response()->json($pp);
    }
    public function getEspItems($id)
    {
        date_default_timezone_set('Europe/London');
        // $time = date("Y-m-d H:i:s", time()); 
        $mytime = Carbon::now();
        $date = "{\"action\":\"R\",\"T\":\"" . $mytime->dayOfWeek . $mytime->format(',d,m,y,H,i') . ",\"}";
        //return $time;
        //return '{"a":5}';
        $i = Param::where('code', $id)->take(1)->get(['user_id', 'debug', 'host']);
        if (isset($i[0]["user_id"])) {
            $ii = $i[0]["user_id"];
        } else {
            $ii = "null";
            return $i;
        }
        $pr = "{\"action\":\"Z\",\"debug\":" . $i[0]["debug"] . ",\"host\":\"" . $i[0]["host"] . "\"}";
        $pp = Item::where('user_id', $ii)->get(['id', 'action', 'pin', 'value', 'o']);
        $pp[] = json_decode($date);
        $pp[] = json_decode($pr);
        return response()->json($pp);
    }
    public function updateItem(Request $req)
    {
        $i = Item::find($req['id']);
        $i->value = $req['value'];
        $a = $i->save();

        return response()->json($a);
    }
}
