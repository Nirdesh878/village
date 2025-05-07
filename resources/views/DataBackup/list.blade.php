@extends('layouts.app')

@section('content')
@php $user = \Illuminate\Support\Facades\Auth::user(); @endphp

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
                        <li class="breadcrumb-item">DATA BACKUP</li>
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>DATA BACKUP</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>

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
                                <tr>
                                    <th width="5%">S.No</th>
                                    <th width="30%">Facilitator Name</th>
                                    <th width="30%">File Name</th>
                                    <th width="30%">Uploaded</th>
                                    <th width="5%">Download</th>
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
        "url": '{{ route('DataBackup.index') }}',
        "type": "GET",
        "dataType": "json",
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


</script>

@endsection
<!-- data-table js -->
