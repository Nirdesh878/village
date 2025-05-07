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
                            <li class="breadcrumb-item">Assign Task (Cluster)</li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Assign Task (Cluster)</h4>
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
                                <form class="container" method="POST" action="{{ url('store_cluster') }}" autocomplete="off">
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
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Federation<span class="red">*</span></label>
                                            <select class="form-control federation_id" name="federation_id" id="federation_id" required>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">Cluster<span class="red">* (Unassigned Cluster)</span></label>
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
            $('#agency_id').on('change', get_federation_list_task);
            $('#agency_id').on('change', get_cluster_list_task_cluster);
            $('#agency_id').on('change', get_facilitator_list);
        });

        function get_cluster_list_task_cluster() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_cluster_list_task_cluster',
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

        function get_federation_list_task() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id != '') {
                $.ajax({
                    type: 'GET',
                    url: '/get_federation_list_task',
                    data: '_token = <?php echo csrf_token() ?>&agency_id=' + agency_id,
                    success: function (data) {
                        if (data != '') {
                            $('#federation_id').html(data);
                            $('#federation_id').trigger("change");
                        }
                    }
                });
            }
        }
    </script>
@endsection
