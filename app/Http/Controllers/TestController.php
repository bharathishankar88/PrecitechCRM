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
        $data4 = [
            ['id' => '1', 'name' => '1:00'],
            ['id' => '2', 'name' => '1:30'],
            ['id' => '3', 'name' => '2:00'],
            ['id' => '4', 'name' => '2:30'],
            ['id' => '5', 'name' => '3:00'],
            ['id' => '6', 'name' => '3:30'],
            ['id' => '7', 'name' => '4:00'],
            ['id' => '8', 'name' => '4:30'],
            ['id' => '9', 'name' => '5:00'],
            ['id' => '10', 'name' => '5:30'],
            ['id' => '11', 'name' => '6:00'],
            ['id' => '12', 'name' => '6:30'],
            ['id' => '13', 'name' => '7:00'],
            ['id' => '14', 'name' => '7:30'],
            ['id' => '15', 'name' => '8:00'],
            ['id' => '16', 'name' => '8:30'],
            ['id' => '17', 'name' => '9:00'],
            ['id' => '18', 'name' => '9:30'],
            ['id' => '19', 'name' => '10:00'],
            ['id' => '20', 'name' => '10:30'],
            ['id' => '21', 'name' => '11:00'],
            ['id' => '22', 'name' => '11:30'],
            ['id' => '23', 'name' => '12:00'],
            ['id' => '24', 'name' => '12:30'],
            ['id' => '25', 'name' => '13:00'],
            ['id' => '26', 'name' => '13:30'],
            ['id' => '27', 'name' => '14:00'],
            ['id' => '28', 'name' => '14:30'],
            ['id' => '29', 'name' => '15:00'],
            ['id' => '30', 'name' => '15:30'],
            ['id' => '31', 'name' => '16:00'],
            ['id' => '32', 'name' => '16:30'],
            ['id' => '33', 'name' => '17:00'],
            ['id' => '34', 'name' => '17:30'],
            ['id' => '35', 'name' => '18:00'],
            ['id' => '36', 'name' => '18:30'],
            ['id' => '37', 'name' => '19:00'],
            ['id' => '38', 'name' => '19:30'],
            ['id' => '39', 'name' => '20:00'],
            ['id' => '40', 'name' => '20:30'],
            ['id' => '41', 'name' => '21:00'],
            ['id' => '42', 'name' => '21:30'],
            ['id' => '43', 'name' => '22:00'],
            ['id' => '44', 'name' => '22:30'],
            ['id' => '45', 'name' => '23:00'],
            ['id' => '46', 'name' => '23:30'],
            ['id' => '47', 'name' => '00:00'],

        ];
        //     >where('created_at' , '>=', '$fromdate ')
        //     ->where('created_at', '<=', $todate)
        //     ->where('username','like','%' .$name. '%')
            //->get();
        return view('form.form',compact('data','data1','data2','data3','data4'));
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
           // 'timeRange'=>'required|numeric',
            //'itemProduced'=>'required|numeric',      
            'timeslot1'    => 'required',
            'timeslot2'      => 'required',     
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
            $timeslot1 = $request->timeslot1;
            $timeslot2 = $request->timeslot2;
            $i = 0;
            foreach($itemProduced as $productCount){
            
            $t1 = strtotime($timeslot1[$i]);
            $t2 = strtotime($timeslot2[$i]);

            echo "inside save";
            echo $t1;
            $timerange = round(abs($t1 - $t2) / 60,2);
            $target = DB::select("SELECT targetperhr FROM products where id= '$product'");
            $targetpermin = 0;
            $productionpercent = 0.0;
            if($target != null){
                foreach($target as $value){
                $targetpermin = $value->targetperhr/60;
                $productionpercent= $itemProduced[$i]/($timerange*$targetpermin);
                }

            }

            $Production = new Production();
            $Production->oid = $operator;
            $Production->mid    = $machine;
            $Production->pid    = $product;
            $Production->time_range    = $timerange;
            $Production->time_slot    = $timeslot1[$i].'-'.$timeslot2[$i];
            $Production->prd_count = $itemProduced[$i];
            $Production->prd_percent = $productionpercent * 100;
            $Production->created_by = $createdBy;
            $Production->modified_by = $createdBy;
            $Production->created_at = $todate;
           


            echo $createdBy;

            $Production->save();
            $i=$i+1;
        }
            return redirect()->back()->with('insert','Data has been insert successfully!.');

        }catch(Exception $e){
            echo $e;
            return redirect()->back()->with('error','Data has been insert fail!.');
        }
    }
    // update
    public function update(Request $request)
    {

        $id = $request->id;
        $prdid = $request->prdid;
        $rejection = $request->rejection;
        $timerange = $request->timerange;
        $itemProduced = $request->itemproduced;

        $production = DB::select("SELECT * FROM productions where id= '$id'");
        if($production != null){
            foreach($production as $value){
            $prdid = $value->pid;
            
            }
        }
        $target = DB::select("SELECT targetperhr FROM products where id= '$prdid'");
            $targetpermin = 0;
            $productionpercent = 0.0;
            if($target != null){
                foreach($target as $value){
                $targetpermin = $value->targetperhr/60;
                
                }
            }
        $productionpercent= ($itemProduced-$rejection)/($timerange*$targetpermin);
        $update =[

            //'id'      =>$id,
            'rejection'=>$rejection,
            //'prdcount'   =>$timerange,
            'prdpercent' =>$productionpercent*100,
        ];
        Production::where('id',$request->id)->update($update);
        return redirect()->back()->with('insert','Data has been updated successfully!.');
    }

    // delete
    public function deleteProduction($id)
    {
        $delete = Production::find($id);
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
