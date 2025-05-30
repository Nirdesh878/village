@extends('layouts.app')

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item">Agency</li>
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Agency</h4>
                    </div>
                </div>
            </div>
            <div class="export_icon_css" style="margin-top: -32px;">
                <a href="{{ url('agencyExport') }}" id="export">
                    <img src="{{ asset('assets\images\excel.png') }}" data-toggle="tooltip" title="Excel Export" data-src="{{ asset('assets\images\excel.png') }}" srcset="https://image.flaticon.com/icons/png/512/732/732220.png 4x" alt="Excel Export" title="Excel" class="lzy lazyload--done" style="height: 35px;">
                </a>
            </div>
            <div class="export_pdf_css" style="margin-top: -32px;  !important;">
                <a href="{{ URL::to('/agencyPdf') }}">
                    <img src="{{ asset('assets\images\pdf.png') }}" data-toggle="tooltip" title="PDF Download" alt="PDF Download" title="PDF Download" class="lzy lazyload--done" style="height: 35px;">
                </a>
            </div>
            <div class="col-lg-4 text-right">
                    <a href="{{ url('agency/create') }}" class="btn cur-p btn-sm btn-success" >Create Agency
                    </a>
            </div>
        </div>
    </div>
    <!-- Page-header end -->

    <!-- Page-body start -->
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                        @include('common.error')
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                                <thead>
                                
                                    <tr >
                                    <th >S.No</th>
                                    <th >Partner</th>
                                    <th >Agency</th>
                                    <th >Country</th>
                                    <th >State</th>
                                    <th >District</th>
                                    <th >Created At</th>
                                    <th >Updated At</th>
                                    <th >Status</th>
                                    <th >Action</th>
                                </tr>
                                
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>

<script src="{{ asset('bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets\pages\data-table\js\jszip.min.js') }}"></script>
<script src="{{ asset('assets\pages\data-table\js\pdfmake.min.js') }}"></script>
<script src="{{ asset('assets\pages\data-table\js\vfs_fonts.js') }}"></script>
<script src="{{ asset('bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
<script src="{{ asset('bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
<script src="{{ asset('bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>
<script>
    $(function(){
        var table = $('#simpletable').DataTable({
        "processing":true,
        "serverSide": true, //Feature control DataTables' servermside processing mode.
        "bFilter" : true,
        "bLengthChange": false,
        "ordering"  : false,
        "iDisplayLength" : 10,
        "responsive"  :false,
        "ajax": {
        "url": '{{ route('agency.index') }}',
        "type": "GET",
        "dataType": "json",
        "data": function(data) {
            // manipulate data used in ajax request prior to server call
            delete data.columns;
        },
        "dataSrc": function (jsonData) {
        return jsonData.data;
      }
    },
    //Set column definition initialisation properties.
    "columnDefs": [
    {
        "targets": [ 0 ], //first column / numbering column
        "orderable": false, //set not orderable
      },
      ],

    });
        // dataTable();
    });
    function fn_delete(id)
    {
        bootbox.confirm({
            title: "",
            message: "Are you sure, you want to delete this Partner/Organization?",
            callback: function (result) {
                if(result)
                {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var url = '{{ route("agency.destroy", ":id") }}';
                    url = url.replace(':id', id);

                    $.ajax({

                        type: "POST",
                        data:{
                            _token: "{{ csrf_token() }}",
                            _method:"DELETE"
                        },
                        url: url,
                        dataType: 'JSON'

                    })
                    .done(function(response){
                         bootbox.alert({
                                    title: "Warning?",
                                    message: response.message,
                                    callback: function() {
                                        location.reload();
                                    }
                                });
                    })
                    .fail(function(response){
                        bootbox.alert({title: "Warning?",
                            message: 'Something Went Wrong..'});
                    })
                }
            }
        });
    }

</script>

@endsection
<!-- data-table js -->
