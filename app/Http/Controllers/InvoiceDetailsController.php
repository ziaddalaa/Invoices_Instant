<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachements;
use App\Models\invoice_details;
use App\Models\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $invoices = invoices::where('id',$id)->first();
        $details = invoice_details::where('id_Invoice',$id)->get();
        $attachements = invoice_attachements::where('invoice_id',$id)->get();
        return view('invoices.invoice_details', compact('invoices', 'details' , 'attachements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_details $invoice_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_details $invoice_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_details $invoice_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice = invoice_attachements::findOrFail($request->id_file);
        $invoice->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
        // echo 'hi';
    }

    public function view_attachement($invoice_number,$file_name)
    {
        $x ="Attachments";
        $pathToFile = public_path($x.'/'.$invoice_number.'/'.$file_name);
        return response()->file($pathToFile);
    }

    public function download_attachement($invoice_number,$file_name)
    {
        $x ="Attachments";
        $pathToFile = public_path($x.'/'.$invoice_number.'/'.$file_name);
        return response()->download($pathToFile);
    }
}
