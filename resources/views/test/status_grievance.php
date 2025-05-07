<div class="content-wrapper" style="height: calc(100vh - -71px);">
    <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1> <?php echo trim($this->Common_model->get_language_phrase('GrievanceManagement')); ?>
            <small><?php echo trim($this->Common_model->get_language_phrase('ScreentoviewGrievance'));?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo trim($this->Common_model->get_language_phrase('Home')); ?></a></li>
            <li class="active"><?php echo trim($this->Common_model->get_language_phrase('GrievanceManagement')); ?></li>
        </ol>
    </section>
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">  
        <div class="col-xs-12"> 
        <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo trim($this->Common_model->get_language_phrase('Response')); ?> </h3>  
            </div> <hr style="margin: 0px;" />
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><?php echo trim($this->Common_model->get_language_phrase('SrNo')); ?></th>
                            <th><?php echo trim($this->Common_model->get_language_phrase('ResponseStatus')); ?></th>
                            <th><?php echo trim($this->Common_model->get_language_phrase('ResponseStatus')); ?></th>
                            <th><?php echo trim($this->Common_model->get_language_phrase('ResponseBy')); ?></th>
                            <th><?php echo trim($this->Common_model->get_language_phrase('ResponseDate')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($responses)){ ?>
                            <?php $counter = 1; ?>
                            <?php foreach ($responses as $response) { ?>
                                <tr>
                                    <td ><?php echo $counter; ?></td>
                                    <td ><?php echo $response->response_status; ?></td> 
                                    <td ><?php echo $response->Remark; ?></td>
                                    <td ><?php echo $response->Username; ?></td>
                                    <td ><?php echo date('d/m/Y', strtotime($response->CreatedOn)); ?></td> 
                                </tr>
                                <?php $counter++; ?>
                            <?php } } else { ?> 
                            <tr>
                                <td colspan="5">Record not found.</td>
                            </tr>
                         <?php } ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

     <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3><?php echo trim($this->Common_model->get_language_phrase('GrievanceManagement')); ?>
                    <div class="pull-right">  <a href="<?php echo site_url('grievance'); ?>" class="btn btn-danger text-white text-right" style="padding-left:10px;"><?php echo trim($this->Common_model->get_language_phrase('Back')); ?></a>   
                    <a href="<?php echo site_url('Grievance/sendnotification/'.$crop_result->CreatedBy.'/'.$crop_result->ID); ?>" class="text-white btn btn-warning text-right"><?php echo trim($this->Common_model->get_language_phrase('SendNotification')); ?></a></div></h3>   
                    </div>
                    <!-- /.box-header --><hr style="margin: 0px;" />
                    <?php echo form_open(); ?>
                    <input type="hidden" name="ID" value="<?php echo isset($crop_result->ID) ? $crop_result->ID : ''; ?>" />
                    <input type="hidden" name="UniqueCode" value="<?php echo isset($crop_result->UniqueCode) ? $crop_result->UniqueCode : ''; ?>" />
                    <input type="hidden" name="issue_status" value="<?php echo isset($crop_result->issue_status) ? $crop_result->issue_status : ''; ?>" />
                    <input type="hidden" name="CreatedByold" value="<?php echo isset($crop_result->CreatedBy) ? $crop_result->CreatedBy : ''; ?>" />
                    <div class="box-body">  
                        <div class="row"> 
                          <div class="col-md-7 row">                             
                          <div class="col-md-12">
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('WUA')); ?> : </label>
                                   <p class="col-md-6 row"><?php echo isset($crop_result->wuaname) ? $crop_result->wuaname : ''; ?> </p> 
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('WUAMember')); ?> : </label>
                                   <p class="col-md-6 row"><?php echo isset($crop_result->wuamembername) ? $crop_result->wuamembername : ''; ?> </p> 
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('State')); ?> : </label>
                                   <p class="col-md-6 row"><?php echo isset($crop_result->StateName) ? $crop_result->StateName : ''; ?> </p> 
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('District')); ?> : </label>
                                   <p class="col-md-6 row"><?php echo isset($crop_result->DistrictName) ? $crop_result->DistrictName : ''; ?> </p> 
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('Block')); ?> : </label>
                                   <p class="col-md-6 row"><?php echo isset($crop_result->BlockName) ? $crop_result->BlockName : ''; ?> </p> 
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('Village')); ?> : </label>
                                   <p class="col-md-6 row"><?php echo isset($crop_result->VillageName) ? $crop_result->VillageName : ''; ?> </p> 
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('IssueType')); ?> : </label>
                                   <p class="col-md-6 row"><?php echo isset($crop_result->issue_status) ? $crop_result->issue_status : ''; ?> </p>
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('Remarks')); ?> : </label> 
                                   <p class="col-md-6 row"><?php echo isset($crop_result->Remarks) ? $crop_result->Remarks : ''; ?></p>
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('Landmark')); ?> : </label> 
                                   <p class="col-md-6 row"><?php echo isset($crop_result->Landmark) ? $crop_result->Landmark : ''; ?></p> 
                                   <label for="IssueType" class="col-md-6 row"><?php echo trim($this->Common_model->get_language_phrase('CurrentStatus')); ?> : </label> 
                                    <p class="col-md-6 row">
                                        <?php
                                        $firstResponseStatus = 'Pending'; // Set the default value to "Pending"
                                        if (!empty($responses)) {
                                            $firstResponse = reset($responses);
                                            $firstResponseStatus = isset($firstResponse->response_status) ? $firstResponse->response_status : 'Pending'; // Use the response status if available, or default to "Pending"
                                        }
                                        echo $firstResponseStatus;
                                        ?>
                                    </p>
                                    </div>
                            <!-- IssueType dropdown -->
                             <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo trim($this->Common_model->get_language_phrase('Status')); ?> : <span class="required" style="color: red;">*</span></label> 
                                <?php
                                $StatusOptions = array(
                                    '' =>   trim($this->Common_model->get_language_phrase('Select')),
                                  //  1 => 'Pending',
                                    2 => trim($this->Common_model->get_language_phrase('Pending')),
                                    3 => trim($this->Common_model->get_language_phrase('Processing')),
                                    4 => trim($this->Common_model->get_language_phrase('Issue Resolved')), 
                                );
                                echo form_dropdown('Status', $StatusOptions, set_value('Status'), 'class="form-control"');
                                ?>
                            </div> 
                       </div>  
                     <div class="col-sm-12">
                          <div class="form-group" > 
                            <label class="control-label"><?php echo trim($this->Common_model->get_language_phrase('Comments')); ?> : <span class="required" style="color: red;">*</span></label> 
                             <textarea name="Remark" placeholder="Comments" class="form-control" rows="3" maxlength="250" required></textarea>
                          </div>
                        </div> 
                       <div class="col-sm-12 text-left">
                            <button type="submit" class="btn btn-success"><?php echo trim($this->Common_model->get_language_phrase('Submit')); ?></button>
                            <a href="<?php echo site_url('grievance'); ?>" class="btn btn-danger"><?php echo trim($this->Common_model->get_language_phrase('Cancel')); ?></a>
                        </div> 
                    <?php echo form_close(); ?>
                        </div> 
                       <div class="col-md-5 row text-right">
                       <style>
					     .map_landing{
					          width: 100%;
						      height: 490px; 
						      position: relative;
						  }
						  .geo-search button {
							 background-color:#ddd !important;
							} 
					     </style>    
                             
							<?php /*?><script src="<?php echo site_url('')?>common/leaflet/mapjquery.js"></script><?php */?>
							 <link rel="stylesheet" href="<?php echo site_url('')?>common/leaflet/leaflet.css" /> 
                             <script type="text/javascript" src="<?php echo site_url('')?>common/leaflet/leaflet.js"></script> 
							<script type="text/javascript" src="<?php echo site_url('')?>common/leaflet/indialayer.js"></script>
                            <?php /*?><script type="text/javascript" src="<?php echo site_url('')?>common/leaflet/maharashtra.js"></script><?php */?>
						    <script src="//unpkg.com/@sjaakp/leaflet-search/dist/leaflet-search.js"></script>
							<div id="map" class="map_landing"></div>
                             <script> 
								var get_data=null;  
								$.ajax({
									url:"<?php echo site_url('Grievance/latlongdata/'.$crop_result->ID); ?>",    
                                        //the page containing php script
                                        type: "post",    //request type,
                                        data: {},
                                        'async': false,
                                        success:function(result){
                                        	var parsedData = JSON.parse(result);
                                        	get_data=parsedData; 
                                        }
                                    });


								var map = L.map('map', {minZoom: 4,  maxZoom: 20 }, { fullscreenControl: { pseudoFullscreen: false }, zoomControl: false }).setView(new L.LatLng(19.25023195, 73.16017493), 4); 
								var tiles =L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', { maxZoom: 14, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] }).addTo(map);
								var baseMaps = { 
									"Hybrid": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] }),
									"Satellite": L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] }),
									"Terrain": L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] })
								}	
								map.addControl(L.control.search());		 
								 
								var markers = new L.FeatureGroup();
								var constant = $.map( get_data, function( e ) {
								  var greenIcon = L.icon({
										iconUrl: '<?php echo site_url('')?>common/leaflet/location.png',  
										iconSize:     [28, 28], // size of the icon 
										iconAnchor:   [8, 16]  
									});   
								   L.marker([e.Latitude,e.Logitude],{icon : greenIcon}).addTo(markers).bindPopup("<div class='popup_div'><div class='row'><table class='table table-striped'>"+"<tr><td><b>Issue Type</b></td><td>"+e.issue_status+"</td></tr>"+"<tr><td><b>Status</b></td><td>"+e.response_status+"</td></tr>"+"<tr><td><b>Latitude</b></td><td>"+e.Latitude+"</td></tr>"+"<tr><td><b>Logitude</b></td><td>"+e.Logitude+"</td></tr>"+"<tr><td><b>Reported On</b></td><td>"+e.CreatedOn+"</td></tr>"+"</table></div></div>"); 
								});
								markers.addTo(map); 
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
                        </div>
                        </div>
                    </div> 
            </div>
        </div>
    </section>
</div>
