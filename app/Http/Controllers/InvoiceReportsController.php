<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class InvoiceReportsController extends Controller
{
    public function index()
    {
        return view('reports.invoice_reports');
    }

    public function search_invoices(Request $request)
    {
        $rdio = $request->rdio;

        if ($rdio == 1) 
        {
            if($request->type && $request->start_at == '' && $request->end_at == '')
            {   
                if($request->type == 'حدد نوع الفواتير')
                {
                    $invoices = invoices::select('*')->get();
                    return view('reports.invoice_reports', compact('invoices'))->withDetails($invoices);
                }
                else
                {
                $invoices = invoices::select('*')->where('status', $request->type)->get();
                $type = $request->type;
                return view('reports.invoice_reports', compact('type', 'invoices'))->withDetails($invoices);
            }
        }
            else
            {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('status',$type)->get();
                return view('reports.invoice_reports', compact('type','start_at','end_at' , 'invoices'))->withDetails($invoices);

            }
        }
        else
        {
            $invoices = invoices::select('*')->where('invoice_number', $request->invoice_number)->get();
            return view('reports.invoice_reports', compact('invoices'))->withDetails($invoices);
        }
    }
}
