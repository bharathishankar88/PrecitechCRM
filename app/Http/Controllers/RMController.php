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
        $data4 = DB::select("SELECT A.id,B.name as supplierid,C.name as gradeid,size,quantity,batch,attachment  FROM rmins A,suppliers B,grades C where A.supplierid=B.id and A.gradeid=C.id");
        $data5 = DB::select("SELECT * FROM sizes");

        return view('rm.formin',compact('data','data1','data2','data3','data4','data5'));
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
            'batch'=>'required|unique:rmins',
            'attachment' => 'nullable|mimes:pdf,zip',
        ]);
    
        try{
            $todate = $request->todate;
            $supplierid = $request->supplier;
            $gradeid = $request->grade;
            $sizemm = $request->sizemm;
            $quantity = $request->qty;
            $createdBy = Auth::user()->id;
            $batch = $request->batch;
            $cert = $request->cert;

            if($request->hasFile('cert')){
                $path = $request->cert->getRealPath();
                $logo = file_get_contents($path);
                $cert = base64_encode($logo);
                //$request->image->storeAs('images',$filename,'public');
            }

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
       DB::insert('INSERT INTO rmins (id,supplierid,gradeid,size,quantity,batch,attachment,created_by,modified_by) VALUES (?,?,?,?,?,?,?,?,?)', [$id,$supplierid,$gradeid,$sizemm,$quantity,$batch,$cert,$createdBy,$createdBy]);
    
          

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
        $data4 = DB::select("SELECT A.id,B.name as productid,C.name as gradeid,size,quantity,batch FROM rmouts A,products B,grades C where A.productid=B.id and A.gradeid=C.id");
        $data5 = DB::select("SELECT * FROM sizes");
        $data6 = DB::select("SELECT distinct batch FROM rmins where completed=0");

        return view('rm.formout',compact('data','data1','data2','data3','data4','data5','data6'));
    }
    // save
    public function viewDataOutSave(Request $request)
    {
        echo "inside viewTestSave";
        $request->validate([
            'todate'=>'required',
            'batch' =>'required',
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
            $batch = $request->batch;

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
       DB::insert('INSERT INTO rmouts (id,gradeid,size,quantity,productid,batch,created_by,modified_by) VALUES (?,?,?,?,?,?,?,?)',[$id,$gradeid,$sizemm,$quantity,$product,$batch,$createdBy,$createdBy]);
    
          

       
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

       $data1 = DB::select("SELECT batch,quantity FROM rmins");
       foreach($data1 as $dt1){
        $data2 = DB::select("SELECT sum(quantity) as quantity FROM rmouts where batch='".$dt1->batch."'");
        if($dt1->quantity==$data2[0]->quantity){
            DB::update('update rmins set completed = ? where batch=?', [1,$dt1->batch]);
            DB::update('update rmouts set completed = ? where batch=?', [1,$dt1->batch]);
 
        }
    }

    $data = DB::select("SELECT sum(quantity) as qty,group_concat(distinct batch) as batch,0 as qty1,size FROM rmouts where completed=0 group by size");
    //this is also valid
    for($i = 0; $i < sizeof($data); $i++){
   
        $data4 = DB::select("SELECT sum(quantity) as qty1 FROM rmins where batch in ('".str_replace(",", "','", $data[$i]->batch)."')");
     
        $data[$i]->qty1=$data4[0]->qty1;
        
        
        
    }
       // $data = DB::select("SELECT sum(a.quantity) as qty,b.quantity as qty1,a.size as size FROM rmouts a, rmins b where a.gradeid=b.gradeid and a.size=b.size group by a.size,b.quantity,a.size");
        
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

    public function downloadPdf($id)
    {
    // Retrieve the Blob data from the database
    //$document = Document::findOrFail($id);
    $document = DB::select("SELECT attachment FROM rmins where id='".$id."'");
    
    $file_contents = base64_decode($document[0]->attachment);

    return response($file_contents)
        ->header('Cache-Control', 'no-cache private')
        ->header('Content-Description', 'File Transfer')
        ->header('Content-Type', 'application/pdf')
        ->header('Content-length', strlen($file_contents))
        ->header('Content-Disposition', 'attachment; filename=certificate_file.pdf')
        ->header('Content-Transfer-Encoding', 'binary');
}
public function datainDelete($id)
    {
        $delete = Rmins::find($id);
        $delete->delete();
        return redirect()->back()->with('insert','Data has been deleted successfully!.');
    }

    public function dataoutDelete($id)
    {
        $delete = Rmouts::find($id);
        $delete->delete();
        return redirect()->back()->with('insert','Data has been deleted successfully!.');
    }
    
}
