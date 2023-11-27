<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    // home page
    public function index()
    {
        return view('home');
    }

    public function userChart(){
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

        $start = new Carbon('first day of this month');
        $fromdate = $start->startOfMonth();
        $end = new Carbon('last day of this month');
        $todate = $end->endOfMonth();
        
        //$users = DB::select("SELECT m.name ,sum(prd_percent) as prd_percent,MONTH(p.created_at) as created_at FROM productions p, operators o, products pr,machines m,users u where p.pid=pr.id and p.oid=o.id and p.mid=m.id and p.created_by=u.id group by created_at,m.name");
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

        $datasets = [
            [
                'label' => 'No.of items produced on Oct 23',
                'data' => $data,
                'backgroundColor' => $colors
            ]
            ];

            return view('home',compact('datasets','labels'));
    }
}
