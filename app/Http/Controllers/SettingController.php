<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\mysqli
use App\Models\Personal;
use App\Models\Production;
use App\Models\Machine;
use App\Models\Operator;
use App\Models\Product;
use App\Models\User;
use App\Models\Roles;

use Hash;
use Auth;
use DB;

class SettingController extends Controller
{
    
    public function viewOperator()
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }
    
        $data = DB::select("SELECT * FROM operators ");
        //$data1 = Roles::all();
        return view('settings.operatorsubmenu',compact('data'));
    }
    // save
    public function saveOperator(Request $request)
    {
        echo "inside viewTestSave";
        $request->validate([
            'opName'=>'required|string'      
            
        ]);
   
        try{
            $name = $request->opName;
            $idindex = DB::select("select max(id)+1 as id from operators");
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

           DB::insert('insert into Operators (name,id) values (?,?)', [$name,$id]);              

           $data = DB::select("SELECT * FROM operators ");

            return redirect()->back()->with('insert','Data has been insert successfully!.');
            return view('settings.operatorsubmenu',compact('data'));


       }catch(Exception $e){
            echo $e;
            return redirect()->back()->with('error','Data insert fail!.');
        }


    }
   
    // delete
    public function deleteOprator($id)
    {
        $delete = Operator::find($id);
        $delete->delete();
        return redirect()->back()->with('insert','Data has been deleted successfully!.');
    }

    //Submenu Machine

    public function viewMachine()
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }
    
        $data = DB::select("SELECT * FROM machines ");
        return view('settings.machinesubmenu',compact('data'));
    }
    // save
    public function saveMachine(Request $request)
    {
        echo "inside viewTestSave";
        $request->validate([
            'machineName'=>'required',
            'floorName'=>'required',   
            //'machine'   =>'required|email|unique:products',
            //'machine'   =>'required|min:11|numeric',
        ]);
    
        try{
            $name = $request->machineName;
            $floor = $request->floorName;

            $idindex = DB::select("select max(id)+1 as id from machines");
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

            DB::insert('insert into machines (id,name,floor) values (?,?,?)', [$idindex[0]->id,$name,$floor]);

            $data = DB::select("SELECT * FROM machines ");

            return redirect()->back()->with('insert','Data has been insert successfully!.');
            return view('settings.machinesubmenu',compact('data'));

       }catch(Exception $e){
            echo $e;
            return redirect()->back()->with('error','Data has been insert fail!.');
        }

    }
    // update
    public function updateMachine(Request $request)
    {
        $update =[

            'id'      =>$request->id,
            'name'    =>$request->name,
            
        ];
        Operator::where('id',$request->id)->update($update);
        return redirect()->back()->with('insert','Data has been updated successfully!.');
    }

    // delete
    public function deleteMachine($id)
    {
        $deleteMachine = Machine::find($id);
        $deleteMachine->delete();
        return redirect()->back()->with('insert','Data has been deleted successfully!.');
    }

    //Submenu Product

    public function viewProduct()
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }
    
        $data = DB::select("SELECT * FROM products ");
        return view('settings.productsubmenu',compact('data'));
    }
    // save
    public function saveProduct(Request $request)
    {
        echo "inside viewTestSave";
        $request->validate([
            'prodName'=>'required|string',
            'targetHour'=>'required',
        ]);
    
        try{
            $name = $request->prodName;
            $target = $request->targetHour;
            $idindex = DB::select("select max(id)+1 as id from products");
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

            DB::insert('insert into products (name,id,targetperhr) values (?,?,?)', [$name,$idindex[0]->id,$target]);

            $data = DB::select("SELECT * FROM products ");

            return redirect()->back()->with('insert','Data has been insert successfully!.');
            return view('settings.productsubmenu',compact('data'));

       }catch(Exception $e){
            echo $e;
            return redirect()->back()->with('error','Data has been insert fail!.');
        }

    }
    // update
    public function updateProduct(Request $request)
    {
        $update =[

            'id'      =>$request->id,
            'name'    =>$request->name,
            
        ];
        Product::where('id',$request->id)->update($update);
        return redirect()->back()->with('insert','Data has been updated successfully!.');
    }

    // delete
    public function deleteProduct($id)
    {
        $delete = Product::find($id);
        $delete->delete();
        return redirect()->back()->with('insert','Data has been deleted successfully!.');
    }

    // User Submenu

    public function viewUser()
    {
        if(Auth::guest())
        {
            return redirect()->route('/');
        }
    
        $data = DB::select("SELECT * FROM users");
        $data1 = Roles::all();
        return view('settings.usersubmenu',compact('data','data1'));
    }
    // save
    public function saveUser(Request $request)
    {
        echo "inside viewTestSave";
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8',
            'role' => 'required',
        ]);
    
        try{
            $fname = $request->firstName;
            $lname = $request->lastName;
            $role = $request->role;
            $mail = $request->email;
            $password = $request->password;

            User::create([
                'first_name'=> $fname,
                'last_name' => $lname,
                'role' =>     $role,
                'email'     => $mail,
                'password'  => Hash::make($password),
            ]);
    

            //$idindex = DB::select("select max(id)+1 as id from users");

            //DB::insert('insert into users (id,first_name,last_name,email,email_verified_at,password,remember_token,created_at,updated_at) values (?,?,?,?,?,?,?,?,?)', [$idindex[0]->id,$fname,$lname,$mail,NULL,$password,NULL,NULL,NULL]);

            //$data = DB::select("SELECT * FROM users ");

            return redirect()->back()->with('insert','Data has been insert successfully!.');
            return view('form.usersubmenu',compact('data'));

       }catch(Exception $e){
            echo $e;
            return redirect()->back()->with('error','Data has been insert fail!.');
        }

    }
    // update
    public function updateUser(Request $request)
    {
        $update =[

            'id'      =>$request->id,
            'name'    =>$request->name,
            
        ];
        Product::where('id',$request->id)->update($update);
        return redirect()->back()->with('insert','Data has been updated successfully!.');
    }

    // delete
    public function deleteUser($id)
    {
        $delete = User::find($id);
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
         return view('form.operatorsubmenu',compact('data'));
     }
    
}
