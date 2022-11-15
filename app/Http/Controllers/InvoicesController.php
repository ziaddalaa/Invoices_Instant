<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachements;
use App\Models\invoice_details;
use App\Models\invoices;
use App\Models\products;
use App\Models\sections;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_VAT' => $request->Rate_VAT,
            'value_VAT' => $request->Value_VAT,
            'total' => $request->Total,
            'note' => $request->note,
            'status' => 'غير مدفوعة',
            'value_status' => 2
        ]);

        $invoice_id = invoices::latest()->first()->id;

        invoice_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {
            $invoice_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachements();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->created_by = Auth()->user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move file

            $image_name = $file_name;
            $request->pic->move(public_path('Attachments/' . $invoice_number), $image_name);


            // $user = User::first();
            // $user->notify(new AddInvoice($invoice_id));
            // Notification::send($user, new AddInvoice($invoice_id));

            session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
            return back();
        }
        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = invoices::where('id',$id)->first();
        return view('invoices.status_update', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoice = invoices::findOrFail($request->invoice_id);

        $invoice->update([
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'total' => $request->Total,
            'note' => $request->note,
        ]);

        $invoiceDetails = invoice_details::where('id_Invoice',$request->invoice_id)->first();
        $invoiceDetails->update([
            'product' => $request->product,
            'section' => $request->section,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id',$id)->first();

        $details = invoice_attachements::where('invoice_id', $id)->first();

         $id_page =$request->id_page;


        if (!$id_page==2) {

        if (!empty($details->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
        }

        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/invoices');

        }

        else {

            $invoices->Delete();
            session()->flash('archive_invoice');
            return redirect('/archive');
        }
    }

    public function getproducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function status_update($id, Request $request)
    {
        $invoice  = invoices::findOrFail($id);
        if($request->status === "مدفوعة")
        {
            $invoice->update([
                'value_status' => 1,
                'status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);

            invoice_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => Auth()->user()->name,
            ]);
        }
        else
        {
            $invoice->update([
                'value_status' => 3,
                'status' => $request->status,
                'payment_date' =>$request->payment_date,
            ]);

            invoice_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 3,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => Auth()->user()->name,
            ]);
        }

        session()->flash('status_update');
        return redirect('/invoices');
    }

    public function paid_invoices()
    {
        $invoices = invoices::where('value_status',1)->get();
        return view('invoices.paid_invoices',compact('invoices'));
    }

    public function unpaid_invoices()
    {
        $invoices = invoices::where('value_status',2)->get();
        return view('invoices.unpaid_invoices',compact('invoices'));
    }

    public function partial_invoices()
    {
        $invoices = invoices::where('value_status',3)->get();
        return view('invoices.partial_invoices',compact('invoices'));
    }

    public function print_invoice($id)
    {
        $invoice = invoices::where('id',$id)->first();
        return view('invoices.print_invoice',compact('invoice'));
    }
}
