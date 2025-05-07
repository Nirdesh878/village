@extends('layouts.app')

@section('content')

    <style type="text/css">
        .labelval,
        .label {
            color: black !important;
            font-size: 12px;
            font-weight: 700;
        }

        .mytable {
            border: 1px solid #EFF3F9;
        }

    </style>
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
                            <li class="breadcrumb-item">Group Creation</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Group Creation</h4>
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

                            <form class="container" method="POST" action="{{ url('store_csv') }}">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12 mb-3 ">
                                        <button class="btn btn-success Export" id="export" type="button">Export
                                            Template</button>
                                        <button class="btn btn-success import" id="import" data-toggle="modal"
                                            data-target="#import_modal" style="width: 150px; ;" type="button">Import
                                            Data</button>
                                        <button class="btn btn-success" style="width:120px;" id="save"
                                            type="submit">Save</button>

                                    </div>

                                    <br>


                                    <table id="import_data" class="table  table-responsive table-bordered" width="150%">


                                    </table>


                            </form>
                        </div>



                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="import_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title measure_title"> Select File</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form class="container" method="POST" enctype="multipart/form-data" id="myfrm">
                            @csrf
                            <div class="col-md-12">

                                <input type="file" class="form-control" name="select_file" id="upload_file" required>
                                <small id="fileHelp" class="form-text text-muted">Please upload a valid .XLS/CSV
                                    file.</small>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 mb-3 text-center">
                                    <button id="import_excel" class="btn btn-success" type="button">Import</button>
                                    <button class="btn btn-success" type="button" data-dismiss="modal" aria-label="Close"
                                        id="pop_up_close">Close</button>
                                </div>
                            </div>
                            <br>
                        </form>
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
        // import function
        $('#import_excel').on('click', function(e) {

            let myfrm = document.getElementById('myfrm');
            var file_data = $('#upload_file').prop('files')[0];
            // alert(JSON.stringify(file_data));

            var form_data = new FormData(myfrm);
            form_data.append('file', myfrm);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/import_excel",
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                cache: false,
                success: function(data) {
                    console.log(data);
                    if (data != '') {
                        $('#save').prop('disabled', false);
                        var returned = JSON.parse(data);

                        $('#import_data').html('');

                        $('#import_data').append(`<thead class="back-color "  >
                                <tr >
                                        <th colspan="7"></th>
                                        <th colspan="2" style="text-align:center;">Federation</th>
                                        <th colspan="2" style="text-align:center;">Cluster</th>
                                        <th colspan="2" style="text-align:center;">SHG</th>
                                        <th colspan="2" style="text-align:center;">Family</th>
                                </tr>

                                    <tr>
                                        <th >Partner </th>
                                        <th >Agency </th>
                                        <th >Country</th>
                                        <th >State</th>
                                        <th >District</th>
                                        <th >Block</th>
                                        <th >Village</th>
                                        <th >Federation </th>
                                        <th >SRLM</th>
                                        <th >Cluster </th>
                                        <th >SRLM</th>
                                        <th >SHG</th>
                                        <th >SRLM </th>
                                        <th >Family </th>
                                        <th >SRLM</th>

                                    </tr>
                                </thead>`);
                        for (var i = 1; i < returned[0].length; i++) {


                            $('#import_data').append(
                                `<tbody>
                                    <tr>
                                        <td><input type="text" style="width:150px;" class="form-control partner " autocomplete="off" name="partner_name[` +
                                i + `] " value= "` + returned[0][i][0] +
                                `" required>
                                        </td>
                                        <td><input type="text" style="width:150px;" class="form-control agency  " autocomplete="off" name="agency_name[` + i +
                                `]" value= "` + returned[0][i][1] +
                                `" >
                                        </td>
                                        <td><input type="text" style="width:150px;" class="form-control country_name value " autocomplete="off" name="country_name[` +
                                i + `]" value="` + returned[0][i][2] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control state_name value " autocomplete="off" name="state_name[` +
                                i + `]" value="` + returned[0][i][3] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control district_name value" autocomplete="off" name="district_name[` +
                                i + `]" value="` + returned[0][i][4] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control block_name value" autocomplete="off" name="block_name[` +
                                i + `]" value="` + returned[0][i][5] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control village_name value" autocomplete="off" name="village_name[` +
                                i + `]" value="` + returned[0][i][6] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control fed_name value" autocomplete="off" name="fed_name[` +
                                i + `]" value="` + returned[0][i][7] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control fed_srlm value" autocomplete="off" name="fed_srlm[` +
                                i + `]" value="` + returned[0][i][8] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control clus_name value" autocomplete="off" name="clus_name[` +
                                i + `]" value="` + returned[0][i][9] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control clus_srlm value" autocomplete="off" name="clus_srlm[` +
                                i + `]" value="` + returned[0][i][10] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control shg_name value" autocomplete="off" name="shg_name[` +
                                i + `]" value="` + returned[0][i][11] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control shg_srlm value" autocomplete="off" name="shg_srlm[` +
                                i + `]" value="` + returned[0][i][12] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control fm_name value" autocomplete="off" name="fm_name[` + i +
                                `]" value="` + returned[0][i][13] +
                                `" ></td>
                                        <td><input type="text" style="width:150px;" class="form-control fm_srlm value" autocomplete="off" name="fm_srlm[` +
                                i + `]" value="` + returned[0][i][14] + `" ></td>
                                    </tr>
                                </tbody>`);

                        }
                    }
                    $(".value").each(function(index) {
                        if ($(this).val().trim() == '') {
                            $(this).addClass('red_border');
                        }
                    });
                    $('#import_modal').modal('hide');
                    bootbox.alert({
                        title: "Success",
                        message: "Data Import Successfully"
                    });

                }
            });
        });
        $(document).ready(function() {
            // $('#import').prop('disabled', true);
            $('#save').prop('disabled', true);
        });
        $('#export').click(function() {
            $.ajax({
                xhrFields: {
                    responseType: 'blob',
                },
                type: 'GET',
                url: "/group_creation_export_template",
                success: function(result, status, xhr) {
                    //console.log(result);
                    var disposition = xhr.getResponseHeader('content-disposition');
                    var matches = /"([^"]*)"/.exec(disposition);
                    var filename = (matches != null && matches[1] ? matches[1] :
                        'GroupCreationTemplateExport.xlsx');

                    // The actual download
                    var blob = new Blob([result], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;

                    document.body.appendChild(link);

                    link.click();
                    document.body.removeChild(link);
                    // $('.div_import').show();
                    $('.import').removeClass('disabled').prop('disabled', false);
                }
            });
        });
    </script>



@endsection
<!-- data-table js -->
