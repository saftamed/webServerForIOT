<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\Option;
use App\Models\Param;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function getItems($id)
    {
        $pp =Item::where('user_id', $id)->with("option")->get(['id','user_id','action','pin','value','position']);
        $pp= $pp->groupBy('position');
        return response()->json($pp);
    }
    public function setItems(Request $req)
    {


        foreach ($req["items"] as $key => $r) {
            //return $r['id'];
            if(!empty($r['id'])){
                $i = Item::find($r['id']);
                $i->user_id =  $r["user_id"];
                $i->action =  $r["action"];
                $i->pin =  $r["pin"];
               // $i->value =  $r["value"];
                $i->position =  $r["position"];
                //$item->update(['name' => 'Test']);
                $i->save();
                $op=$r["option"];
                 $o= $i->option;
                 $o->name = $op["name"];
                 $o->top = $op["top"];
                 $o->left =$op["left"];
                 $o->width = $op["width"];
                 $o->height = $op["height"];
                 $o->color = $op["color"];

                  $o->save();

            }else{
                 
             $op=$r["option"];
                $i = new Item;
                $i->user_id =  $r["user_id"];
                $i->action =  $r["action"];
                $i->pin =  $r["pin"];
                $i->value =  0;
                $i->position =  $r["position"];
                $i->save();

                $o = new Option;
                $o->item_id = $i->id;
                $o->name = $op["name"];
                $o->top = $op["top"];
                $o->left =$op["left"];
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
        
        $pp =Item::where('user_id', Auth::id())->with("option")->get(['id','user_id','action','pin','value','position']);
        $pp= $pp->groupBy('position');
        return response()->json($pp);

    }

    public function deleteItem(Request $req)
    {
        $i = Item::find($req['id']);
        $i->delete();
        $pp =Item::where('user_id', Auth::id())->with("option")->get(['id','user_id','action','pin','value','position']);
        $pp= $pp->groupBy('position');
        return response()->json($pp);

    }
    public function getEspItems($id)
    {
        //return '{"a":5}';
        $i =Param::where('code', $id)->take(1)->get(['user_id']);
        if(isset($i[0]["user_id"])){
            $i = $i[0]["user_id"];
        }else{
            $i="null";
            return $i;
        }
        $pp =Item::where('user_id', $i)->get(['id','action','pin','value']);
        return response()->json($pp);
    }
    public function updateItem(Request $req)
    {
        $i = Item::find($req['id']);
        $i->value = $req['value'];
       $a= $i->save();
        
        return response()->json($a);

    }
}
