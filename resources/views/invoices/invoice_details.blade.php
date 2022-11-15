@extends('layouts.master')
@section('title')
    بيانات الفاتورة
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">

                <div class="card-body">
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a>
                                    </li>
                                    <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                    <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab4">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped key-buttons text-md-nowrap"
                                            style="text-align:center">
                                            <tbody>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>

                                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                                    <th class="border-bottom-0">تاريخ الاصدار</th>
                                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                                    <th class="border-bottom-0">القسم</th>
                                                </tr>
                                                <tr>
                                                    <td>{{ $invoices->id }}</td>
                                                    <td>{{ $invoices->invoice_number }}</td>
                                                    <td>{{ $invoices->invoice_Date }}</td>
                                                    <td>{{ $invoices->due_date }}</td>
                                                    <td>{{ $invoices->section->section_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="border-bottom-0">المنتج</th>
                                                    <th class="border-bottom-0">مبلغ التحصيل</th>
                                                    <th class="border-bottom-0">مبلغ العمولة</th>
                                                    <th class="border-bottom-0" colspan="2">الخصم</th>
                                                </tr>
                                                <tr>
                                                    <td>{{ $invoices->product }}</td>
                                                    <td>{{ $invoices->amount_collection }}</td>
                                                    <td>{{ $invoices->amount_commission }}</td>
                                                    <td colspan="2">{{ $invoices->discount }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                                    <th class="border-bottom-0">الاجمالي مع الضريبة</th>
                                                    <th class="border-bottom-0" colspan="2">الحالة الحالية</th>
                                                </tr>
                                                <tr>
                                                    <td>{{ $invoices->rate_VAT }}</td>
                                                    <td>{{ $invoices->value_VAT }}</td>
                                                    <td>{{ $invoices->total }}</td>

                                                    @if ($invoices->value_status == 1)
                                                        <td colspan="2">
                                                            <span
                                                                class="badge badge-pill badge-success">{{ $invoices->status }}</span>
                                                        </td>
                                                    @elseif ($invoices->value_status == 2)
                                                        <td colspan="2">
                                                            <span
                                                                class="badge badge-pill badge-danger">{{ $invoices->status }}</span>
                                                        </td>
                                                    @else
                                                        <td colspan="2">
                                                            <span
                                                                class="badge badge-pill badge-warning">{{ $invoices->status }}</span>
                                                        </td>
                                                    @endif

                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab5">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped key-buttons text-md-nowrap"
                                            style="text-align:center">
                                            <tbody>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                                    <th class="border-bottom-0">المنتج</th>
                                                    <th class="border-bottom-0">القسم</th>
                                                    <th class="border-bottom-0">حالة الدفع</th>
                                                    <th class="border-bottom-0">تاريخ الدفع</th>
                                                    <th class="border-bottom-0">ملاحظات</th>
                                                    <th class="border-bottom-0">تاريخ الاضافة</th>
                                                    <th class="border-bottom-0">المستخدم</th>
                                                </tr>
                                                <tr>
                                                    @foreach ($details as $x)
                                                    @endforeach
                                                    <td>{{ $x->id_Invoice }}</td>
                                                    <td>{{ $x->invoice_number }}</td>
                                                    <td>{{ $x->product }}</td>
                                                    <td>{{ $invoices->section->section_name }}</td>
                                                    @if ($x->value_status == 1)
                                                        <td>
                                                            <span
                                                                class="badge badge-pill badge-success">{{ $invoices->status }}</span>
                                                        </td>
                                                    @elseif ($x->value_status == 2)
                                                        <td>
                                                            <span
                                                                class="badge badge-pill badge-danger">{{ $invoices->status }}</span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <span
                                                                class="badge badge-pill badge-warning">{{ $invoices->status }}</span>
                                                        </td>
                                                    @endif

                                                    <td>hi</td>
                                                    <td>{{ $x->note }}</td>
                                                    <td>{{ $x->created_at }}</td>
                                                    <td>{{ $x->user }}</td>

                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab6">

                                    {{-- attachement --}}
                                    <div class="card card-statistics">
                                        @can('اضافة مرفق')
                                        <div class="card-body">
                                            <p class="text-danger">صيغة المرفق  pdf , jpeg , jpg , png *</p>
                                            <h5 class="card-title">اضافة مرفقات</h5>
                                            <form action="{{ url('/invoiceAttachements') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="file_name" required>
                                                    <input type="hidden" id="customFile" name="invoice_number" value="{{ $invoices->invoice_number }}">
                                                    <input type="hidden" id="invoiceID" name="invoiceID" value="{{ $invoices->id }}">
                                                    <label class="custom-file-label" for="customFile">حدد المرفق</label>
                                                </div>
                                                <br><br>
                                                <button type="submit" class="btn btn-primary btn-md" name="uploadFile">تأكيد</button>
                                            </form>
                                        </div>
                                        @endcan
                                    </div>
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped key-buttons text-md-nowrap"
                                            style="text-align:center">
                                            <tbody>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">اسم الملف</th>
                                                    <th class="border-bottom-0">قام بالاضافة</th>
                                                    <th class="border-bottom-0">تاريخ الاضافة</th>
                                                    <th class="border-bottom-0">العمليات</th>
                                                </tr>
                                                
                                                    @foreach ($attachements as $attachement)
                                                    <tr>
                                                        <td>{{ $attachement->invoice_id }}</td>
                                                        <td>{{ $attachement->file_name }}</td>
                                                        <td>{{ $attachement->created_by }}</td>
                                                        <td>{{ $attachement->created_at }}</td>
                                                        <td colspan="2">
                                                            <a class="btn btn-outline-success btn-sm"
                                                                href="{{ url('view_file') }}/{{ $invoices->invoice_number }}/{{ $attachement->file_name }}"
                                                                role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                عرض</a>

                                                            <a class="btn btn-outline-info btn-sm"
                                                                href="{{ url('download_file') }}/{{ $invoices->invoice_number }}/{{ $attachement->file_name }}"
                                                                role="button"><i class="fas fa-download"></i>&nbsp;
                                                                تحميل</a>
                                                                @can('حذف المرفق')
                                                            <button class="btn btn-outline-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-file_name="{{ $attachement->file_name }}"
                                                                data-invoice_number="{{ $attachement->invoice_number }}"
                                                                data-id_file="{{ $attachement->id }}"
                                                                data-target="#delete_file">
                                                                <i class="fa fa-trash"></i>&nbsp;
                                                                حذف
                                                            </button>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!--/div-->

    </div>
    </div>
    <!-- row closed -->

    <!-- delete modal -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('delete_file')}}" method="post">

                    @csrf
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
