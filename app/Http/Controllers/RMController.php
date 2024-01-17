<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Production;
use App\Models\Machine;
use App\Models\Rmins;
use App\Models\Rmouts;
use Auth;
use DB;

class RMController extends Controller
{
    
    public function viewDataIn()
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

        $data = Personal::all();
        $data1 = DB::select("SELECT * FROM suppliers");
        $data2 = DB::select("SELECT * FROM grades");
        $data3 = DB::select("SELECT * FROM products");
        $data4 = DB::select("SELECT A.id,B.name as supplierid,C.name as gradeid,size,quantity  FROM rmins A,suppliers B,grades C where A.supplierid=B.id and A.gradeid=C.id");
        
        return view('rm.formin',compact('data','data1','data2','data3','data4'));
    }
    // save
    public function viewDataInSave(Request $request)
    {
        echo "inside viewTestSave";
        $request->validate([
            'todate'=>'required',
            'supplier' =>'required',
            'grade' =>'required',
            'sizemm' =>'required',
            'qty' =>'required',
        ]);
    
        try{
            $todate = $request->todate;
            $supplierid = $request->supplier;
            $gradeid = $request->grade;
            $sizemm = $request->sizemm;
            $quantity = $request->qty;
            $createdBy = Auth::user()->id;

            $idindex = DB::select("select max(id)+1 as id from rmins");
            $id=0;
       
             if($idindex != null){
                foreach($idindex as $value){
                $id = $value->id;                
                }
             }else{
             $id=1;
             }

             if($id==null){
               $id=1;
             }

             
       //DB::insert('insert into rmins (name,id) values (?,?)', [$name,$id]); 
       DB::insert('INSERT INTO rmins (id,supplierid,gradeid,size,quantity,created_by,modified_by) VALUES (?,?,?,?,?,?,?)', [$id,$supplierid,$gradeid,$sizemm,$quantity,$createdBy,$createdBy]);
    
          

            return redirect()->back()->with('insert','Data has been insert successfully!.');

        }catch(Exception $e){
            echo $e;
            return redirect()->back()->with('error','Data has been insert fail!.');
        }
    }

    // Out 
    public function viewDataOut()
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

        $data = Personal::all();
        $data1 = DB::select("SELECT * FROM suppliers");
        $data2 = DB::select("SELECT * FROM grades");
        $data3 = DB::select("SELECT * FROM products");
        $data4 = DB::select("SELECT A.id,B.name as productid,C.name as gradeid,size,quantity FROM rmouts A,products B,grades C where A.productid=B.id and A.gradeid=C.id");
        
        return view('rm.formout',compact('data','data1','data2','data3','data4'));
    }
    // save
    public function viewDataOutSave(Request $request)
    {
        echo "inside viewTestSave";
        $request->validate([
            'todate'=>'required',
            'supplier' =>'required',
            'grade' =>'required',
            'size' =>'required',
            'qty' =>'required',
            'product' =>'required',
        ]);
    
        try{
            $todate = $request->todate;
            //$supplierid = $request->supplier;
            $gradeid = $request->grade;
            $sizemm = $request->size;
            $quantity = $request->qty;
            $product = $request->product;
            $createdBy = Auth::user()->id;

            $idindex = DB::select("select max(id)+1 as id from rmouts");
            $id=0;
       
             if($idindex != null){
                foreach($idindex as $value){
                $id = $value->id;                
                }
             }else{
             $id=1;
             }

             if($id==null){
               $id=1;
             }

             
       //DB::insert('insert into rmins (name,id) values (?,?)', [$name,$id]); 
       DB::insert('INSERT INTO rmouts (id,gradeid,size,quantity,productid,created_by,modified_by) VALUES (?,?,?,?,?,?,?)',[$id,$gradeid,$sizemm,$quantity,$product,$createdBy,$createdBy]);
    
          

       
            return redirect()->back()->with('insert','Data has been insert successfully!.');

        }catch(Exception $e){
            echo $e;
            return redirect()->back()->with('error','Data has been insert fail!.');
        }
    }

    //Report 
    public function viewDataReport()
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

       // $data = Personal::all();
        //$data1 = DB::select("SELECT * FROM suppliers");
        //$data2 = DB::select("SELECT * FROM grades");
        //$data = DB::select("SELECT sum(a.quantity) as qty,b.quantity as qty1,c.name as name,a.size as size FROM rmouts a, rmins b,products c,users d where a.gradeid=b.gradeid and a.size=b.size and a.productid=c.id and a.created_by=d.id group by a.size,b.quantity,c.name,a.size");
        $data = DB::select("SELECT sum(a.quantity) as qty,b.quantity as qty1,a.size as size FROM rmouts a, rmins b where a.gradeid=b.gradeid and a.size=b.size group by a.size,b.quantity,a.size");
        
        return view('rm.report',compact('data'));
    }
    // save
    public function viewDataReportSave(Request $request)
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
