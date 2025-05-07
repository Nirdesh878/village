<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Details </title>
</head>
<style>
    .round {
        border-radius: 85%;
        width: 35px;
        height: 35px;
    }

    .table1 {
        width: 100%;
    }

    .table {
        border: 1px solid #e9ecef;
    }

    .table td,
    .table th {
        padding: .50rem;

    }

    .table td th {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;

    }



    .table-primary,
    .table-primary>td,
    .table-primary> {
        background-color: #01a9ac;
        color: black;
        font-size: 25px;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #e9ecef;
    }

    .tdc {
        text-align: center;
    }

    .page-break {
        page-break-before: always;
    }

    th {
        text-align: start;
    }

    .checkmark {
        display: inline-block;
        transform: rotate(45deg);
        height: 25px;
        width: 12px;
        margin-left: 60%;
        border-bottom: 7px solid black;
        border-right: 7px solid black;
        margin-left: ;
    }
</style>

<body class="antialiased container mt-5">
    <h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generated
        On- @php
            echo generated_date();
        @endphp
    </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Family
                    Profile({{ $family->uin }})</u>
            </h2>
        </div>

    </div>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">BASIC INFORMATION</td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Name & Other Details</td>

            </tr>
        </thead>
        <thead>
            <tr>
                <th width="25%">Member name</th>
                <td width="25%">{{ $family_profile[0]->fp_member_name }}</td>
                <th width="25%">UIN</th>
                <td width="25%">{{ $family->uin }}</td>
            </tr>
            <tr>

                <th width="25%">Gender</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_gender) }}</td>
                <th width="25%">Caste</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_caste) }}</td>
            </tr>
            <tr>

                <th width="25%">Age</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_age) }}</td>
                <th width="25%">Contact No</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_contact_no) }}</td>
            </tr>
            <tr>
                <th width="25%">Pan</th>
                @if ($family_profile[0]->fp_pan != '')
                    <td width="25%">{{ checkna(pan($family_profile[0]->fp_pan)) }}</td>
                @else
                    <td width="25%">N/A</td>
                @endif
                <th width="25%">Aadhar No</th>
                @if ($family_profile[0]->fp_aadhar_no != '')
                    <td width="25%">{{ checkna(aadhar($family_profile[0]->fp_aadhar_no)) }}</td>
                @else
                    <td width="25%">N/A</td>
                @endif
            </tr>
            <tr>
                <th width="25%">Village</th>
                <td width="25%">{{ $family_profile[0]->fp_village }}</td>
                <th width="25%">Name of SHG</th>
                <td width="25%">{{ $shg_profile[0]->shgName }}</td>
            </tr>
            <tr>
                <th width="25%">Federation</th>
                <td width="25%">{{ $fed_profile[0]->name_of_federation }}</td>
                <th width="25%">Cluster/Habitation Federation </th>
                <td width="25%">
                    {{ !empty($clusterprofile[0]->name_of_cluster) ? $clusterprofile[0]->name_of_cluster : 'N/A' }}
                </td>
            </tr>
            <tr>

                <th width="25%">Block</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_block) }}</td>
                <th width="25%">District</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_district) }}</td>
            </tr>
            <tr>

                <th width="25%">State</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_state) }}</td>
                <th width="25%">Country</th>
                <td width="25%">{{ $family_profile[0]->fp_country }}</td>
            </tr>
            <tr>
                <th width="25%">Bank</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_bank) }}</td>
                <th width="25%">Bank Account</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_bank_account) }}</td>
            </tr>
            <tr>
                <th width="25%">Account</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_account) }}</td>
                <th width="25%">Account Holder</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_account_holder) }}</td>
            </tr>
            <tr>

                <th width="25%">Bank Branch</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_bank_branch) }}</td>
                <th width="25%">Spouse Name</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_spouse_name) }}</td>
            </tr>
            <tr>

                <th width="25%">Female Headed</th>
                <td width="25%">
                    {{ $family_profile[0]->fp_female_headed != '' ? $family_profile[0]->fp_female_headed : 'N/A' }}
                </td>
                <th></th>
                <td></td>
            </tr>
        </thead>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Family Members</td>

            </tr>
        </thead>
        <thead>
            <tr>
                <th width="25%">SHG Member And Spouse</th>
                <td width="25%">{{ (int) $family_profile[0]->shg_member_spouse }}</td>
                <th width="25%">Children </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_children_no }}</td>
            </tr>
            <tr>
                <th width="25%">Daughter In Law </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_doughterinlay_no }}</td>
                <th width="25%">Parent In Laws </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_parentinlaws_no }}</td>
            </tr>
            <tr>
                <th width="25%">Family Member Over 60year</th>
                <td width="25%">{{ $family_profile[0]->fp_family_mamber_over_60year }}</td>
                <th width="25%">No of Differently abled family members</th>
                <td width="25%">{{ $family_profile[0]->fp_family_mamber_medication }}</td>
            </tr>
            <tr>
                <th width="25%">Vulnerable People</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_vulnerable_people }}</td>
                <th width="25%">Married Children Live In</th>
                <td width="25%">
                    {{ $family_profile[0]->fp_married_children_live_in != '' ? $family_profile[0]->fp_married_children_live_in : 0 }}
                </td>
            </tr>
            <tr>
                <th width="25%">Others </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_others_no }}</td>
                <th width="25%">Total Family Members </th>
                <td width="25%">{{ (int) (int) $family_profile[0]->fp_family_mambers_no }}</td>
            </tr>

        </thead>

    </table>
    <div class="page-break"></div>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Children Profile</td>

            </tr>
        </thead>
        <thead>
            <tr>
                <th width="25%">Non School Children </th>
                <td width="25%">{{ (int) $family_profile[0]->non_school_children_no }}</td>
                <th width="25%">Employed Children</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_employed }}</td>
            </tr>
            <tr>
                <th width="25%">Children In Primary School</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_children_no_in_primary_school }}</td>
                <th width="25%">Children In Higher Secondary </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_children_no_in_secondary_higher }}</td>
            </tr>
            <tr>
                <th width="25%">Children In College</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_children_no_in_college }}</td>
                <th width="25%">Studing at Home</th>
                <td width="25%">{{ (int) $family_profile[0]->studiedat_home }}</td>
            </tr>
            <tr>
                <th width="25%">Total Childrens</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_total_children }}</td>
                <td></td>
                <td></td>
            </tr>


        </thead>

    </table>
    <br>
    {{-- family memebers info --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="14">Family Member Info</td>

            </tr>
            <tr>
                <th>Name</th>
                <th>DOB</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Relation</th>
                <th>Education</th>
                <th>Current Status</th>
                <th>Marital Status</th>
                <th>Employed</th>
                <th>Differently Abled</th>
                <th>Pension</th>
                <th>Malnutritions</th>
                <th>Undernourished</th>
                <th>Vulnerable</th>
            </tr>
        </thead>
        <thead>
            @foreach ($family_member_info as $res)
                <tr>
                    <td>{{ $res->name }}</td>
                    <td>{{ $res->dob }}</td>
                    <td>{{ $res->age }}</td>
                    <td>{{ $res->gender }}</td>
                    <td>{{ $res->relation }}</td>
                    <td>{{ $res->education }}</td>
                    <td>{{ $res->currentStatus }}</td>
                    <td>{{ $res->maritalStatus }}</td>
                    <td>{{ $res->employed != 0 ? 'Yes' : 'No' }}</td>
                    <td>{{ $res->differentlyAbled != 0 ? 'Yes' : 'No' }}</td>
                    <td>{{ $res->pension != 0 ? 'Yes' : 'No' }}</td>
                    <td>{{ $res->malnutritions != 0 ? 'Yes' : 'No' }}</td>
                    <td>{{ $res->undernourished != 0 ? 'Yes' : 'No' }}</td>
                    <td>{{ $res->vulnerable != 0 ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach



        </thead>

    </table>
    <br>
    {{-- govt. program --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="3">Govt. Livelihood Programs</td>

            </tr>
            <tr>
                <th width="40%">Are you aware of Govt. Livelihood Programs?</th>
                <th>{{ $family_profile[0]->gov_liveilhood_program }}</th>
                <th></th>
            </tr>
        </thead>
        
            <tbody>
                <tr>
                    <th>Programs</th>
                    <th>Benifits recived</th>
                    <th>Benifits</th>
                </tr>
                @foreach ($gov_program as $res)
                    @php
                        $benefis = explode(',', $res->benefit_1);
                        $count = count($benefis);
                    @endphp
                    <tr>
                        <td>{{ $res->program_name }}</td>
                        <td>{{ $res->recived_benefit == 1 ? 'Yes' : 'No' }}
                        </td>
                        <td>
                            @for ($i = 0; $i <= $count - 1; $i++)
                                <ul style="list-style-type:disc;">
                                    <li>{{ $benefis[$i] }}</li>
                                </ul>
                            @endfor

                        </td>
                    </tr>
                @endforeach



            </tbody>
      

    </table>
    <br>

    {{-- education --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Education</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan=2>A. Family not educated up to at least six years of schooling?</th>
                <td colspan=2>{{ $family_profile[0]->family_member_not_educated }}</td>

            </tr>
            @if ($family_profile[0]->family_member_not_educated == 'Yes')
                <tr>
                    <th width="25%">i. Male</th>
                    <td width="25%">{{ $family_profile[0]->family_member_not_educatedMale }}</td>
                    <th width="25%">ii. Female</th>
                    <td width="25%">{{ $family_profile[0]->family_member_not_educatedaFemale }}</td>
                </tr>
                <tr>
                    <th width="25%">iii. Total</th>
                    <td width="25%">{{ $family_profile[0]->family_member_not_educatedaTotal }}</td>
                    <th width="25%"></th>
                    <td width="25%"></td>
                </tr>
            @endif


        </tbody>
        <tbody>
            <tr>
                <th colspan=2>B. Any children or adolescents up to age of 13 away from school or deopped out?</th>
                <td colspan=2>{{ $family_profile[0]->children_or_adolescents_upto_age }}</td>

            </tr>
            @if ($family_profile[0]->children_or_adolescents_upto_age == 'Yes')
                <tr>
                    <th width="25%">i. Male</th>
                    <td width="25%">{{ $family_profile[0]->children_or_adolescents_uptoMale }}</td>
                    <th width="25%">ii. Female</th>
                    <td width="25%">{{ $family_profile[0]->children_or_adolescents_uptoFemale }}</td>
                </tr>
                <tr>
                    <th width="25%">iii. Total</th>
                    <td width="25%">{{ $family_profile[0]->children_or_adolescents_uptoTotal }}</td>
                    <th width="25%"></th>
                    <td width="25%"></td>
                </tr>
            @endif


        </tbody>

    </table>
    <br>
    {{-- nutrition --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Nutrition and Mortality</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan=2>A. Family member have access to all three meals on a daily basis?</th>
                <td colspan=2>{{ $family_profile[0]->aNutritionMortality }}</td>

            </tr>
            @if ($family_profile[0]->aNutritionMortality == 'No')
                <tr>
                    <th width="25%">i. Male</th>
                    <td width="25%">{{ $family_profile[0]->aNutritionMortalityMale }}</td>
                    <th width="25%">ii. Female</th>
                    <td width="25%">{{ $family_profile[0]->aNutritionMortalityFeMale }}</td>
                </tr>
                <tr>
                    <th width="25%">iii. Total</th>
                    <td width="25%">{{ $family_profile[0]->aNutritionMortalityTotal }}</td>
                    <th width="25%"></th>
                    <td width="25%"></td>
                </tr>
            @endif


        </tbody>
        <tbody>
            <tr>
                <th colspan=2>B.Does any member suffer due to malnutrition?</th>
                <td colspan=2>{{ $family_profile[0]->bNutritionMortality }}</td>

            </tr>
            @if ($family_profile[0]->bNutritionMortality == 'Yes')
                <tr>
                    <th width="25%">i. Male</th>
                    <td width="25%">{{ $family_profile[0]->bNutritionMortalityMale }}</td>
                    <th width="25%">ii. Female</th>
                    <td width="25%">{{ $family_profile[0]->bNutritionMortalityFeMale }}</td>
                </tr>
                <tr>
                    <th width="25%">iii. Total</th>
                    <td width="25%">{{ $family_profile[0]->bNutritionMortalityTotal }}</td>
                    <th width="25%"></th>
                    <td width="25%"></td>
                </tr>
            @endif


        </tbody>
        <tbody>
            <tr>
                <th colspan=2>C.Does any one of the children/adolescents or adults appear to be undernourished
                    (stunted,wasted,under-weight)?</th>
                <td colspan=2>{{ $family_profile[0]->cNutritionMortality }}</td>

            </tr>
            @if ($family_profile[0]->cNutritionMortality == 'Yes')
                <tr>
                    <th width="25%">i. Male</th>
                    <td width="25%">{{ $family_profile[0]->cNutritionMortalityMale }}</td>
                    <th width="25%">ii. Female</th>
                    <td width="25%">{{ $family_profile[0]->cNutritionMortalityFeMale }}</td>
                </tr>
                <tr>
                    <th width="25%">iii. Total</th>
                    <td width="25%">{{ $family_profile[0]->cNutritionMortalityTotal }}</td>
                    <th width="25%"></th>
                    <td width="25%"></td>
                </tr>
            @endif


        </tbody>
        <tbody>
            <tr>
                <th colspan=2>D.Have any children or adolescents died below age 18?</th>
                <td colspan=2>{{ $family_profile[0]->dNutritionMortality }}</td>

            </tr>
            @if ($family_profile[0]->dNutritionMortality == 'Yes')
                <tr>
                    <th width="25%">i. Male</th>
                    <td width="25%">{{ $family_profile[0]->dNutritionMortalityMale }}</td>
                    <th width="25%">ii. Female</th>
                    <td width="25%">{{ $family_profile[0]->dNutritionMortalityFeMale }}</td>
                </tr>
                <tr>
                    <th width="25%">iii. Total</th>
                    <td width="25%">{{ $family_profile[0]->dNutritionMortalityTotal }}</td>
                    <th width="25%"></th>
                    <td width="25%"></td>
                </tr>
            @endif


        </tbody>
    </table>
    <br>
    {{-- standard of living --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="2">Standard of Living</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">A.Sanitation Does the family</th>
                <td width="25%">{{ $family_profile[0]->sanitation }}</td>
            </tr>
            <tr>
                <th width="25%">B.Electricity Does the house they live in have electercity?</th>
                <td width="25%">{{ $family_profile[0]->sElectricity }}</td>

            </tr>
            <tr>
                <th width="25%">C.Drinking water Do they fetch water for drinking from</th>
                <td width="25%">{{ $family_profile[0]->sDrinkingWater }}</td>
            </tr>
            <tr>
                <th width="25%">D.Cooking Fuel What is the method used by family</th>
                <td width="25%">{{ $family_profile[0]->sCookingFuel }}</td>
            </tr>




        </tbody>


    </table>
    <br>
    {{-- Health status --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Health Status</td>

            </tr>
        </thead>
        <tbody>

            <tr>
                <th colspan="2">Health Issues Any member in the house having illness during last 2 years</th>
                <td colspan="2">{{ $family_profile[0]->sHealthIssues }}</td>

            </tr>
            @if ($family_profile[0]->sHealthIssues == 'Yes')
                <tr>
                    <th width="25%">i. Male</th>
                    <td width="25%">{{ $family_profile[0]->sHealthIssuesMale }}</td>
                    <th width="25%">ii. Female</th>
                    <td width="25%">{{ $family_profile[0]->sHealthIssuesFeMale }}</td>
                </tr>
                <tr>
                    <th width="25%">iii. Total</th>
                    <td width="25%">{{ $family_profile[0]->sHealthIssuesTotal }}</td>
                    <th width="25%"></th>
                    <td width="25%"></td>
                </tr>
            @endif


        </tbody>


    </table>
    <br>



    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Family Earning</td>

            </tr>
        </thead>
        <thead>
            <tr>
                <th width="25%">Members Earning Pension </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_pension_member }}</td>
                <th width="25%">Members Earning Fixed Income</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_mamber_no_earn_fixed_income }}</td>
            </tr>
            <tr>
                <th width="25%">Members Earning Seasonal Income</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_mamber_no_earn_seasonal_income }}</td>
                <th width="25%">Members Earning Daily Income</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_mamber_no_earn_daily_income }}</td>
            </tr>
            <tr>

                <th width="25%">Total Members Earning Income</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_earning_an_income }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>

        </thead>

    </table>
    <br>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Family Migration</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Has family migrated from other place during last 2 years/ Y/No </th>
                <td width="25%">{{ checkna($family_profile[0]->fp_family_migrated) }}</td>
                <th width="25%">Member Reason Of Migration</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_family_reason_of_migration) }}</td>

            </tr>
        </tbody>
    </table>

    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Family Wealth Ranking </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Wealth Rank</th>
                <td width="25%">{{ $family_profile[0]->fp_wealth_rank }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">FAMILY ASSETS</td>
            </tr>
        </thead>
    </table>
    <br>


    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Land</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Land Size</th>
                <td width="25%">{{ checkna($assets[0]->fa_land_type) }}</td>
                <th width="25%">Land Cultivated By Family</th>
                <td width="25%">
                    {{ $assets[0]->fa_land_cultivated != '' ? number_format($assets[0]->fa_land_cultivated, 2) : '0.00' }}
                </td>

            </tr>
            <tr>
                <th width="25%">Land Mortgaged</th>
                <td width="25%">
                    {{ $assets[0]->fa_land_mortgaged != '' ? $assets[0]->fa_land_mortgaged : 'N/A' }}
                </td>

                <th width="25%">Land Owned but cultivated as sharecroping</th>
                <td width="25%">
                    {{ $assets[0]->fa_land_owned != '' ? number_format($assets[0]->fa_land_owned, 2) : '0.00' }}
                </td>
            </tr>
            @if ($assets[0]->fa_land_mortgaged != 'No')
                <tr>

                    <th width="25%">Date of loss mortgage</th>
                    <td width="25%">{{ change_date_new($assets[0]->fa_date_of_mortgage) }}
                    </td>

                    <th width="25%">How much land</th>
                    <td width="25%">
                        {{ $assets[0]->fa_mortagged_how_much_land != '' ? number_format($assets[0]->fa_mortagged_how_much_land) : '0.00' }}
                    </td>

                </tr>
            @endif
            <tr>

                <th width="25%">Land Not Owned but cultivated as sharecroping</th>
                <td width="25%">
                    {{ $assets[0]->fa_land_not_owned != '' ? number_format($assets[0]->fa_land_not_owned, 2) : '0.00' }}
                </td>
                <th width="25%">Total Land Owned and Cultivated by Family</th>
                <td width="25%">
                    {{ $assets[0]->fa_total_land_owned != '' ? number_format($assets[0]->fa_total_land_owned, 2) : '0.00' }}
                </td>
            </tr>

        </tbody>
    </table>
    <div class="page-break"></div>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="2">Livestock</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="50%">Name of Animals</th>
                <th width="50%">No. of Animals</th>
            </tr>
            @if (!empty($assets_live_stock))
                @foreach ($assets_live_stock as $row)
                    <tr>
                        <td width="50%">{{ checkna($row->animal_Types) }}</td>
                        <td width="50%">{{ $row->no_of_animals != '' ? $row->no_of_animals : 0 }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Home Gadgets/Equipment</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">Name of Gadgets</th>
                <th width="25%">No. of Gadgets</th>
                <th width="25%">Name of Gadgets</th>
                <th width="25%">No. of Gadgets</th>
            </tr>
            <tr>
                <th width="25%">Tv color</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_tvcolor == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%">Tv black/white</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_tvblackwhite == 1 ? 'Yes' : 'No' }}</td>

            </tr>
            <tr>
                <th width="25%">Air conditioners</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_airconditioners == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%">Coolers</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_coolers == 1 ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th width="25%">Sewingmachines</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_sewingmachines == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%">Smartphone</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_smartphone == 1 ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th width="25%">Wet Grinder</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->wet_grinder == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%">Mixi</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->mixi == 1 ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th width="25%">Washing Machines</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->washing_machines == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%">Computer</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->computer == 1 ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th width="25%">Refrigerator</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->refrigerator == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%">Other</th>
                @if ($assets_gadgets[0]->fa_other == 1)
                    <td width="25%">{{ $assets_gadgets[0]->fa_other_choice }}</td>
                @else
                    <td width="25%">No</td>
                @endif
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Housing Unit/Others Assets</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">House Ownership</th>
                <td width="25%">{{ checkna($assets[0]->house_ownership) }}</td>
                <th width="25%">Pacca Kaccha House</th>
                <td width="25%">{{ checkna($assets[0]->fa_Pacca_Kaccha_house) }}</td>

            </tr>
            <tr>
                <th width="25%">Animalsheds</th>
                <td width="25%">{{ checkna($assets[0]->fa_animalsheds) }}</td>
                <th width="25%"></th>
                <td width="25%"></td>

            </tr>

        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td colspan="2">Vehicle</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="50%">Name of Vehicle</th>
                <th width="50%">No. of Vehicle</th>
            </tr>
            @if (!empty($assets_vehicle))
                @foreach ($assets_vehicle as $row)
                    <tr>
                        <td width="50%">{{ checkna($row->vehicle_Types) }}</td>
                        <td width="50%">{{ $row->no_of_vehicle != '' ? $row->no_of_vehicle : 0 }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td colspan="2">Machinery</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="50%">Name of Machinery</th>
                <th width="50%">No. of Machinery</th>
            </tr>
            @if (!empty($assets_machinery))
                @foreach ($assets_machinery as $row)
                    <tr>
                        <td width="50%">{{ checkna($row->machinery_Types) }}</td>
                        <td width="50%">{{ $row->no_of_machinery != '' ? $row->no_of_machinery : 0 }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <br>



    <table class="table table-bordered table-stripped table1 " style="margin-top:5px;" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Personal Items/Others</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%">A. Does the family own any jewelry</th>
                <td width="25%">{{ checkna($assets[0]->fa_jewelry_yes_no) }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th width="25%">B. Jewelry Pawned to take Loan </th>
                <td width="25%">{{ checkna($assets[0]->jewelry_pawned_take_loan_yesno) }}</td>
                <td></td>
                <td></td>
            </tr>
            @if ($assets[0]->jewelry_pawned_take_loan_yesno == 'Yes')
                <tr>
                    <th width="25%">i. Lander Type</th>
                    <td width="25%">{{ checkna($assets[0]->jewelry_pawned_lander_type) }}</td>
                    <th width="25%">ii. Amount </th>
                    <td width="25%">{{ checkna($assets[0]->jewelry_pawned_loan_amount) }}</td>
                </tr>
                <tr>
                    <th width="25%">iii.Date</th>
                    <td width="25%">{{ checkna($assets[0]->jewelry_pawned_loan_when) }}</td>
                    <th width="25%">iv. Interest rate</th>
                    <td width="25%">{{ checkna($assets[0]->jewelry_pawned_loan_interest) }}</td>
                </tr>
            @endif
            <tr>
                <th width="25%">C. Any jewelry pawned to take loan got lost</th>
                <td width="25%">{{ checkna($assets[0]->jewelry_pawned_lost_yesno) }}</td>
                <td></td>
                <td></td>
            </tr>
            @if ($assets[0]->jewelry_pawned_lost_yesno == 'Yes')
                <tr>
                    <th width="25%">i. Lander Type</th>
                    <td width="25%">{{ checkna($assets[0]->jewelry_pawned_lander_lost_type) }}</td>
                    <th width="25%">ii. Amount </th>
                    <td width="25%">{{ (int) checkna($assets[0]->jewelry_pawned_loan_lost_amount) }}</td>
                </tr>
                <tr>
                    <th width="25%">iii. Date</th>
                    <td width="25%">{{ checkna($assets[0]->jewelry_pawned_loan_lost_when) }}</td>
                    <th width="25%">iv. Interest rate</th>
                    <td width="25%">{{ checkna($assets[0]->jewelry_pawned_loan_lost_interest) }}</td>
                </tr>
            @endif


        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " style="margin-top:5px;" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Others</td>
            </tr>
        </thead>
        <tr>
            <th width="25%">Any other asset not shown above (specify)</th>
            <td width="25%">{{ checkna($assets[0]->fa_other_assets_A) }}</td>
            <th width="25%">Has your family sold any labor in advance during last two years</th>
            <td width="25%">{{ checkna($assets[0]->fa_other_assets_B) }}</td>
        </tr>
        <tr>
            <th width="25%" style="font-weight: bold;">Explain Purpose</td>
            <td width="25%">{{ checkna($assets[0]->fa_other_assets_C) }}</td>
            <td width="25%" style="font-weight: bold;">No of labor days/sold/advanced</td>
            <td width="25%">{{ checkna($assets[0]->fa_other_assets_D) }}</td>
        </tr>
    </table>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">GOALS</td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">

        <tbody>
            <tr style="background-color:#01a9ac">
                <th width="4%" class="tdc">
                    S.No
                </th>
                <th>
                    Name of Goal
                </th>
            </tr>
            @php $i=1; @endphp
            @if (!empty($goals))
                @foreach ($goals as $row)
                    <tr>
                        <td class="tdc">{{ $i++ }}</td>
                        <td>{{ $row->fg_goal }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">AGRICULTURE AND PRODUCTION</td>
            </tr>
        </thead>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">

        <tbody>
            <tr style="background-color:#01a9ac">
                <th class="tdc">S.No</th>
                <th class="tdc">Category</th>
                <th class="tdc">Production Unit </th>
                <th class="tdc">No of Season</th>
                <th class="tdc">Total Production for Current Year</th>
                <th class="tdc">Consumption During the Current Year </th>
                <th class="tdc">Quantity Sold</th>
                <th class="tdc">Price per unit</th>
                <th class="tdc">Total Sale Amount Current Year</th>
                <th class="tdc">Total Sale Amount Forecast for Next Year</th>
            </tr>
            {{-- Agriculture --}}
            <tr>
                <td>1</td>
                <th>
                    Agricultural Production
                </th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $sum = 0;
                $sum_a = 0;
                $sum_an = 0;
            @endphp

            @if (!empty($agriculture))


                @foreach ($agriculture as $res)
                    @php
                        $sum = $sum + ($res->price_per_unit != '' ? $res->price_per_unit : 0);
                        $sum_a = $sum_a + ($res->total_sale_value != '' ? $res->total_sale_value : 0);
                        $sum_an = $sum_an + ($res->total_next != '' ? $res->total_next : 0);
                    @endphp

                    <tr class="tdc">
                        <td></td>
                        <td>{{ $res->crop }}</td>
                        <td>{{ $res->production_quantity_type }}</td>
                        <td>{{ $res->no_of_season }}</td>
                        <td>{{ $res->production_per_year }}</td>
                        <td>{{ $res->consumption }}</td>
                        <td>{{ $res->sold_in_year }}</td>
                        <td>{{ $res->price_per_unit }}</td>
                        <td>{{ $res->total_sale_value }}</td>
                        <td>{{ $res->total_next != '' ? $res->total_next : 0 }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td></td>
                    <th colspan="6">Sub-Total Agriculture</th>
                    <th class="tdc"></th>
                    <th class="tdc">{{ $sum_a }}</th>
                    <th class="tdc">{{ $sum_an }}</th>
                </tr>
            @else
                <tr class="tdc">
                    <td></td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr class="total">
                    <td></td>
                    <th colspan="6">Sub-Total Agriculture</th>
                    <th class="tdc">0</th>
                    <th class="tdc">0</th>
                    <th class="tdc">0</th>
                </tr>
            @endif
            {{-- Horiculture --}}
            <tr>
                <td>2</td>
                <th>
                    Horicultural Production
                </th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            @php
                $sum = 0;
                $sum_h = 0;
                $sum_hn = 0;
            @endphp
            @if (!empty($horticultural))

                @foreach ($horticultural as $data)
                    @php
                        $sum = $sum + $data->price_per_unit;
                        $sum_h = $sum_h + $data->total_sale_value;
                        $sum_hn = $sum_hn + $data->total_next;
                    @endphp

                    <tr class="tdc">

                        <td></td>
                        <td>{{ $data->crop }}</td>
                        <td>{{ $data->production_quantity_type }}</td>
                        <td>{{ $data->no_of_season }}</td>
                        <td>{{ $data->production_per_year }}</td>
                        <td>{{ $data->consumption }}</td>
                        <td>{{ $data->sold_in_year }}</td>
                        <td>{{ $data->price_per_unit }}</td>
                        <td>{{ $data->total_sale_value }}</td>
                        <td>{{ $data->total_next != '' ? $data->total_next : 0 }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td></td>
                    <th colspan="6">Sub-Total Horiculture</th>
                    <th class="tdc"></th>
                    <th class="tdc">{{ $sum_h }}</th>
                    <th class="tdc">{{ $sum_hn }}</th>
                </tr>
            @else
                <tr class="tdc">
                    <td></td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr class="total">
                    <td></td>
                    <th colspan="6">Sub-Total Horiculture</th>
                    <th class="tdc">0</th>
                    <th class="tdc">0</th>
                    <th class="tdc">0</th>
                </tr>
            @endif
            {{-- Livestock --}}
            <tr>
                <td>3</td>
                <th>
                    Livestock Production
                </th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $sum = 0;
                $sum_li = 0;
                $sum_ln = 0;
            @endphp
            @if (!empty($live))

                @foreach ($live as $data)
                    @php
                        $sum = $sum + ($data->price_per_unit != '' ? $data->price_per_unit : 0);
                        $sum_li = $sum_li + ($data->total_sale_value != '' ? $data->total_sale_value : 0);
                        $sum_ln = $sum_ln + ($data->total_next != '' ? $data->total_next : 0);
                    @endphp

                    <tr class="tdc">

                        <td></td>
                        <td>{{ $data->crop }}</td>
                        <td>{{ $data->production_quantity_type }}</td>
                        <td>{{ $data->no_of_season }}</td>
                        <td>{{ $data->production_per_year }}</td>
                        <td>{{ $data->consumption }}</td>
                        <td>{{ $data->sold_in_year }}</td>
                        <td>{{ $data->price_per_unit }}</td>
                        <td>{{ $data->total_sale_value }}</td>
                        <td>{{ $data->total_next != '' ? $data->total_next : 0 }}</td>

                    </tr>
                @endforeach
                <tr class="total">
                    <td></td>
                    <th colspan="6">Sub-Total Livestock</th>
                    <th class="tdc"></th>
                    <th class="tdc">{{ $sum_li }}</th>
                    <th class="tdc">{{ $sum_ln }}</th>
                </tr>
            @else
                <tr class="tdc">
                    <td></td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr class="total">
                    <td></td>
                    <th colspan="6">Sub-Total Livestock</th>
                    <th class="tdc">0</th>
                    <th class="tdc">0</th>
                    <th class="tdc">0</th>
                </tr>
            @endif
            <tr>
                <td></td>
                <th colspan="6">Grand Total </th>
                <td colspan="" class="tdc"></td>
                <th colspan="" class="tdc">{{ $sum_a + $sum_li + $sum_h }}</th>
                <th class="tdc">{{ $sum_an + $sum_ln + $sum_hn }}</th>
            </tr>


        </tbody>


    </table>
    <br>




    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">SAVINGS </td>
            </tr>
        </thead>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="6">Type Of Saving</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Type</th>
                <th>Saving regularly</th>
                <th>Date savings started</th>
                <th>Amount saved per month</th>
                <th>Saved during last 12 months</th>
                <th>Cumulative savings</th>
            </tr>
            @if (!empty($savings_source))
                @php
                    $sum = 0;
                    $sum1 = 0;
                    $sum2 = 0;
                @endphp
                @foreach ($savings_source as $row)
                    @php
                        $sum = $sum + (float) $row['s_total_saving'];
                        $sum1 = $sum1 + (float) $row['s_saving_per_month'];
                        $sum2 = $sum2 + (float) $row['s_last_saved_amt'];
                    @endphp
                    <tr>
                        <th>{{ $row['s_type'] }}</th>
                        <td>{{ $row['s_contribute_regular'] }}</td>
                        <td>{{ $row['s_started_from'] }}</td>
                        <td>{{ $row['s_saving_per_month'] }}</td>
                        <td>{{ $row['s_last_saved_amt'] }}</td>
                        <td>{{ $row['s_total_saving'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <td></td>
                    <td></td>
                    <th>{{ $sum1 }}</th>
                    <th>{{ $sum2 }}</th>
                    <th>{{ $sum }}</th>
                </tr>
            @endif
        </tbody>
    </table>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <tbody>
            <tr>
                <th width="25%">Passbook in position</th>
                <td width="25%">{{ $savings[0]->s_passbook_physically == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%">Passbook Updated</th>
                <td width="25%">{{ $savings[0]->s_passbook_updated == 1 ? 'Yes' : 'No' }}</td>
            </tr>
        </tbody>
    </table>



    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="6">Other Saving Source</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th class="tdc">Loan</th>
                <th class="tdc">Where Fixed Deposit Made</th>
                <th class="tdc">Date of Deposit</th>
                <th class="tdc">Fixed Deposit Term Period</th>
                <th class="tdc">Interest</th>
                <th class="tdc">Amount</th>
            </tr>
            @if (!empty($savings_source_other))
                @php $sum=0; @endphp
                @foreach ($savings_source_other as $row)
                    @php $sum=$sum+(float)$row->other_amount; @endphp
                    <tr>
                        <td class="tdc">{{ $row->other_loan ?? '' }}</td>
                        <td class="tdc">{{ $row->other_where_fixed_deposit_made ?? '' }}</td>
                        <td class="tdc">
                            {{ change_date_month_name_char(str_replace('/', '-', $row->other_date_of_deposit)) ?? '' }}
                        </td>
                        <td class="tdc">{{ $row->other_fixed_deposit_term_period ?? '' }}</td>
                        <td class="tdc">{{ $row->other_interest ?? '' }}</td>
                        <td class="tdc">{{ $row->other_amount ?? '' }}</td>
                    </tr>
                @endforeach

                <tr class="total">
                    <th colspan="5">Total</th>
                    <th class="tdc">{{ $sum ?? 0 }}</th>
                </tr>
            @endif

        </tbody>
    </table>
    <br>
    {{-- LOAN OUTSTANDING --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">FAMILY LOAN OUTSTANDING</td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead class="back-color" style="border-bottom: 1.5px grey solid;">


            <tr>
                <th width="10%">Loan Type</th>
                <th>Loan Amount</th>
                <th>Purpose</th>
                <th>Interest type</th>
                <th>Annual interest rate (%)</th>
                <th>Loan tenure</th>
                <th>Repayment start date</th>
                <th>Last repayment date</th>
                <th>Data collection date</th>
                <th>No of EMIs paid during last 12 months</th>
                <th>Total amount paid during last 12 months</th>
                <th>No of cumulative EMIs repaid</th>
                <th>Cumulative amount paid</th>
                <th>Overdue amount</th>
                <th>Next year loan repayment commitment</th>
            </tr>
        </thead>
        <tbody>
            {{-- SHG LOAN --}}
            <tr>
                <td colspan="15" style="font-weight: bold;">
                    SHG LOAN
                </td>
            </tr>
            @php
                $shg_total = 0;
                $shg_amount = 0;
                $shg_overdue = 0;
                $shg_cumulative = 0;
                $shg_paid = 0;
                
            @endphp
            @if (!empty($Shg_loan))

                @foreach ($Shg_loan as $res)
                    @php
                        $shg_total = $shg_total + $res->lo_next_year;
                        $shg_amount = $shg_amount + $res->lo_principle_amount;
                        $shg_overdue = $shg_overdue + $res->overdue;
                        $shg_cumulative = $shg_cumulative + $res->total_paid_interest;
                        $shg_paid = $shg_paid + $res->current_year_interest;
                        $loan_tenure = '';
                        if ($res->lo_tenure_mode == 0) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                        } elseif ($res->lo_tenure_mode == 1) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                        }
                    @endphp

                    <tr>
                        <th></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $shg_amount }}</td>
                    <th colspan="8"></th>
                    <th>{{ $shg_paid }}</th>
                    <th></th>
                    <td>{{ $shg_cumulative }}</td>
                    <td>{{ $shg_overdue }}</td>
                    <td>{{ $shg_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- MONEY LENDER LOAN --}}
            <tr>
                <td colspan="15" style="font-weight: bold;">
                    MONEY LENDER LOAN
                </td>
            </tr>
            @php
                $money_total = 0;
                $money_amount = 0;
                $money_overdue = 0;
                $money_cumulative = 0;
                $money_paid = 0;
            @endphp
            @if (!empty($money_loan))

                @foreach ($money_loan as $res)
                    @php
                        $money_total = $money_total + $res->lo_next_year;
                        $money_amount = $money_amount + $res->lo_principle_amount;
                        $money_overdue = $money_overdue + $res->overdue;
                        $money_cumulative = $money_cumulative + $res->total_paid_interest;
                        $money_paid = $money_paid + $res->current_year_interest;
                        $loan_tenure = '';
                        if ($res->lo_tenure_mode == 0) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                        } elseif ($res->lo_tenure_mode == 1) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                        }
                    @endphp
                    <tr>
                        <th></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $money_amount }}</td>
                    <th colspan="8"></th>
                    <th>{{ $money_paid }}</th>
                    <th></th>
                    <td>{{ $money_cumulative }}</td>
                    <td>{{ $money_overdue }}</td>
                    <td>{{ $money_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- BANK LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    BANK LOAN
                </td>
            </tr>
            @php
                $bank_total = 0;
                $bank_amount = 0;
                $bank_overdue = 0;
                $bank_cumulative = 0;
                $bank_paid = 0;
            @endphp
            @if (!empty($Bank_loan))

                @foreach ($Bank_loan as $res)
                    @php
                        $bank_total = $bank_total + $res->lo_next_year;
                        $bank_amount = $bank_amount + $res->lo_principle_amount;
                        $bank_overdue = $bank_overdue + $res->overdue;
                        $bank_cumulative = $bank_cumulative + $res->total_paid_interest;
                        $bank_paid = $bank_paid + $res->current_year_interest;
                        $loan_tenure = '';
                        if ($res->lo_tenure_mode == 0) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                        } elseif ($res->lo_tenure_mode == 1) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                        }
                    @endphp
                    <tr>
                        <th></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $bank_amount }}</td>
                    <th colspan="8"></th>
                    <th>{{ $bank_paid }}</th>
                    <th></th>
                    <td>{{ $bank_cumulative }}</td>
                    <td>{{ $bank_overdue }}</td>
                    <td>{{ $bank_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- VI LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    VI LOAN
                </td>
            </tr>
            @php
                $vi_total = 0;
                $vi_amount = 0;
                $vi_overdue = 0;
                $vi_cumulative = 0;
                $vi_paid = 0;
            @endphp
            @if (!empty($vi_loan))

                @foreach ($vi_loan as $res)
                    @php
                        $vi_total = $vi_total + $res->lo_next_year;
                        $vi_amount = $vi_amount + $res->lo_principle_amount;
                        $vi_overdue = $vi_overdue + $res->overdue;
                        $vi_cumulative = $vi_cumulative + $res->total_paid_interest;
                        $vi_paid = $vi_paid + $res->current_year_interest;
                        $loan_tenure = '';
                        if ($res->lo_tenure_mode == 0) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                        } elseif ($res->lo_tenure_mode == 1) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                        }
                    @endphp
                    <tr>
                        <th width="10%"></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $vi_amount }}</td>
                    <th colspan="8"></th>
                    <th>{{ $vi_paid }}</th>
                    <th></th>
                    <td>{{ $vi_cumulative }}</td>
                    <td>{{ $vi_overdue }}</td>
                    <td>{{ $vi_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- CLUSTER LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    CLUSTER LOAN
                </td>
            </tr>
            @php
                $cluster_total = 0;
                $cluster_amount = 0;
                $cluster_overdue = 0;
                $cluster_cumulative = 0;
                $cluster_paid = 0;
            @endphp
            @if (!empty($cluster_loan))

                @foreach ($cluster_loan as $res)
                    @php
                        $cluster_total = $cluster_total + $res->lo_next_year;
                        $cluster_amount = $cluster_amount + $res->lo_principle_amount;
                        $cluster_overdue = $cluster_overdue + $res->overdue;
                        $cluster_cumulative = $cluster_cumulative + $res->total_paid_interest;
                        $cluster_paid = $cluster_paid + $res->current_year_interest;
                        $loan_tenure = '';
                        if ($res->lo_tenure_mode == 0) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                        } elseif ($res->lo_tenure_mode == 1) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                        }
                    @endphp
                    <tr>
                        <th width="10%"></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $cluster_amount }}</td>
                    <th colspan="8"></th>
                    <th>{{ $cluster_paid }}</th>
                    <th></th>
                    <td>{{ $cluster_cumulative }}</td>
                    <td>{{ $cluster_overdue }}</td>
                    <td>{{ $cluster_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- FEDERATION LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    FEDERATION LOAN
                </td>
            </tr>
            @php
                $fed_total = 0;
                $fed_amount = 0;
                $fed_overdue = 0;
                $fed_cumulative = 0;
                $fed_paid = 0;
            @endphp
            @if (!empty($fed_loan))

                @foreach ($fed_loan as $res)
                    @php
                        $fed_total = $fed_total + $res->lo_next_year;
                        $fed_amount = $fed_amount + $res->lo_principle_amount;
                        $fed_overdue = $fed_overdue + $res->overdue;
                        $fed_cumulative = $fed_cumulative + $res->total_paid_interest;
                        $fed_paid = $fed_paid + $res->current_year_interest;
                        $loan_tenure = '';
                        if ($res->lo_tenure_mode == 0) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                        } elseif ($res->lo_tenure_mode == 1) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                        }
                    @endphp
                    <tr>
                        <th width="10%"></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $fed_amount }}</td>
                    <th colspan="8"></th>
                    <th>{{ $fed_paid }}</th>
                    <th></th>
                    <td>{{ $fed_cumulative }}</td>
                    <td>{{ $fed_overdue }}</td>
                    <td>{{ $cluster_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            {{-- OTHER LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    OTHER LOAN
                </td>
            </tr>
            @php
                $other_total = 0;
                $other_amount = 0;
                $other_overdue = 0;
                $other_cumulative = 0;
                $other_paid = 0;
            @endphp
            @if (!empty($other_loan))

                @foreach ($other_loan as $res)
                    @php
                        $other_total = $other_total + $res->lo_next_year;
                        $other_amount = $other_amount + $res->lo_principle_amount;
                        $other_overdue = $other_overdue + $res->overdue;
                        $other_cumulative = $other_cumulative + $res->total_paid_interest;
                        $other_paid = $other_paid + $res->current_year_interest;
                        $loan_tenure = '';
                        if ($res->lo_tenure_mode == 0) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Month';
                        } elseif ($res->lo_tenure_mode == 1) {
                            $loan_tenure = $res->lo_no_of_tenure . '-' . 'Year';
                        }
                    @endphp
                    <tr>
                        <th width="10%"></th>
                        <td>{{ $res->lo_principle_amount }}</td>
                        <td>{{ $res->lo_purpose }}</td>
                        <td>{{ $res->lo_interest_type }}</td>
                        <td>{{ $res->lo_interest_rate }}</td>
                        <td>{{ $loan_tenure }}</td>
                        <td>{{ $res->lo_start_date }}</td>
                        <td>{{ $res->lo_last_Repayment_to_paid }}</td>
                        <td>{{ $res->lo_data_collection_date }}</td>
                        <td>{{ $res->current_year_principal }}</td>
                        <td>{{ $res->current_year_interest }}</td>
                        <td>{{ $res->total_paid_principal }}</td>
                        <td>{{ $res->total_paid_interest }}</td>
                        <td>{{ $res->overdue }}</td>
                        <td>{{ $res->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight:bold">
                    <th width="10%">Sub Total</th>
                    <td>{{ $other_amount }}</td>
                    <th colspan="8"></th>
                    <th>{{ $other_paid }}</th>
                    <th></th>
                    <td>{{ $other_cumulative }}</td>
                    <td>{{ $other_overdue }}</td>
                    <td>{{ $cluster_total }}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endif
            <tr style="font-weight:bold">
                <th width="10%">Grand Total</th>
                <td>{{ $other_amount + $fed_amount + $cluster_amount + $bank_amount + $money_amount + $shg_amount + $vi_amount }}
                </td>
                <td colspan="8"></td>
                </td>
                <td>{{ $other_paid + $fed_paid + $cluster_paid + $bank_paid + $money_paid + $shg_paid + $vi_paid }}
                </td>
                <td></td>
                <td>{{ $other_cumulative + $fed_cumulative + $cluster_cumulative + $bank_cumulative + $money_cumulative + $shg_cumulative + $vi_cumulative }}
                </td>
                <td>{{ $other_overdue + $fed_overdue + $cluster_overdue + $bank_overdue + $money_overdue + $shg_overdue + $vi_overdue }}
                </td>
                <td>{{ $other_total + $fed_total + $cluster_total + $bank_total + $money_total + $shg_total + $vi_total }}
                </td>
            </tr>

        </tbody>
    </table>
    <br>


    {{-- budget --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">FAMILY’S CURRENT AND NEXT YEAR BUDGET </td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="3">Income</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th>Income Source</th>
                <th>Current Year Income</th>
                <th>Next Year Income Forecast</th>
            </tr>
            <tr>
                <td>Agriculture</td>
                <td>{{ !empty($income_this_year[0]->agriculture) ? (int) $income_this_year[0]->agriculture : 0 }}
                </td>
                <td>{{ !empty($income_next_year[0]->agriculture) ? (int) $income_next_year[0]->agriculture : 0 }}
                </td>
            </tr>
            <tr>
                <td>Livestock</td>
                <td>{{ !empty($income_this_year[0]->livestock) ? (int) $income_this_year[0]->livestock : 0 }}</td>
                <td>{{ !empty($income_next_year[0]->livestock) ? (int) $income_next_year[0]->livestock : 0 }}</td>
            </tr>
            <tr>
                <td>Horticulture</td>
                <td>{{ !empty($income_this_year[0]->horticulture) ? (int) $income_this_year[0]->horticulture : 0 }}
                </td>
                <td>{{ !empty($income_next_year[0]->horticulture) ? (int) $income_next_year[0]->horticulture : 0 }}
                </td>
            </tr>
            <tr>
                <td>Fixed Income</td>
                <td>{{ !empty($income_this_year[0]->fixed_income_amount) ? (int) $income_this_year[0]->fixed_income_amount : 0 }}
                </td>
                <td>{{ !empty($income_next_year[0]->fixed_income_amount) ? (int) $income_next_year[0]->fixed_income_amount : 0 }}
                </td>
            </tr>
            <tr>
                <td>Casual Income</td>
                <td>{{ !empty($income_this_year[0]->casual_income_amount) ? (int) $income_this_year[0]->casual_income_amount : 0 }}
                </td>
                <td>{{ !empty($income_next_year[0]->casual_income_amount) ? (int) $income_next_year[0]->casual_income_amount : 0 }}
                </td>
            </tr>
            <tr>
                <td>Sale of Livestock</td>
                <td>{{ !empty($income_this_year[0]->sale_of_livestock) ? (int) $income_this_year[0]->sale_of_livestock : 0 }}
                </td>
                <td>{{ !empty($income_next_year[0]->sale_of_livestock) ? (int) $income_next_year[0]->sale_of_livestock : 0 }}
                </td>
            </tr>
            <tr>
                <td>Trade Income</td>
                <td>{{ !empty($income_this_year[0]->trade_income_amount) ? (int) $income_this_year[0]->trade_income_amount : 0 }}
                </td>
                <td>{{ !empty($income_next_year[0]->trade_income_amount) ? (int) $income_next_year[0]->trade_income_amount : 0 }}
                </td>
            </tr>
            <tr>
                <td>Money Lending</td>
                <td>{{ !empty($income_this_year[0]->money_lending) ? (int) $income_this_year[0]->money_lending : 0 }}
                </td>
                <td>{{ !empty($income_next_year[0]->money_lending) ? (int) $income_next_year[0]->money_lending : 0 }}
                </td>
            </tr>
            <tr>
                <td>Pension Income Monthly</td>
                <td>{{ !empty($income_this_year[0]->pension_income_monthly) ? (int) $income_this_year[0]->pension_income_monthly : 0 }}
                </td>
                <td>{{ !empty($income_next_year[0]->pension_income_monthly) ? (int) $income_next_year[0]->pension_income_monthly : 0 }}
                </td>
            </tr>

            <tr>
                <td>Other Income</td>
                <td>{{ !empty($income_this_year[0]->other_income) ? (int) $income_this_year[0]->other_income : 0 }}
                </td>
                <td>{{ !empty($income_next_year[0]->other_income) ? (int) $income_next_year[0]->other_income : 0 }}
                </td>
            </tr>
            <tr class="total">
                <th>Total</th>
                <th>{{ (int) $income_this_year[0]->e_total_amount }}</th>
                <th>{{ (int) $income_next_year[0]->e_total_amount }}</th>
            </tr>

        </tbody>
    </table>

    <br>
    {{-- challenges --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">CHALLENGES AND ACTION PLAN</td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="2">Top Challenges</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="4%" class="tdc">
                    Sn
                </th>
                <th width="96%">
                    Top Challenges
                </th>
            </tr>
            @php $i=1; @endphp
            @if (!empty($challenges))
                @foreach ($challenges as $row)
                    <tr>
                        <td class="tdc">{{ $i++ }}</td>
                        <td>{{ $row->challenges }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" width="auto">Action Plan</td>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <tbody>
            <tr>
                <th width="4%">S.No</th>
                <th>Action Plan</th>
                @if (!empty($challenges))
                    @foreach ($challenges as $row)
                        <th>{{ $row->challenges }}</th>
                    @endforeach
                @endif
            </tr>
            @if (!empty($challenges_action))
                @foreach ($challenges_action as $key => $row)
                    <tr>
                        <td class="tdc">{{ $key + 1 }}</td>
                        <td>{{ $row['name'] }}</td>
                        @if (!empty($row['ch_actions']))
                            @foreach ($row['ch_actions'] as $val)
                                <td>{{ $val != '' ? $val : 'N/A' }}</td>
                            @endforeach
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="page-break"></div>
    <br>
    {{-- business plan --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">FAMILY BUSINESS PLAN</td>
            </tr>
        </thead>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="3">Basic Details Of Investment Plan</td>

            </tr>
        </thead>
        <thead class="back-color">
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th colspan="2">Type of category</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="tdc">1</th>
                <th>Business Type/category</th>
                <td>{{ $business_investment_plan[0]->type_of_category != '' ? $business_investment_plan[0]->type_of_category : 'N/A' }}
                </td>
            </tr>
            <tr>
                <th class="tdc">A</th>
                <th>Business sector</th>
                <td>{{ $business_investment_plan[0]->type_of_business != '' ? $business_investment_plan[0]->type_of_business : 'N/A' }}
                </td>
            </tr>
            <tr>
                <th class="tdc">2</th>
                <th>New or Existing Business</th>
                <td>{{ $business_investment_plan[0]->is_existing_business_plan != '' ? $business_investment_plan[0]->is_existing_business_plan : 'N/A' }}
                </td>
            </tr>
            @if ($business_investment_plan[0]->is_existing_business_plan == 'New Business')
                <tr>
                    <th class="tdc">A</th>
                    <th>Improving on exixting business or adding to the current
                        business</th>
                    <td>{{ $business_investment_plan[0]->current_business }}
                    </td>
                </tr>
                <tr>
                    <th class="tdc">B</th>
                    <th>Friend/Relative in this new business</th>
                    <td>{{ $business_investment_plan[0]->friend_relative_new_business }}
                    </td>
                </tr>
                <tr>
                    <th class="tdc">C</th>
                    <th>Market demand for this business</th>
                    <td>{{ $business_investment_plan[0]->market_demand_business }}
                    </td>
                </tr>
                <tr>
                    <th class="tdc">D</th>
                    <th>Proposed activity</th>
                    <td>{{ $business_investment_plan[0]->proposed_activity_new }}
                    </td>
                </tr>
                <tr>
                    <th class="tdc">E</th>
                    <th>Identified your competitors</th>
                    <td>{{ $business_investment_plan[0]->have_competitors }}
                    </td>
                </tr>
                @if ($business_investment_plan[0]->have_competitors == 'Yes')
                    <tr>
                        <th class="tdc">F</th>
                        <th>Specify</th>
                        <td>{{ $business_investment_plan[0]->if_yes_specify_competitors }}
                        </td>
                    </tr>
                @endif
            @endif
            @if ($business_investment_plan[0]->is_existing_business_plan == 'Existing')
                <tr>
                    <th class="tdc">A</th>
                    <th>Improving on exixting business or adding to the current
                        business</th>
                    <td>{{ $business_investment_plan[0]->current_business }}
                    </td>
                </tr>
                <tr>
                    <th class="tdc">B</th>
                    <th>No of Years in Existing Business</th>
                    <td>{{ $business_investment_plan[0]->how_long_family_business }}
                    </td>
                </tr>
                <tr>
                    <th class="tdc">C</th>
                    <th>Reason for expnsion</th>
                    <td>{{ $business_investment_plan[0]->reasons_expansion }}
                    </td>
                </tr>
                <tr>
                    <th class="tdc">D</th>
                    <th>Proposed activity</th>
                    <td>{{ $business_investment_plan[0]->proposed_activity_existing }}
                    </td>
                </tr>
                <tr>
                    <th class="tdc">E</th>
                    <th>Do you know where you would be selling your product</th>
                    <td>{{ $business_investment_plan[0]->selling_product }}</td>
                </tr>
                @if ($business_investment_plan[0]->selling_product == 'Yes')
                    <tr>
                        <th class="tdc">F</th>
                        <th>Marketing details</th>
                        <td>{{ $business_investment_plan[0]->if_yes_specify }}
                        </td>
                    </tr>
                @endif
            @endif
            <tr>
                <th class="tdc">3</th>
                <th>Date of Business Plan</th>
                <td>{{ $business_investment_plan[0]->date_of_business_plan != '' ? change_date_month_name_char(str_replace('/', '-', $business_investment_plan[0]->date_of_business_plan)) : 'N/A' }}

                </td>
            </tr>
            <tr>
                <th class="tdc">4</th>
                <th>Family Member responsible for business</th>
                <td>{{ checkna($business_investment_plan[0]->primarily_business) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="page-break"></div>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="5">Total Cost Of The Business (One Time)</td>

            </tr>
        </thead>
        <thead class="back-color">
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>Name of items</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
                $sum = 0;
                $sum1 = 0;
            @endphp
            @if (!empty($fixed_investment))
                @foreach ($fixed_investment as $row)
                    @php
                        $sum += (float) $row->amount;
                        $sum1 += (float) $row->totalamount;
                    @endphp
                    <tr>
                        <td width="25px" class="tdc">{{ $i }}</td>

                        <td>{{ $row->name_of_item }}
                        </td>
                        <td>{{ $row->no_of_quantity }}
                        </td>
                        <td>{{ $row->amount }}
                        </td>
                        <td>{{ $row->totalamount }}</td>
                    </tr>
                    @php $i++ ; @endphp
                @endforeach
                <tr class="total">

                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $sum1 }}</td>
                </tr>
            @endif
        </tbody>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead class="back-color">

            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="5">Yearly Recurrent Cost/Operational Expenses</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="tdc" width="4%">S.No</th>
                <th>Items</th>
                <th class="tdc">Year 1 Expenses</th>
                <th class="tdc">Year 2 Expenses</th>
                <th class="tdc">Year 3 Expenses</th>
            </tr>
            @php
                
                $sn = 1;
                $count = 0;
                $year = ['1st year expenses', '2nd year expenses', '3rd year expenses'];
            @endphp

            @for ($i = 0; $i < count($yearly_expenses); $i++)
                @php
                    
                    $expensesyear = explode(',', $yearly_expenses[$i]->expenses_type);
                    //    print_r($yearly_expenses[$i]->expenses_type);
                    $expense = explode(',', $yearly_expenses[$i]->expenses);
                    
                @endphp
                <tr>
                    <td width="25px" class="tdc">{{ $sn }}</td>
                    <td>{{ $yearly_expenses[$i]->name_of_item }}</td>
                    @foreach ($year as $curyear)
                        <td class="tdc">
                            @php
                                
                                $key = array_search(trim($curyear), $expensesyear, false);
                                if ($key !== false) {
                                    echo $expense[$key];
                                } else {
                                    echo 'N/A';
                                }
                            @endphp
                        </td>
                    @endforeach
                </tr>
                @php
                    $sn++;
                @endphp
            @endfor



            <tr>
                <th></th>
                <th>Total</th>
                <th class="tdc">{{ checkZero($total_1st_year_expenses) }}</th>
                <th class="tdc">{{ checkZero($total_2nd_year_expenses) }}</th>
                <th class="tdc">{{ checkZero($total_3rd_year_expenses) }}</th>
            </tr>
        </tbody>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead class="back-color">

            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="5">Income From Business</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th>S.No</th>
                <th>Items</th>
                <th class="tdc">Year 1 Income</th>
                <th class="tdc">Year 2 Income</th>
                <th class="tdc">Year 3 Income</th>
            </tr>
            @php
                //prd($income_business);
                $sn = 1;
                $count = 0;
                $year = ['1st year income', '2nd year income', '3rd year income'];
            @endphp

            @for ($i = 0; $i < count($income_business); $i++)
                @php
                    
                    $incomeyear = explode(',', $income_business[$i]->income_type);
                    // print_r($income_business[$i]->income_type);
                    $income = explode(',', $income_business[$i]->income);
                    
                @endphp
                <tr>
                    <td width="25px" class="tdc">{{ $sn }}</td>
                    <td>{{ $income_business[$i]->name_of_item }}</td>
                    @foreach ($year as $curyear)
                        <td class="tdc">
                            @php
                                // print_r($incomeyear);
                                $key = array_search(trim($curyear), $incomeyear, false);
                                if ($key !== false) {
                                    echo $income[$key];
                                } else {
                                    echo 'N/A';
                                }
                            @endphp
                        </td>
                    @endforeach
                </tr>
                @php
                    $sn++;
                @endphp
            @endfor


            <tr>
                <th></th>
                <th>Total</th>
                <th class="tdc">{{ checkZero($total_1st_year_income) }}</th>
                <th class="tdc">{{ checkZero($total_2nd_year_income) }}</th>
                <th class="tdc">{{ checkZero($total_3rd_year_income) }}</th>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">PROFIT/LOSS</td>

            </tr>
            <tr>
                <th></th>
                <th class="tdc">Year 1 Expenses</th>
                <th class="tdc">Year 2 Expenses</th>
                <th class="tdc">Year 3 Expenses</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Operational Cost</td>
                <td class="tdc">{{ (float) $first_year_total_salesamts }}</td>
                <td class="tdc">{{ (float) $scnd_year_total_salesamts }}</td>
                <td class="tdc">{{ (float) $trd_year_total_salesamts }}</td>
            </tr>

            <tr>
                <td>Loan Repayment</td>
                <td class="tdc">{{ (float) $first_year_total_loanamts_fyear }}</td>
                <td class="tdc">{{ (float) $scnd_year_total_loanamts_fyear }}</td>
                <td class="tdc">{{ (float) $trd_year_total_loanamts_fyear }}</td>
            </tr>

            <tr>
                <td>Interest Repayment</td>
                <td class="tdc">{{ (float) $first_year_total_interestamts_fyear }}</td>
                <td class="tdc">{{ (float) $scnd_year_total_interestamts_fyear }}</td>
                <td class="tdc">{{ (float) $trd_year_total_interestamts_fyear }}</td>
            </tr>
            <tr style="background-color: orange;color: #1630e2;font-weight: bolder;font-size: medium;">
                <td>Total</td>
                <td class="tdc">{{ (float) $first_year_expansesamt }}</td>
                <td class="tdc">{{ (float) $scnd_year_expansesamt }}</td>
                <td class="tdc">{{ (float) $trd_year_expansesamt }}</td>
            </tr>
            <tr>
                <td>Income</td>
                <td class="tdc">{{ (float) $first_year_total_incomeamts }}</td>
                <td class="tdc">{{ (float) $scnd_year_total_incomeamts }}</td>
                <td class="tdc">{{ (float) $trd_year_total_incomeamts }}</td>
            </tr>
            <tr style="background-color: #b3aeae;color: #1630e2;font-weight: bolder;font-size: medium;">
                <td>Profit/Loss</td>
                <td style="color:{{ $show1 }}; " class="tdc">{{ (float) $tv_1profit }}</td>
                <td style="color:{{ $show2 }}; " class="tdc">{{ (float) $tv_2profit }}</td>
                <td style="color:{{ $show3 }}; " class="tdc">{{ (float) $tv_3profit }}</td>
            </tr>

        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <tr>
            <th>If loss, how will this gap be met</th>
            <td>{{ $business_investment_plan[0]->lossgap_type }}</td>
            <th>Comments</th>
            <td>{{ $business_investment_plan[0]->comments }}</td>
        </tr>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Loan Amount And Duration</td>

            </tr>
            <tr>
                <th class="tdc">Loan Amount</th>
                <th class="tdc">Interest rate %</th>
                <th class="tdc">Interest type</th>
                <th class="tdc">Duration</th>
            </tr>
        </thead>

        <tbody>
            <tr class="tdc">
                <td>{{ checkna((int) $loan_repayment[0]->principal) }}</td>
                @if ($loan_repayment[0]->interest != '')
                    <td>{{ (int) $loan_repayment[0]->interest }}%</td>
                @else
                    <td>0.00%</td>
                @endif
                <td>{{ checkna($loan_repayment[0]->interest_type) }}</td>
                @php
                    $duration = 'N/A';
                    if ($loan_repayment[0]->tenure_mode == 1) {
                        $duration = $loan_repayment[0]->loan_tenure . '-' . 'Year';
                    } elseif ($loan_repayment[0]->tenure_mode == 0) {
                        $duration = $loan_repayment[0]->loan_tenure . '-' . 'Month';
                    }
                @endphp
                <td class="tdc">{{ $duration }}</td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="4">Payment Details </td>

            </tr>
        </thead>
        <thead class="back-color">
            <tr>
                <th></th>
                <th class="tdc">Year 1</th>
                <th class="tdc">Year 2</th>
                <th class="tdc">Year 3</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Interest</td>
                <td class="tdc">
                    {{ $loan_repayment[0]->total_interest_fyear != '' ? $loan_repayment[0]->total_interest_fyear : 0 }}
                </td>
                <td class="tdc">
                    {{ $loan_repayment[0]->total_interest_syear != '' ? $loan_repayment[0]->total_interest_syear : 0 }}
                </td>
                <td class="tdc">
                    {{ $loan_repayment[0]->total_interest_thyear != '' ? $loan_repayment[0]->total_interest_thyear : 0 }}
                </td>
            </tr>
            <tr>
                <td>Total Principle</td>
                <td class="tdc">
                    {{ $loan_repayment[0]->total_loan_fyear != '' ? $loan_repayment[0]->total_loan_fyear : 0 }}</td>
                <td class="tdc">
                    {{ $loan_repayment[0]->total_loan_syear != '' ? $loan_repayment[0]->total_loan_syear : 0 }}</td>
                <td class="tdc">
                    {{ $loan_repayment[0]->total_loan_thyear != '' ? $loan_repayment[0]->total_loan_thyear : 0 }}
                </td>
             </tr>
            <tr>
                @php
                    $total1 = (float) $loan_repayment[0]->total_interest_fyear + (float) $loan_repayment[0]->total_loan_fyear;
                    $total2 = (float) $loan_repayment[0]->total_interest_syear + (float) $loan_repayment[0]->total_loan_syear;
                    $total3 = (float) $loan_repayment[0]->total_interest_thyear + (float) $loan_repayment[0]->total_loan_thyear;
                @endphp
                <td>Payable amount</td>
                <td class="tdc">{{ sprintf('%.1f', $total1) }}
                </td>
                <td class="tdc">{{ sprintf('%.1f', $total2) }}
                </td>
                <td class="tdc">{{ sprintf('%.1f', $total3) }}
                </td>
            </tr>
        </tbody>

    </table>

    <br>

    {{-- Family/SHG Member Commitment --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">FAMILY/SHG MEMBER COMMITMENT</td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">

        <thead class="back-color">
            <tr style="background-color:#01a9ac">
                <th width="4%" class="tdc">S.No</th>
                <th width="48%">Question</th>
                <th width="48%">Answers</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="tdc">1</th>
                <th>Does member attend meetings regularly?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_meeting_yes_no) }}</td>
            </tr>

            <tr>
                <th class="tdc">2</th>
                <th>No. of meetings attended during last 12 months ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_meeting_attend) }}</td>
            </tr>

            <tr>
                <th class="tdc">3</th>
                <th>Reasons for not attending some meetings ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_metting_not_attend) }}</td>
            </tr>

            <tr>
                <th class="tdc">4</th>
                <th>What is her understanding of rules of her group ?</th>
                <td>
                    <ul>
                        <li>
                            @if ($shgmember_commitment[0]->yo_frequency_metting == 1)
                                @php echo "Frequency of meetting"; @endphp
                            @endif
                        </li>
                        <li>
                            @if ($shgmember_commitment[0]->yo_interest_rates == 1)
                                @php echo "Interest Rate "; @endphp
                            @endif
                        </li>

                        <li>
                            @if ($shgmember_commitment[0]->yo_receive_loan == 1)
                                @php echo "Receive a Loan"; @endphp
                            @endif
                        </li>

                        <li>
                            @if ($shgmember_commitment[0]->yo_max_loan_amount == 1)
                                @php echo "Maximum Loan Amount"; @endphp
                            @endif
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <th class="tdc">5</th>
                <th>If the member is aware of all categories ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_member_aware_categories) }}</td>
            </tr>
            <tr>
                <th class="tdc">6</th>
                <th>Does member and family participate in the community development
                    activities ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_somewhat_yes_no) }}</td>
            </tr>

            <tr>
                <th class="tdc">7</th>
                <th>Specify which activities member has participated during last 12
                    months ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_family_member_participate) }}
                </td>
            </tr>
            <tr>
                <th class="tdc">8</th>
                <th>Number of activities member has participates ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_family_member_participate_no_of_activity) }}
                </td>
            </tr>



        </tbody>

    </table>
    <div class="page-break"></div>
    <br>

    {{-- observations --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:black;color:white">OBSERVATIONS</td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="3">Key Highlights And Observations About The Family
                </td>

            </tr>
        </thead>
        <thead class="back-color">
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th width="48%">1st Visit Observation</th>
                <th width="48%">Answers</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="tdc">1</th>
                <th>Who participated in the family?</th>
                <td colspan="2">
                    {{ $observation_this_year_member[0]->participate_family }}
                </td>
            </tr>
            <tr>
                <th class="tdc">2</th>
                <th>Was there active participation in the discussion? Who was
                    contributing mostly?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_was }}</td>
            </tr>
            @if (!empty($observation_this_year[0]->fdip_observation_who_was))
                <tr>
                    <th scope="row">2a</th>
                    <th>Who was contributing mostly</th>
                    <td>{{ $observation_this_year[0]->fdip_observation_who_was }}</td>
                </tr>
            @endif
            @if (!empty($observation_this_year[0]->fdip_observation_describe))
                <tr>
                    <th scope="row">2b</th>
                    <th>Describe it</th>
                    <td>{{ $observation_this_year[0]->fdip_observation_describe }}</td>
                </tr>
            @endif
            <tr>
                <th class="tdc">3</th>
                <th>What is their past life?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_past_life }}</td>
            </tr>
            <tr>
                <th class="tdc">4</th>
                <th>What is their daily tradition? What are the things they life or
                    enjoy and what are the challenges they face on a daily basis?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_daily }}</td>
            </tr>
            <tr>
                <td class="tdc">5</td>
                <th>What are the things the family is proud of – their key achievements?
                </th>
                <td>
                    <ol type="A">
                        @if ($observation_this_year[0]->fdip_observation_highlights_a != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_a }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_b != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_b }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_c != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_c }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_d != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_d }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_e != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_e }}
                            </li>
                        @endif
                    </ol>
                </td>
            </tr>
            <tr>
                <td class="tdc">6</td>
                <th>Does this family have some vulnerabilities or potential risks that
                    need to be highlighted?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_vulnerabilities }}
                    <ol type="A">
                        @if ($observation_this_year[0]->fdip_observation_highlights_a_6 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_a_6 }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_b_6 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_b_6 }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_c_6 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_c_6 }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_d_6 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_d_6 }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_e_6 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_e_6 }}
                            </li>
                        @endif
                    </ol>
                </td>
            </tr>



            <tr>
                <td class="tdc">7</td>
                <th>Does their SHG help them?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_how }}</td>
            </tr>
            <tr>
                <td class="tdc">8</td>
                <th>Was there agreement among family members to address their
                    challenges?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_agreement }}</td>
            </tr>
            <tr>
                <td class="tdc">9</td>
                <th>What makes this family unique </th>
                <td>
                    <ol type="A">
                        @if ($observation_this_year[0]->fdip_observation_highlights_a_9 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_a_9 }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_b_9 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_b_9 }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_c_9 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_c_9 }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_d_9 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_d_9 }}
                            </li>
                        @endif

                        @if ($observation_this_year[0]->fdip_observation_highlights_e_9 != '')
                            <li>{{ $observation_this_year[0]->fdip_observation_highlights_e_9 }}
                            </li>
                        @endif
                    </ol>
                </td>
            </tr>
        </tbody>

    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">

        <thead class="back-color">
            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th width="48%">2nd Visit Observation</th>
                <th width="48%">Answers</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="tdc">1</th>
                <th>Has family revised challenges or actions since the last
                    discussion?</th>
                <td colspan="2">
                    {{ $observation_next_year[0]->fdip_observation_next_has }}
                    @if ($observation_next_year[0]->fdip_observation_next_describe != '')
                        <ol type="A">
                            <li>{{ $observation_next_year[0]->fdip_observation_next_describe }}
                            </li>
                        </ol>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="tdc">2</th>
                <th>Has family done some preparation work for planning of the next
                    year
                    production and budget?</th>
                <td>{{ $observation_next_year[0]->fdip_observation_next_planning }}
                    @if ($observation_next_year[0]->fdip_observation_next_describe2 != '')
                        <ol type="A">
                            <li>{{ $observation_next_year[0]->fdip_observation_next_describe2 }}
                            </li>
                        </ol>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="tdc">3</th>
                <th>Has family prepared their business plan? Describe key highlights
                    of
                    the business plan?</th>
                <td>{{ $observation_next_year[0]->fdip_observation_next_business }}
                    <ol type="A">
                        @if ($observation_next_year[0]->fdip_observation_next_highlight != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_highlight }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_highlight_two != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_highlight_two }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_highlight_three != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_highlight_three }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_highlight_four != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_highlight_four }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_highlight_five != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_highlight_five }}
                            </li>
                        @endif
                    </ol>
                </td>
            </tr>

            <tr>
                <td class="tdc">4</td>
                <th>What makes this family deserving to receive a loan?</th>
                <td>
                    <ol type="A">
                        @if ($observation_next_year[0]->fdip_observation_next_what != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_what }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_what_b_4 != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_what_b_4 }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_what_c_4 != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_what_c_4 }}
                            </li>
                        @endif
                    </ol>
                </td>
            </tr>
            <tr>
                <td class="tdc">5</td>
                <th>What do you think wold be biggest risk in lending to them?</th>
                <td>
                    <ol type="A">
                        @if ($observation_next_year[0]->fdip_observation_next_risk != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_risk }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_risk_b_5 != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_risk_b_5 }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_risk_c_5 != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_risk_c_5 }}
                            </li>
                        @endif
                    </ol>
                </td>
            </tr>
            <tr>
                <td class="tdc">6</td>
                <th>How would VI loan improve their life</th>
                <td>
                    <ol type="A">
                        @if ($observation_next_year[0]->fdip_observation_next_how != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_how }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_how_b_6 != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_how_b_6 }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_how_c_6 != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_how_c_6 }}
                            </li>
                        @endif
                    </ol>
                </td>
            </tr>
            <tr>
                <td class="tdc">7</td>
                <th>Did you observe any change in the family from the 1st visit?, if
                    yes
                    describe</td>
                <td>{{ $observation_next_year[0]->fdip_observation_next_did }}
                    <ol type="A">

                        @if ($observation_next_year[0]->fdip_observation_next_any != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_any }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_any_two != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_any_two }}
                            </li>
                        @endif

                        @if ($observation_next_year[0]->fdip_observation_next_any_three != '')
                            <li>{{ $observation_next_year[0]->fdip_observation_next_any_three }}
                            </li>
                        @endif
                    </ol>
                    </th>
            </tr>

        </tbody>

    </table>
    <br>
    {{-- Report card --}}
    <table class="table table-bordered table-stripped table1 page-break" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#01a9ac" colspan="2">Family Report Card </td>
            </tr>
        </thead>


    </table>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead class="back-color">
            <tr>
                <th width="500px">FDP Indicators</th>
                <td colspan="4"></td>
                {{-- <th colspan="" style="text-align:center;"> Actual Score </th>
            <th colspan="" style="text-align:center;"> Expected Score</th> --}}
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1 Family Budget</td>
                <td style="background-color: green;width:50px;text-align:center;">
                    @if ($score >= 90)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;text-align:center;">
                    @if ($score >= 75 && $score <= 89)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: lightgrey;width:50px;text-align:center;">
                    @if ($score >= 60 && $score <= 74)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: red;width:50px;text-align:center;">
                    @if ($score <= 59)
                        <span class="checkmark"></span>
                    @endif
                </td>
                {{-- <td style="text-align: center;">{{$total_cy1}}</td>
            <td style="text-align: center;">20</td> --}}
                {{-- <td>{{round($score)}}</td> --}}
            </tr>
            <tr>
                <td>2 Family Saving</td>
                <td style="background-color: green;width:50px;text-align:center;">
                    @if ($score1 >= 90)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;text-align:center;">
                    @if ($score1 >= 75 && $score1 <= 89)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: lightgrey;width:50px;text-align:center;">
                    @if ($score1 >= 60 && $score1 <= 74)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: red;width:50px;text-align:center;">
                    @if ($score1 <= 59)
                        <span class="checkmark"></span>
                    @endif
                </td>
                {{-- <td style="text-align: center;">{{$total_cy2}}</td>
            <td style="text-align: center;">25</td> --}}
                {{-- <td>{{round($score1)}}</td> --}}
            </tr>
            <tr>
                <td>3 Family Credit History</td>
                <td style="background-color: green;width:50px;text-align:center;">
                    @if ($score2 >= 90)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;text-align:center;">
                    @if ($score2 >= 75 && $score2 <= 89)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: lightgrey;width:50px;text-align:center;">
                    @if ($score2 >= 60 && $score2 <= 74)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: red;width:50px;text-align:center;">
                    @if ($score2 <= 59)
                        <span class="checkmark"></span>
                    @endif
                </td>
                {{-- <td style="text-align: center;">{{$total_cy3}}</td>
            <td style="text-align: center;">40</td> --}}
                {{-- <td>{{round($score2)}}</td> --}}
            </tr>
            <tr>
                <td>4 Family Commitment to Group Rules</td>
                <td style="background-color: green;width:50px;text-align:center;">
                    @if ($score3 >= 90)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: yellow;width:50px;text-align:center;">
                    @if ($score3 >= 75 && $score3 <= 89)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: lightgrey;width:50px;text-align:center;">
                    @if ($score3 >= 60 && $score3 <= 74)
                        <span class="checkmark"></span>
                    @endif
                </td>
                <td style="background-color: red;width:50px;text-align:center;">
                    @if ($score3 <= 59)
                        <span class="checkmark"></span>
                    @endif
                </td>
                {{-- <td style="text-align: center;">{{$total_ny4}}</td>
            <td style="text-align: center;">15</td> --}}
                {{-- <td>{{round($score3)}}</td> --}}
            </tr>
            <tr>
                @php
                    if ($grand_total_cy >= 90) {
                        $color = 'green';
                    }
                    if ($grand_total_cy >= 75 && $grand_total_cy <= 89) {
                        $color = 'yellow';
                    }
                    if ($grand_total_cy >= 60 && $grand_total_cy <= 74) {
                        $color = 'lightgrey';
                    }
                    if ($grand_total_cy <= 59) {
                        $color = 'red';
                    }
                    
                @endphp
                <th width="500px">Total Score</th>
                <td colspan="4"
                    style="background-color:{{ $color }};text-align:center;font-weight:bold;font-size:20px;">
                    {{ $grand_total_cy }}</td>


            </tr>
        </tbody>
    </table>




</body>

</html>
