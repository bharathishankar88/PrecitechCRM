<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Production;
use App\Models\Machine;
use Auth;
use DB;

class TestController extends Controller
{
    //
    public function viewTest()
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

        $data = Personal::all();
        $data1 = Machine::all();
        $data2 = DB::select("SELECT * FROM operators");
        $data3 = DB::select("SELECT * FROM products");
        //     >where('created_at' , '>=', '$fromdate ')
        //     ->where('created_at', '<=', $todate)
        //     ->where('username','like','%' .$name. '%')
            //->get();
        return view('form.form',compact('data','data1','data2','data3'));
    }
    // save
    public function viewTestSave(Request $request)
    {
        echo "inside viewTestSave";
        $request->validate([
            'todate'=>'required',
            'operator'=>'required',
            'product'=>'required',
            'machine'=>'required',
            'timeRange'=>'required|numeric',
            'itemProduced'=>'required|numeric',           
            //'machine'   =>'required|email|unique:products',
            //'machine'   =>'required|min:11|numeric',
        ]);
    
        try{
            $todate = $request->todate;
            $operator = $request->operator;
            $product    = $request->product;
            $machine    = $request->machine;
            $timerange  = $request->timeRange;
            $itemProduced = $request->itemProduced;
            $createdBy = Auth::user()->id;
            echo "inside save";

            $target = DB::select("SELECT targetperhr FROM products where id= '$product'");
            $targetpermin = 0;
            $productionpercent = 0.0;
            if($target != null){
                foreach($target as $value){
                $targetpermin = $value->targetperhr/60;
                $productionpercent= $itemProduced/($timerange*$targetpermin);
                }

            }

            $Production = new Production();
            $Production->oid = $operator;
            $Production->mid    = $machine;
            $Production->pid    = $product;
            $Production->time_range    = $timerange;
            $Production->prd_count = $itemProduced;
            $Production->prd_percent = $productionpercent * 100;
            $Production->created_by = $createdBy;
            $Production->modified_by = $createdBy;
            $Production->created_at = $todate;
           


            echo $createdBy;

            $Production->save();
            return redirect()->back()->with('insert','Data has been insert successfully!.');

        }catch(Exception $e){
            echo $e;
            return redirect()->back()->with('error','Data has been insert fail!.');
        }
    }
    // update
    public function update(Request $request)
    {
        $update =[

            'id'      =>$request->id,
            'username'=>$request->name,
            'email'   =>$request->email,
            'phone'   =>$request->phone,
        ];
        Personal::where('id',$request->id)->update($update);
        return redirect()->back()->with('insert','Data has been updated successfully!.');
    }

    // delete
    public function delete($id)
    {
        $delete = Personal::find($id);
        $delete->delete();
        return redirect()->back()->with('insert','Data has been deleted successfully!.');
    }

     // report
     public function getAllMachine()
     {
         if(Auth::guest())
         {
             return redirect()->route('/');
         }
 
         $fromdate = $request->fromdate;
         $todate   = $request->todate;
         $name     = $request->name;
 
 
         // $data = \DB::select("SELECT * FROM personals WHERE created_at BETWEEN '$fromdate 00:00:00'AND'$todate 23:59:59'");
 
         $data = DB::table('machine')
         //     >where('created_at' , '>=', '$fromdate ')
         //     ->where('created_at', '<=', $todate)
         //     ->where('username','like','%' .$name. '%')
             ->get();
         return view('form.form',compact('data'));
     }
    
}
