<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productions;
use Auth;
use DB;


class ReportController extends Controller
{
    // report
    public function report(Request $request)
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

        $fromdate = $request->fromdate;
        $todate   = $request->todate;
        $name     = $request->name;

        if($name!=null)
        $data = DB::select("SELECT pr.id as id,o.name as oid,m.name as mid, pr.name as pid, time_range,prd_count,prd_percent,u.first_name as created_by,u.first_name as modified_by,p.created_at,p.updated_at FROM productions p, operators o, products pr,machines m,users u where p.pid=pr.id and p.oid=o.id and p.mid=m.id and p.created_by=u.id and p.created_at BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' and o.name like '%$name%'");
        else
        $data = DB::select("SELECT pr.id as id,o.name as oid,m.name as mid, pr.name as pid, time_range,prd_count,prd_percent,u.first_name as created_by,u.first_name as modified_by,p.created_at,p.updated_at FROM productions p, operators o, products pr,machines m,users u where p.pid=pr.id and p.oid=o.id and p.mid=m.id and p.created_by=u.id and p.created_at BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59'");
        

       // $data = DB::table('productions')
             //->where('created_at' , '>=', $fromdate)
             //->where('created_at', '<=', $todate)
             //->where('username','like','%' .$name. '%')
           // ->get();
        return view('report.report',compact('data'));
    }
}
