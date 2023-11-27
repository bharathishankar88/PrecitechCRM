<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class ChartController extends Controller
{      
    public function userChart1(Request $request){

       // $request->validate([
        //    'frmMonth'=>'required',           
        //]);
        /*$frommonth = $request->frmMonth;
        $now = Carbon::now();
        $yr = $now->year;
        $start = new Carbon('first day of '+ $frommonth +' '+$yr);
        $fromdate = $start->startOfMonth();
        $end = new Carbon('last day of '+ $frommonth +' '+$yr);
        $todate = $end->endOfMonth();*/

        $fromdate = $request->fromdate;
        $todate   = $request->todate;

        $users = DB::select("SELECT m.name ,sum(prd_percent) as prd_percent,MONTH(p.created_at) as created_at FROM productions p, machines m where p.mid=m.id and p.created_at BETWEEN '$fromdate 00:00:00'AND '$todate 23:59:59' group by created_at,m.name");

        $labels = [];
        $data = [];
        $colors = ['#FF0000','#00FFFF','#0000FF','#808080','#FFA500'];

        foreach($users as $user){
            $count = $user->prd_percent;
                    $machine=$user->name;
            array_push($labels,$machine);
        array_push($data,$count);
        }

        

       /* for($i=1; $i<=12; $i++){
            $month = date('F',mktime(0,0,0,$i,1));
            $count = 0;
            $machine="";

            foreach($users as $user){
                if($user->created_at == $i){
                    $count = $user->prd_percent;
                    $machine=$user->name;
                    break;
             }
            }

            array_push($labels,$machine);
            array_push($data,$count);
        }*/

        $datasets = [
            [
                'label' => 'No.of items produced on Nov 23',
                'data' => $data,
                'backgroundColor' => $colors
            ]
            ];

            return view('home',compact('datasets','labels'));
    }
}
