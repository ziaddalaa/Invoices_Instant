<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;

class CustomerReportsController extends Controller
{
    public function index()
    {
        $sections = sections::all();
        return view('reports.customer_reports', compact('sections'));
    }

    public function search_customers(Request $request)
    {
        if ($request->section && $request->start_at == '' && $request->end_at == '') {
            $invoices = invoices::select('*')->where('section_id', $request->section)->where('product', $request->product)->get();
            $sections = sections::all();
            return view('reports.customer_reports', compact('sections'))->withDetails($invoices);
        } else {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = invoices::whereBetween('invoice_Date', [$start_at, $end_at])->where('section_id', $request->section)->where('product', $request->product)->get();
            $sections = sections::all();
            return view('reports.customer_reports', compact('sections'))->withDetails($invoices);
        }
    }
}
