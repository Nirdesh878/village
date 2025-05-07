<?php $__env->startSection('content'); ?>
    <?php $user = \Illuminate\Support\Facades\Auth::user(); ?>

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
                            <li class="breadcrumb-item">MAP</li>
                        </ul>
                    </div>
                    <?php $session_data = Session::get('family_session'); ?>

                    <div style="clear: both"></div>
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Family MAP</h4>
                        </div>
                        

                    </div>
                </div>


            </div>
        </div>
        <div class="card">
            <div class="card-block pt-2 pb-2">
                <div class="mT-30">

                    <form class="" method="post" action="<?php echo e(url('getLatLongFamily')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">

                            <div class="col-md-2 mb-3">
                                <label for="validationCustom02">Country</label>
                                <select class="form-control" name="country" id="country">
                                    <option value="">--Select--</option>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($row->id); ?>"
                                            <?php echo e(!empty(Session::get('family_session')['country']) && Session::get('family_session')['country'] == $row->id ? 'selected' : ''); ?>>
                                            <?php echo e($row->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationCustom02">State</label>
                                <select class="form-control" name="state" id="state">
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="validationCustom02">District</label>
                                <select class="form-control" name="district" id="district">
                                    <option value="">--Select--</option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="validationCustom02">Agency</label>
                                <select class="form-control agency_id" name="agency_id" id="agency_id">
                                    <option value="">--Select--</option>
                                    <?php $__currentLoopData = $agency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($row->agency_id); ?>"
                                            <?php echo e(!empty(Session::get('family_session')['agency_id']) && Session::get('family_session')['agency_id'] == $row->agency_id ? 'selected' : ''); ?>>
                                            <?php echo e($row->agency_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            

                            
                            <div class="col-md-2 mb-3">
                                <label for="validationCustom02">Facilitator</label>
                                <select class="form-control Fac_id" name="Fac_id" id="Fac_id">
                                    <option value="">--Select--</option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="validationCustom02">&nbsp;</label>
                                <input type="submit" class="btn btn-sm btn-success" name="filter" value="Search"
                                    style="float:left;margin-top: 2.5em;">
                                <button class="btn  btn-sm btn-danger" name="filter" value="clear"
                                    style="float: left;;margin-top:2.5em;margin-left: 10px;">Clear</button>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div id="map" class="map_landing"></div>

        <div class="card">
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <?php echo $__env->make('common.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <table id="simpletable" class="table table-striped table-bordered nowrap" style="width: auto">
                        <thead>
                            <tr>
                                <th width="2%">S.No</th>
                                <th width="5%">UIN</th>
                                <th width="10%">SHG Member Name</th>
                                <th width="10%">SHG</th>
                                <th width="10%">Cluster</th>
                                <th width="10%">Federation</th>
                                <th width="10%">Task Status</th>
                                <th width="8%">Created At</th>
                                <th width="8%">Last Update</th>
                                <th widyh="7%">Locked</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Page-body end -->
    </div>
    <style>
        .map_landing {
            width: 100%;
            height: 500px;
            position: relative;
            border: 10px solid #8080e6;
        }

        .geo-search button {
            background-color: #dddddd !important;
        }

        .marker-cluster {
            /* background-color: rgba(87, 131, 241, 0.6); */
            background-color: rgba(241, 128, 23, 0.6);
            /* Change the background color as desired */
            border-radius: 100%;
            /* Make it a circle */
            text-align: center;
            color: black;
            /* Text color */
            font-weight: bold;
            /* Bold text */
            line-height: 40px;
            opacity: 1;
            transform: translate3d(616px, 156px, 0px);
            z-index: 156;
            outline-style: none;
        }
    </style>
    <script type="text/javascript"
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD1wOf9ISBejnZhC-umNwWdaQbuSk3mMwg&sensor=false"></script>
    <script src="<?php echo e(asset('bower_components\datatables.net\js\jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('bower_components\datatables.net-buttons\js\dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets\pages\data-table\js\jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets\pages\data-table\js\pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets\pages\data-table\js\vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('bower_components\datatables.net-buttons\js\buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('bower_components\datatables.net-buttons\js\buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('bower_components\datatables.net-responsive\js\dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets\leaflet\leaflet.css')); ?>" />
    <script type="text/javascript" src="<?php echo e(asset('assets\leaflet\leaflet.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets\leaflet\indialayer.js')); ?>"></script>
    <script src="//unpkg.com/@sjaakp/leaflet-search/dist/leaflet-search.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/leaflet.markercluster.js"
        integrity="sha512-OFs3W4DIZ5ZkrDhBFtsCP6JXtMEDGmhl0QPlmWYBJay40TT1n3gt2Xuw8Pf/iezgW9CdabjkNChRqozl/YADmg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/MarkerCluster.Default.css"
        integrity="sha512-6ZCLMiYwTeli2rVh3XAPxy3YoR5fVxGdH/pz+KMCzRY2M65Emgkw00Yqmhh8qLGeYQ3LbVZGdmOX9KUjSKr0TA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        $(document).ready(function() {
            $('#country').on('change', get_state_list);
            $('#state').on('change', get_district_list);
            $('#country').trigger('change');
            // $('#agency_id').trigger('change');
            // $('#agency_id').on('change', get_family_list_id);
            $('#agency_id').on('change', get_fac_list_id);

            <?php echo !empty($session_data["country"]) && $session_data["country"]>0 ? "$('#country').val('".$session_data["country"]."');$('#country').trigger('change');" : "" ?>

            <?php echo !empty($session_data["agency_id"]) && $session_data["agency_id"]>0 ? "$('#agency_id').val('".$session_data["agency_id"]."');$('#agency_id').trigger('change');" : "" ?>

        });

        $(function() {
            var table = $('#simpletable').DataTable({
                "processing": true,
                "serverSide": true, //Feature control DataTables' servermside processing mode.
                "bFilter": true,
                "bLengthChange": false,
                "ordering": false,
                "iDisplayLength": 10,
                "responsive": false,
                "ajax": {
                    "url": '<?php echo e(url('mapDatatableFamily')); ?>',
                    "type": "GET",
                    "dataType": "json",
                    "data": function(data) {
                        // manipulate data used in ajax request prior to server call
                        delete data.columns;
                    },
                    "dataSrc": function(jsonData) {
                        return jsonData.data;
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [{
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                }, ],

            });
            // dataTable();
        });

        function get_state_list() {
            var obj = $(this);
            var country = obj.val();
            if (country > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_state',
                    data: '_token = <?php echo csrf_token(); ?>&country=' + country,

                    success: function(data) {
                        if (data != '') {
                            $('#state').html(data);
                            <?php echo !empty($session_data["state"]) && $session_data["state"]>0 ? "$('#state').val('".$session_data["state"]."');" : "" ?>
                            $('#state').trigger("change");

                        }
                    }
                });
            }
        }

        function get_district_list() {
            var obj = $(this);
            var state = obj.val();
            if (state > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_district',
                    data: '_token = <?php echo csrf_token(); ?>&state=' + state,

                    success: function(data) {
                        if (data != '') {
                            $('#district').html(data);
                            <?php echo !empty($session_data["district"]) && $session_data["district"]>0 ? "$('#district').val('".$session_data["district"]."');" : "" ?>
                            $('#district').trigger("change");
                        }
                    }
                });
            }
        }

        // function get_federation_list() {
        //     var obj = $(this);
        //     var agency_id = obj.val();
        //     if (agency_id > 0) {
        //         $.ajax({
        //             type: 'GET',
        //             url: '/get_federation_list_id',
        //             data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
        //             success: function(data) {
        //                 if (data != '') {
        //                     $('#federation_id').html(data);
        //                     <?php echo !empty($session_data["federation_id"]) && $session_data["federation_id"]>0 ? "$('#federation_id').val('".$session_data["federation_id"]."');" : "" ?>
        //                     $('#federation_id').trigger("change");
        //                 }
        //             }
        //         });
        //     }
        // }

        // function get_family_list_id() {
        //     var obj = $(this);
        //     var agency_id = obj.val();
        //     if (agency_id > 0) {
        //         $.ajax({
        //             type: 'GET',
        //             url: '/get_family_list_id',
        //             data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
        //             success: function(data) {
        //                 if (data != '') {
        //                     $('#Family_id').html(data);
        //                     <?php echo !empty($session_data["Family_id"]) && $session_data["Family_id"]>0 ? "$('#Family_id').val('".$session_data["Family_id"]."');" : "" ?>
        //                     $('#Family_id').trigger("change");
        //                 }
        //             }
        //         });
        //     }
        // }

        function get_fac_list_id() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_fac_list_id',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                    success: function(data) {
                        if (data != '') {
                            $('#Fac_id').html(data);
                            <?php echo !empty($session_data["Fac_id"]) && $session_data["Fac_id"]>0 ? "$('#Fac_id').val('".$session_data["Fac_id"]."');" : "" ?>
                            $('#Fac_id').trigger("change");
                        }
                    }
                });
            }
        }
    </script>
    <script>
        var get_data = null;
        $.ajax({
            url: "/getLatLongFamily",
            //the page containing php script
            type: "get", //request type,
            data: '_token = <?php echo csrf_token(); ?>',
            'async': false,
            success: function(result) {
                var parsedData = JSON.parse(result);
                console.log(parsedData);
                get_data = parsedData;
            }
        });


        var map = L.map('map', {
            minZoom: 4,
            maxZoom: 20
        }, {
            fullscreenControl: {
                pseudoFullscreen: false
            },
            zoomControl: false
        }).setView(new L.LatLng(19.25023195, 73.16017493), 4);
        var tiles = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
        var baseMaps = {
            "Hybrid": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }),
            "Satellite": L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }),
            "Terrain": L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            })
        }
        map.addControl(L.control.search());

        // var markers = new L.FeatureGroup();

        // var clusterIcon = L.icon({
        // 									iconUrl: 'http://127.0.0.1:8000/assets/icon/naturalcostal.png',
        // 								iconSize:     [46, 46], // size of the icon
        // 								iconAnchor:   [8, 16]
        //               });

        var markers = new L.MarkerClusterGroup({
            iconCreateFunction: function(cluster) {
                var childCount = cluster.getChildCount();


                return new L.DivIcon({
                    html: '<div><span>' + childCount + '</span></div>',
                    className: 'marker-cluster',
                    iconSize: new L.Point(40, 40)
                });
            }
        });

        var constant = $.map(get_data, function(e) {

            // if((e.id % 2) == 0){
            //   var greenIcon = L.icon({
            // 									iconUrl: 'http://127.0.0.1:8000/assets/icon/naturalcostal.png',
            // 								iconSize:     [46, 46], // size of the icon
            // 								iconAnchor:   [8, 16]
            //               });
            // }else{
            //   var greenIcon = L.icon({
            // 									iconUrl: 'http://127.0.0.1:8000/assets/icon/naturalinland.png',
            // 									iconSize:     [36, 36], // size of the icon
            // 								iconAnchor:   [8, 16]
            // 							});
            // }


            var redIcon = L.icon({
                iconUrl: 'https://icons.iconarchive.com/icons/paomedia/small-n-flat/256/map-marker-icon.png',
                iconSize: [24, 24], // size of the icon
                iconAnchor: [8, 16]
            });




            markers.addLayer(
                L.marker([e.latitude, e.longitude], {
                    icon: redIcon
                }).addTo(markers).bindPopup(
                    "<div class='popup_div'><div class='row'><table class='table table-striped'>" +
                    "<tr><td><b>Family</b></td><td>" + e.fp_member_name + "</td></tr>" +
                    "<tr><td><b>Latitude</b></td><td>" + e.latitude + "</td></tr>" +
                    "<tr><td><b>Longitude</b></td><td>" + e.longitude + "</td></tr>" +
                    "<tr><td><b>Location Name</b></td><td>" + e.location_name + "</td></tr>" +
                    "<tr><td><b>Agency</b></td><td>" + e.agency_name + "</td></tr>" +
                    "<tr><td><b>Village</b></td><td>" + e.fp_village + "</td></tr>" +
                    "<tr><td><b>SHG</b></td><td>" + e.shgName + "</td></tr>" +
                    "<tr><td><b>Facilitator</b></td><td>" + e.name + "</td></tr>" +
                    "<tr><td><b>Date</b></td><td>" + e.lat_long_date_time + "</td></tr>" +  "</table></div></div>")
            );
        });
        markers.addTo(map);
        map.addLayer(markers);

        var layerGroup2 = L.geoJSON(grte, {
            onEachFeature: function(feature, layer) {
                layer.myTag = "layerGroup2";
            },
            style: function(feature) {

                return {
                    fillColor: 'white',
                    weight: 2,
                    opacity: 2,
                    color: '#777777', //Outline color
                    fillOpacity: 0,
                    visible: false
                };
            }
        }).addTo(map);
    </script>
<?php $__env->stopSection(); ?>
<!-- data-table js -->

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\village\resources\views/family/map.blade.php ENDPATH**/ ?>