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
                        <li class="breadcrumb-item">Cluster Report</li>
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Cluster Report</h4>
                    </div>
                </div>
            </div>
    </div>
    <!-- Page-header end -->


    <!-- Page-body start -->
    <div class="page-body">
        <div class="row pb-4 mt-2">
            <!-- task, page, download counter  start -->
            <div class="col-sm">
                <div class="w-box1 s-box">
                    <div class="d-flex">
                        <div class="count"><h4>Total Family</h4><h3>{{getCount('family_mst')}}</h3></div>

                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="w-box2 s-box">
                    <div class="d-flex">
                        <div class="count"><h4>Total SHG</h4><h3>{{getCount('shg_mst')}}</h3></div>

                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="w-box3 s-box">
                    <div class="d-flex">
                        <div class="count"><h4>Total Cluster</h4><h3>{{getCount('cluster_mst')}}</h3></div>

                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="w-box4 s-box">
                    <div class="d-flex">
                        <div class="count"><h4>Total Federation</h4><h3>{{getCount('federation_mst')}}</h3></div>

                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                        @include('common.error')
                        <table id="simpletable" class="table table-striped table-bordered nowrap" style="width: 100% !important;">
                                <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th width="10%">Analytics/Initial Rating done by</th>
                                    <th width="15%">Cluster Name</th>
                                    <th width="15%">Federation Name</th>
                                    <th width="10%">Country</th>
                                    <th width="10%">State</th>
                                    <th width="10%">District</th>
                                    <th width="10%">Observations by field faciliators</th>
                                    <th width="10%">Initial Rating Results </th>
                                    <th width="10%">Verfieid by Cluster/Federation </th>
                                    <th width="15%">Verfieid & Locked By DART/ViV staff  </th>
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
        "url": '{{ route('fedreports.index') }}',
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
    function fn_delete(id)
    {
        bootbox.confirm({
            title: "",
            message: "Are you sure, you want to delete this Federation?",
            callback: function (result) {
                if(result)
                {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var url = '{{ route("federation.destroy", ":id") }}';
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
                        bootbox.alert({title: "Deleted?", message: response.message});
                        location.reload();
                    })
                    .fail(function(response){
                        bootbox.alert({title: "Deleted?",
                            message: 'Something Went Wrong..'});
                    })
                }
            }
        });
    }

</script>

@endsection
<!-- data-table js -->
