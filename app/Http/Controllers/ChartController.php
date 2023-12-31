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
        $machine   = $request->machine;
        $product   = $request->product;

        $query="SELECT m.name ,avg(prd_percent) as prd_percent FROM productions p, machines m,products pr where p.mid=m.id and p.pid=pr.id and p.created_at BETWEEN '$fromdate 00:00:00'AND '$todate 23:59:59'";

        //if($machine!=null)
        //$users = DB::select("SELECT m.name ,avg(prd_percent) as prd_percent FROM productions p, machines m where p.mid=m.id and p.created_at BETWEEN '$fromdate 00:00:00'AND '$todate 23:59:59' and m.name like '%$machine%' group by m.name");
        //else $users = DB::select("SELECT m.name ,avg(prd_percent) as prd_percent FROM productions p, machines m where p.mid=m.id and p.created_at BETWEEN '$fromdate 00:00:00'AND '$todate 23:59:59' group by m.name");

        if($product!=null)
        $query = $query. " and pr.name like '%$product%'";
        if($machine!=null)
        $query = $query. " and m.name like '%$machine%'"; 
        
        $query = $query. " group by m.name"; 

        $users = DB::select($query);


        $labels = [];
        $data = [];
        $colors = ['#FF0000','#00FFFF','#0000FF','#808080','#FFA500','#FFBF00','#FF7F50','#DE3163','#9FE2BF','#40E0D0','#CCCCFF'];

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
                'label' => 'percentage',
                'data' => $data,
                'backgroundColor' => $colors
            ]
            ];

            return view('home',compact('datasets','labels','fromdate','todate'));
    }
}
