<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        // $this->validate($request, [
        //     'file_name' => 'mimes::pdf,jpeg,jpg,png',
        // ],[
        //     'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        // ]);

        $file = $request->file('file_name');
        $fileName = $file->getClientOriginalName();

        invoice_attachements::create([
            'file_name' => $fileName,
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $request->invoiceID,
            'created_by' => Auth()->user()->name,

        ]);
        // $attachement = new invoice_attachements();
        // $attachement->file_name = $fileName;
        // $attachement->invoice_number = $request->invoice_number;
        // $attachement->invoice_id = $request->invoiceID;
        // $attachement->created_by = Auth()->user()->name;
        // $attachement);
        // dd($attachement->save());
        //move file
        // $name = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'.$request->invoice_number),$fileName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_attachements  $invoice_attachements
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_attachements $invoice_attachements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_attachements  $invoice_attachements
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_attachements $invoice_attachements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_attachements  $invoice_attachements
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_attachements $invoice_attachements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_attachements  $invoice_attachements
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_attachements $invoice_attachements)
    {
        //
    }
}
