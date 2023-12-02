<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productions;
use Auth;
use DB;
use Cookie;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$writer=null;

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
        $operator = $request->operator;
        $machine = $request->machine;

        $query = "SELECT pr.id as id,o.name as oid,m.name as mid, pr.name as pid, time_range,prd_count,prd_percent,p.created_at as created_at FROM productions p, operators o, products pr,machines m where p.pid=pr.id and p.oid=o.id and p.mid=m.id  and  p.created_at BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' ";
        if($operator!=null)
        $query = $query. " and o.name like '%$operator%'";
        if($machine!=null)
        $query = $query. " and m.name like '%$machine%'";        

        $data = DB::select($query);        

       // $data = DB::table('productions')
             //->where('created_at' , '>=', $fromdate)
             //->where('created_at', '<=', $todate)
             //->where('username','like','%' .$name. '%')
           // ->get();
           
          Cookie::queue('fromdate',$fromdate,120);
          Cookie::queue('todate',$todate,120);
          Cookie::queue('operator',$operator,120);
          Cookie::queue('machine',$machine,120);

        return view('report.report',compact('data'));
    }

    public function exportData(Request $request){
        if(Auth::guest())
        {
            return redirect()->route('/');
        }

        $fromdate = Cookie::get('fromdate');
        $todate   = Cookie::get('todate');
        $operator = Cookie::get('operator');
        $machine = Cookie::get('machine');

        $query = "SELECT pr.id as id,o.name as oid,m.name as mid, pr.name as pid, time_range,prd_count,prd_percent,p.created_at as created_at FROM productions p, operators o, products pr,machines m where p.pid=pr.id and p.oid=o.id and p.mid=m.id  and  p.created_at BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' ";
        if($operator!=null)
        $query = $query. " and o.name like '%$operator%'";
        if($machine!=null)
        $query = $query. " and m.name like '%$machine%'";        

        $data = DB::select($query);        
        

                       // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();


        // Add data to the spreadsheet
        $sheet = $spreadsheet->getActiveSheet();
        $i=1;
        $sheet->setCellValue('A'.$i, 'Date');
        $sheet->setCellValue('B'.$i, 'ProductName');
        $sheet->setCellValue('C'.$i, 'Operator');
        $sheet->setCellValue('D'.$i, 'Machine');
        $sheet->setCellValue('E'.$i, 'Duration');
        $sheet->setCellValue('F'.$i, 'No.OfProduct');
        $sheet->setCellValue('G'.$i, 'Percentage');
        foreach($data as $value){
            $i++;
            $sheet->setCellValue('A'.$i, date('d-m-Y', strtotime($value->created_at)));
            $sheet->setCellValue('B'.$i, $value->pid);
            $sheet->setCellValue('C'.$i, $value->oid);
            $sheet->setCellValue('D'.$i, $value->mid);
            $sheet->setCellValue('E'.$i, $value->time_range);
            $sheet->setCellValue('F'.$i, $value->prd_count);
            $sheet->setCellValue('G'.$i, $value->prd_percent);
        }


        // Save the spreadsheet to a file
        $writer = new Xlsx($spreadsheet);


        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="example.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
