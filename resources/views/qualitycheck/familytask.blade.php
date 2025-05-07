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
                            <li class="breadcrumb-item">Assign Task (Family)</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Assign Task (Family)</h4>
                        </div>
                    </div>
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
                            <div class="mT-30">
                                <form class="container" method="POST" action="{{ route('preanalytics.store') }}" autocomplete="off">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Agency<span class="red">*</span></label>
                                            <select class="form-control agency_id" name="agency_id" id="agency_id" required>
                                                <option value="">--Select--</option>
                                                @foreach($agency as $row)
                                                    <option value="{{ $row->agency_id }}">{{ $row->agency_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Assign Type<span class="red">*</span></label>
                                            <select class="form-control task" name="task" id="task" required>
                                                <option value="">--Select--</option>
                                                <option value="A">Analysis</option>
                                                <option value="R">Rating</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" id="task_show">
                                        <div class="col-md-6 mb-3">
                                            <select class="form-control task_a1" name="task_a1" id="task_a1">
                                                <option value="">--Select--</option>
                                                <option value="P1">Part-1</option>
                                                <option value="P2">Part-2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">SHG<span class="red">*</span></label>
                                            <select class="form-control shg_uin" name="shg_uin" id="shg_uin" required>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Family<span class="red">* (Unassigned Family)</span></label>
                                            <select class="js-example-basic-multiple form-control" name="assignment_id[]" id="assignment_id" multiple="multiple" required>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Facilitator<span class="red">*</span></label>
                                            <select class="form-control user_id" name="user_id" id="user_id" required>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Remarks</label>
                                            <input type="text" class="form-control" name="remark"  value="{{ old('remark') }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button>
                                            <a href="{{ url('preanalytics') }}" class="btn btn-sm btn-danger">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-body end -->
    </div>
    <script>
        $(document).ready(function () {
            $('#agency_id').on('change', get_shg_list_task);
            $('#agency_id').on('change', get_facilitator_list);
            $('#agency_id').on('change', get_family_list_task);
        });

        $('#task').change(function () {
                var status = $(this).val();
                if (status == 'A') {
                    $('#task_show').show();
                } else if (status == 'R') {
                    $('#task_show').hide();
                }
            });
        function get_shg_list_task() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_shg_list_task',
                    data: '_token = <?php echo csrf_token() ?>&agency_id=' + agency_id,
                    success: function (data) {
                        if (data != '') {
                            $('#shg_uin').html(data);
                            $('#shg_uin').trigger("change");
                        }
                    }
                });
            }
        }

        function get_facilitator_list() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_facilitator_list',
                    data: '_token = <?php echo csrf_token() ?>&agency_id=' + agency_id,
                    success: function (data) {
                        if (data != '') {
                            $('#user_id').html(data);
                            $('#user_id').trigger("change");
                        }
                    }
                });
            }
        }

        function get_family_list_task() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_family_list_task',
                    data: '_token = <?php echo csrf_token() ?>&agency_id=' + agency_id,
                    success: function (data) {
                        if (data != '') {
                            $('#assignment_id').html(data);
                            $('#assignment_id').trigger("change");
                        }
                    }
                });
            }
        }

    </script>
@endsection
