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
                        <li class="breadcrumb-item">MAP</li>
                    </ul>
                </div>
                @php $session_data = Session::get('cluster_session'); @endphp

                <div style="clear: both"></div>
                <div class="page-header-title">
                    <div class="d-inline"> 
                        <h4>Cluster MAP</h4>
                    </div>
                    {{-- <div id="map" style="width: 450px; height: 305px; border: 1px #a3c86d; border-style: none solid solid solid;"></div> --}}

                </div>
            </div>

            
          </div>
        </div>
        <div class="card"> 
          <div class="card-block pt-2 pb-2">
              <div class="mT-30"> 
                  
                  <form class="" method="post" action="{{ url('getLatLongCluster')}}">
                      @csrf
                      <div class="row"> 

                        <div class="col-md-2 mb-3">
                          <label for="validationCustom02">Country</label>
                          <select class="form-control" name="country" id="country">
                              <option value="">--Select--</option>
                              @foreach ($countries as $row)
                                  <option value="{{ $row->id }}"
                                    {{(!empty(Session::get('cluster_session')['country'])&& ((Session::get('cluster_session')['country']) == $row->id ) ? "selected":"")}}>
                                      {{ $row->name }}</option>
                              @endforeach
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
                              @foreach ($agency as $row)
                                  <option value="{{ $row->agency_id }}"
                                    {{(!empty(Session::get('cluster_session')['agency_id'])&& ((Session::get('cluster_session')['agency_id']) == $row->id ) ? "selected":"")}}>
                                      {{ $row->agency_name }}</option>
                              @endforeach
                          </select>
                        </div>

                        {{-- <div class="col-lg-3">
                          <div class="form-group">   
                            <label for="order" class="col-form-label">Federation</label>
                            <select class="form-control select federation_id" name="federation_id" id="federation_id">
                            <option value="">--Select--</option>
                            <option value="1">rgerdgdrg</option>
                            </select>
                          </div>
                        </div> --}}

                        {{-- <div class="col-md-2 mb-3">
                          <label for="validationCustom02">Cluster</label>
                          <select class="form-control cluster_id" name="cluster_id" id="cluster_id">
                              <option value="">--Select--</option>
                          </select>
                        </div> --}}

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
              @include('common.error')
              <table id="simpletable" class="table table-striped table-bordered nowrap">
                      <thead>
                      <tr>
                          <th width="5%">S.No</th>
                          <th width="15%">UIN</th>
                          <th width="15%">Cluster</th>
                          <th width="15%">Federation</th>
                          <th width="15%">Task Status</th>
                          <th width="10%">Created At</th>
                          
                          <th >Last Update</th>
                          <th >Locked</th>
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
  .map_landing{
       width: 100%;
     height: 490px; 
     position: relative;
     border: 10px solid #8080e6;
 }
 .geo-search button {
  background-color:#ddd !important;
 } 

 .marker-cluster {
  /* background-color: rgba(87, 131, 241, 0.6); */
  background-color: rgba(241, 128, 23, 0.6); /* Change the background color as desired */
  border-radius: 100%; /* Make it a circle */
  text-align: center;
  color: black; /* Text color */
  font-weight: bold; /* Bold text */
  line-height: 40px;
  opacity: 1;
  transform: translate3d(616px, 156px, 0px);
  z-index: 156;
  outline-style: none;
  }
  </style> 
<script type="text/javascript"
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD1wOf9ISBejnZhC-umNwWdaQbuSk3mMwg&sensor=false"></script>
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
<link rel="stylesheet" href="{{ asset('assets\leaflet\leaflet.css') }}" />
<script type="text/javascript" src="{{ asset('assets\leaflet\leaflet.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets\leaflet\indialayer.js') }}"></script>
<script src="//unpkg.com/@sjaakp/leaflet-search/dist/leaflet-search.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/leaflet.markercluster.js"
integrity="sha512-OFs3W4DIZ5ZkrDhBFtsCP6JXtMEDGmhl0QPlmWYBJay40TT1n3gt2Xuw8Pf/iezgW9CdabjkNChRqozl/YADmg=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/MarkerCluster.Default.css"
integrity="sha512-6ZCLMiYwTeli2rVh3XAPxy3YoR5fVxGdH/pz+KMCzRY2M65Emgkw00Yqmhh8qLGeYQ3LbVZGdmOX9KUjSKr0TA=="
crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .leaflet-control-zoomhome a {
    font: bold 18px "Lucida Console",Monaco,monospace;
}

a.leaflet-control-zoomhome-in,
a.leaflet-control-zoomhome-out {
  font-size: 1.5em;
  line-height: 26px;
}
.leaflet-control-draw-measure {
    background-image: url(measure-control.png);
}

.leaflet-control-zoom a{
  display: none;
}

</style>
<script>
  $(document).ready(function(){
    $('#country').on('change', get_state_list);
    $('#state').on('change', get_district_list);
    $('#country').trigger('change');
    // $('#agency_id').on('change', get_cluster_list_id);
    $('#agency_id').on('change', get_fac_list_id);


    @php echo !empty($session_data["country"]) && $session_data["country"]>0 ? "$('#country').val('".$session_data["country"]."');$('#country').trigger('change');" : "" @endphp

    @php echo !empty($session_data["agency_id"]) && $session_data["agency_id"]>0 ? "$('#agency_id').val('".$session_data["agency_id"]."');$('#agency_id').trigger('change');" : "" @endphp

    
    });

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
        "url": '{{ url('mapDatatableCluster') }}',
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
                                @php echo !empty($session_data["state"]) && $session_data["state"]>0 ? "$('#state').val('".$session_data["state"]."');" : "" @endphp
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
                                @php echo !empty($session_data["district"]) && $session_data["district"]>0 ? "$('#district').val('".$session_data["district"]."');" : "" @endphp
                                $('#district').trigger("change");
                            }
                        }
                    });
                }
            }

            function get_federation_list() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_federation_list_id',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                    success: function(data) {
                        if (data != '') {
                            $('#federation_id').html(data);
                            @php echo !empty($session_data["federation_id"]) && $session_data["federation_id"]>0 ? "$('#federation_id').val('".$session_data["federation_id"]."');" : "" @endphp
                            $('#federation_id').trigger("change");
                        }
                    }
                });
            }
        }

            function get_cluster_list_id() {
            var obj = $(this);
            var agency_id = obj.val();
            if (agency_id > 0) {
                $.ajax({
                    type: 'GET',
                    url: '/get_cluster_list_id',
                    data: '_token = <?php echo csrf_token(); ?>&agency_id=' + agency_id,
                    success: function(data) {
                        if (data != '') {
                            $('#cluster_id').html(data);
                            @php echo !empty($session_data["cluster_id"]) && $session_data["cluster_id"]>0 ? "$('#cluster_id').val('".$session_data["cluster_id"]."');" : "" @endphp
                            $('#cluster_id').trigger("change");
                        }
                    }
                });
            }
        }

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
                            @php echo !empty($session_data["Fac_id"]) && $session_data["Fac_id"]>0 ? "$('#Fac_id').val('".$session_data["Fac_id"]."');" : "" @endphp
                            $('#Fac_id').trigger("change");
                        }
                    }
                });
            }
        }
</script>
<script> 
  var get_data=null;  
  $.ajax({
    url:"/getLatLongCluster",    
      //the page containing php script
      type: "get",    //request type,
      data: '_token = <?php echo csrf_token(); ?>', 
      'async': false,
      success:function(result){
        var parsedData = JSON.parse(result); 
        console.log(parsedData);
        get_data=parsedData;  
      } 
  });


  var map = L.map('map', {minZoom: 4,  maxZoom: 20 }, { fullscreenControl: { pseudoFullscreen: false }, zoomControl: false }).setView(new L.LatLng(19.25023195, 73.16017493), 4); 
	var tiles =L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] }).addTo(map);
	// var baseMaps = { 
	// 								"Hybrid": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] }),
	// 								"Satellite": L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] }),
	// 								"Terrain": L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] })
	// 							}	
  var baseMaps = { 
    "Hybrid": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] }),
    "Satellite": L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] }),
    "Terrain": L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] })
  }	
  
  
    // var zoomHome = L.Control.zoomHome();
    // zoomHome.addTo(map);
    map.addControl(L.control.search());	 
								 
    var layerControl = L.control.layers(baseMaps).addTo(map);

	// var markers = new L.FeatureGroup();

  var markers = new L.MarkerClusterGroup({iconCreateFunction: function (cluster) {
 var childCount = cluster.getChildCount();
      

      return new L.DivIcon({ html: '<div><span>' + childCount + '</span></div>', 
        className: 'marker-cluster' , iconSize: new L.Point(40, 40) });
 } });


  var constant = $.map( get_data, function( e ) {
    // if((e.id % 2) == 0){
    //   var greenIcon = L.icon({
		// 									iconUrl: 'https://www.dartanalytic.com/assets/icon/naturalcostal.png',  
		// 								iconSize:     [46, 46], // size of the icon 
		// 								iconAnchor:   [8, 16]  
    //               });
    // }else{
    //   var greenIcon = L.icon({
		// 									iconUrl: 'https://www.dartanalytic.com/assets/icon/naturalinland.png',  
		// 									iconSize:     [36, 36], // size of the icon 
		// 								iconAnchor:   [8, 16]     
		// 							});
    // } 
    var greenIcon = L.icon({ 
      iconUrl: 'https://icons.iconarchive.com/icons/paomedia/small-n-flat/256/map-marker-icon.png',  
      iconSize:     [24, 24], // size of the icon 
      iconAnchor:   [8, 16]  
    });  

    markers.addLayer(L.marker([e.latitude,e.longitude],{icon : greenIcon}).addTo(markers).bindPopup("<div class='popup_div'><div class='row'><table class='table table-striped'>"+"<tr><td><b>Cluster</b></td><td>"+e.name_of_cluster+"</td></tr>"+"<tr><td><b>Latitude</b></td><td>"+e.latitude+"</td></tr>"+"<tr><td><b>Latitude</b></td><td>"+e.longitude+"</td></tr>"+"<tr><td><b>Location Name</b></td><td>"+e.location_name+"</td></tr>"+"<tr><td><b>Agency</b></td><td>"+e.agency_name+"</td></tr>"+ "<tr><td><b>Date</b></td><td>" + e.lat_long_date_time + "</td></tr>" +"</table></div></div>")); 
  }); 
  markers.addTo(map); 
  map.addLayer(markers);


  var layerGroup2= L.geoJSON(grte,{
    onEachFeature: function (feature, layer) {
      layer.myTag = "layerGroup2";
    },style: function(feature){

      return{
        fillColor: 'white',
        weight: 2,
        opacity: 2,
          color: '#777777',  //Outline color
          fillOpacity:0,
          visible:false
        };
      } 
    }).addTo(map); 
  </script> 
  






@endsection
<!-- data-table js -->
