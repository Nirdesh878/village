@extends(backpack_view('blank'))

@php
$defaultBreadcrumbs = [
trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
trans('base.cumulative_dashboard') => false,
];

// if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
$breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- [ Main Content ] start -->
@if(isset($years_for_dashboard) && !empty($years_for_dashboard))
<div class="col-md-12">
    <div class="row">
        <div class="card" style="width: 100%">
            <div class="card-header">
                <span>{{trans('base.show_data_by_year')}} :
                    @foreach($years_for_dashboard as $year)
                    <a href="{{url('admin/cumulative_dashboard/'.$year)}}"><button type="button" class="btn @if(isset($selected_year) && $selected_year == $year){{'active-year'}} @endif"> {{$year}} </button></a>
                    @endforeach
                </span>
            </div>
        </div>
    </div>
</div>
@endif
<div class="cumulativeDashboard">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body" style="min-height:206px">
                    <div class="row align-items-start">
                        <div class="col">
                            <h5 class="">{{trans('base.ctp_members')}}</h5>
                        </div>
                        <div class="col-auto text-right">
                            <h2 class="text-c-red">@if(isset($count_ctp_members) && !empty($count_ctp_members)){{$count_ctp_members}}@endif</h2>
                        </div>
                    </div>
                    <div class="row m-t-30">
                        <div class="col-sm-6">
                            <span class="d-block"><i class="fas fa-circle text-c-green f-10 m-r-10 m-b-20"></i>{{trans('base.diamond')}}</span>
                            <span class="d-block"><i class="fas fa-circle text-c-red f-10 m-r-10 m-b-20"></i>{{trans('base.platinum')}}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="d-block"><i class="fas fa-circle text-c-yellow f-10 m-r-10 m-b-20"></i>{{trans('base.gold')}}</span>
                            <span class="d-block"><i class="fas fa-circle text-c-blue f-10 m-r-10 m-b-20"></i>{{trans('base.silver')}}</span>
                        </div>
                    </div>
                    <div class="progress m-t-10 m-b-25" style="height:22px;">
                        @if(isset($percentage_diamond_tier) && !empty($percentage_diamond_tier) && $percentage_diamond_tier != 00.00)
                        <div class="progress-bar bg-success rounded" role="progressbar" style="width: {{$percentage_diamond_tier}}%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{$percentage_diamond_tier}}%</div>
                        @endif
                        @if(isset($percentage_platinum_tier) && !empty($percentage_platinum_tier) && $percentage_platinum_tier != 00.00)
                        <div class="progress-bar bg-danger rounded" role="progressbar" style="width: {{$percentage_platinum_tier}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$percentage_platinum_tier}}%</div>
                        @endif
                        @if(isset($percentage_gold_tier) && !empty($percentage_gold_tier) && $percentage_gold_tier != 00.00)
                        <div class="progress-bar bg-primary rounded" role="progressbar" style="width: {{$percentage_gold_tier}}%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">{{$percentage_gold_tier}}%</div>
                        @endif
                        @if(isset($percentage_silver_tier) && !empty($percentage_silver_tier) && $percentage_silver_tier != 00.00)
                        <div class="progress-bar bg-warning rounded" role="progressbar" style="width: {{$percentage_silver_tier}}%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$percentage_silver_tier}}%</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">	
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="d-block">{{trans('base.social_media_campaigns')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-primary text-white float-right d-inline-block m-0">@if(isset($camp_stat1)){{$camp_stat1}}@else 0 @endif</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span class=" d-block">{{trans('base.mass_media_campaigns')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-danger text-white float-right d-inline-block m-0">@if(isset($camp_stat2)){{$camp_stat2}}@else 0 @endif</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span class=" d-block">{{trans('base.business_asso_on_board')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-primary text-white float-right d-inline-block m-0">@if(isset($camp_stat3)){{$camp_stat3}}@else 0 @endif</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span class="d-block">{{trans('base.tb_free_workplace_campaigns')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-danger text-white float-right d-inline-block m-0">@if(isset($camp_stat4)){{$camp_stat4}}@else 0 @endif</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span class="d-block">{{trans('base.no_of_cap_building_workshop')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-primary text-white float-right d-inline-block m-0">@if(isset($camp_stat5)){{$camp_stat5}}@else 0 @endif</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">	
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="d-block">{{trans('base.no_of_comm_intervention')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-danger text-white float-right d-inline-block m-0">@if(isset($camp_stat6)){{$camp_stat6}}@else 0 @endif</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span class="d-block">{{trans('base.no_reached_for_tb_interv')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-primary text-white float-right d-inline-block m-0">@if(isset($camp_stat7)){{$camp_stat7}}@else 0 @endif</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span class="d-block">{{trans('base.research_projects')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-danger text-white float-right d-inline-block m-0">@if(isset($camp_stat8)){{$camp_stat8}}@else 0 @endif</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span class="d-block">{{trans('base.innovative_projects')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-primary text-white float-right d-inline-block m-0">@if(isset($camp_stat9)){{$camp_stat9}}@else 0 @endif</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <span class="d-block">{{trans('base.total_annual_plans_ready')}}</span>
                        </div>
                        <div class="col text-right">
                            <h5 class="badge badge-danger text-white float-right d-inline-block m-0">@if(isset($camp_stat10)){{$camp_stat10}}@else 0 @endif</h5>
                        </div>
                    </div>
                </div>
            </div>									
        </div>
    </div>
</div>
<div class="row">	
	@if(isset($hall_of_fame_awardees) && !empty($hall_of_fame_awardees))
    <div class="col-md-6">
        <div class="card table-card">
            <div class="card-body p-0">
                <div class="text-center" style="background-color: #0A0C32;background-image: url({{url('public/theme/assets/images/stars.gif')}});min-height: 347px;">
                    <div class="slider3 owl-carousel owl-theme">
                            @foreach($hall_of_fame_awardees as $awardee)       
                            @if(isset($latest_month) && !empty($latest_month) && $awardee->chofa_month_and_year == $latest_month)
                                <div class="item">
                                    <h4 class="text-light" style="padding: 8px 0px 8px 0px;background-color: rgba(0,0,0,0.25);">{{trans('base.hall_of_fame')}}</h4>
                                    <h4 class="text-light" style="padding-top: 5px;">{{trans('base.congratulations')}}!</h4>
                                    <p class="text-light" style="padding: 5px 50px 0px 50px; min-height: 50px;">{{trans('base.heartiest_congratulations')}}<b>{{ucfirst($awardee->company_name)}}</b>{{trans('base.exception_work_on_tb')}}.</p>
                                    <div style="padding:0% 25%;">
                                        <img src="{{url('public/theme/assets/images/hof_holder.jpg')}}" alt="" class="img-fluid">
                                        @if(isset($awardee->company_logo) && !empty($awardee->company_logo))
                                        <img src="{{url('storage/app/uploads/logo/'.$awardee->company_logo)}}" alt="" class="img-fluid hof_company_logo" >
                                        @else
                                        <img src="{{url('public/theme/assets/images/common_logo_new.jpg')}}" alt="" class="img-fluid hof_company_logo" >
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
	@endif
	
	@if(isset($hall_of_fame_awardees) && !empty($hall_of_fame_awardees))
    <div class="col-md-6">
	@else
	<div class="col-md-12">
	@endif
        <div class="card table-card">
            <div class="card-header">
                <h5>{{trans('base.total_csr_spending_on_tb')}}</h5>
            </div>
            <div class="card-body p-0">
                <div class="bg-white text-center">
                    <div class="row-table">
                        <div class="col-sm-12" style="padding: 25px 0px 20px 0px;">
                            <i class="fa fa-coins text-warning f-w-600 update-icon" style="font-size: 130px;"></i>
                            <h6 class="text-dark" style="font-size: 55px; line-height: 60px; padding-top: 20px;"><i class="fa fa-rupee-sign" style="font-size: 45px;"></i> @if(isset($fund_spent_with_unit) && !empty($fund_spent_with_unit)){{$fund_spent_with_unit}}<span style="font-size: 14px">{{trans('base.(approx)')}}</span>@else{{' _ '}}@endif</h6>
                            {{trans('base.(out_of')}} <i class="fa fa-rupee-sign" style="font-size: 12px;"></i> @if(isset($fund_allocated_with_unit) && !empty($fund_allocated_with_unit)){{$fund_allocated_with_unit}}@else{{' _ '}}@endif {{trans('base.allocated)')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	@if(isset($hof_months) && count($hof_months) > 0)
    <div class="col-md-12">								
        <div class="row">
            <!-- [ chartjs-chart ] start -->
            <div class="col-xl-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <h5>{{trans('base.hof_awardees')}}</h5>
                            </div>
                        </div>
                    </div>
                    @foreach($hof_months as $month_year)
                    <div class="card-body widget-last-task">
                        <div class="dash-scroll ps ps--active-y">
                            <p class="m-b-10 text-dark" style="font-size: 15px">{{date('M Y', strtotime($month_year))}}</p>
                            <ul class="list-unstyled m-b-0">
                            @if(isset($hall_of_fame_awardees) && !empty($hall_of_fame_awardees))
                            @foreach($hall_of_fame_awardees as $awardee)
                            @if($awardee->chofa_month_and_year == $month_year)
                                @if(isset($awardee->company_logo) && !empty($awardee->company_logo))
                                <li class="d-inline-block hof-awardee-li" ><img src="{{url('storage/app/uploads/logo/'.$awardee->company_logo)}}" alt="user-image" class="img-30 hof-awardee-img"  title="{{$awardee->company_name}}" ><span class="hof-awardee-name">{{$awardee->company_name}}</span></li>
                                @else
                                <li class="d-inline-block hof-awardee-li" ><img src="{{url('public/theme/assets/images/common_logo_new.jpg')}}" alt="user-image" class="img-30 hof-awardee-img" title="{{$awardee->company_name}}" ><span class="hof-awardee-name">{{$awardee->company_name}}</span></li>
                                @endif
                            @endif
                            @endforeach
                            @endif
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
	@endif
    
    <div class="col-md-12">								
        <div class="row">
            <!-- [ chartjs-chart ] start -->
            <div class="col-xl-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h5>{{trans('base.community_outreach_program')}}</h5>
                                <div style="float: right;margin-left: auto;right: 0px;">
                                    <label for="year">Year</label>
                                    <select class="year" name="year" id="year" data-rule-mandatory="true">
                                    <option value=''>--Select--</option>
                                    @php
                                        $cyear = date('Y');
                                        for ($i = $cyear - 5; $i <= $cyear ; $i++)
                                        {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                            
                                    @endphp
                                    </select>		
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="card-body">
                                    <canvas id="chart-bar-6" style="width: 100%; height: 350px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

@endsection

