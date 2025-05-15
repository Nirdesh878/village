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
        background-color: #cea38b;
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
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>BASIC INFORMATION</u></td>
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
                @php
                    $GenderData = getMstCommonData(1,$family_profile[0]->fp_gender  ?? null);
                @endphp
                <td>{{ $GenderData[0]->common_values ?? 'N/A' }}</td>
                <th width="25%">Caste</th>
                @php
                    $CasteData = getMstCommonData(2,$family_profile[0]->fp_caste ?? null);
                @endphp
                <td>{{ $CasteData[0]->common_values ?? 'N/A' }}</td>
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
                <td width="25%">{{ account($family_profile[0]->fp_account) }}</td>
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
                    @php
                        $FemaleHeadedData = getMstCommonData(3,$family_profile[0]->fp_female_headed ?? null);
                    @endphp
                    {{ $FemaleHeadedData[0]->common_values ?? 'N/A' }}
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
                <td style="background-color:#cea38b" colspan="4">Family Members</td>

            </tr>
        </thead>
        <thead>
            <tr>
                <th width="25%" style="text-align: left;">SHG Member And Spouse</th>
                <td width="25%">{{ (int) $family_profile[0]->shg_member_spouse }}</td>
                <th width="25%" style="text-align: left;">Children </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_children_no }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Daughter In Law </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_doughterinlay_no }}</td>
                <th width="25%" style="text-align: left;">Parent In Laws </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_parentinlaws_no }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Family Member Over 60year</th>
                <td width="25%">{{ $family_profile[0]->fp_family_mamber_over_60year }}</td>
                <th width="25%" style="text-align: left;">No of Differently abled family members</th>
                <td width="25%">{{ $family_profile[0]->fp_family_mamber_medication }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Vulnerable People</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_vulnerable_people }}</td>
                <th width="25%" style="text-align: left;">Married Children Live In</th>
                <td width="25%">
                    {{ $family_profile[0]->fp_married_children_live_in != '' ? $family_profile[0]->fp_married_children_live_in : 0 }}
                </td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Others </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_others_no }}</td>
                <th width="25%" style="text-align: left;">Total Family Members </th>
                <td width="25%">{{ (int) (int) $family_profile[0]->fp_family_mambers_no }}</td>
            </tr>

        </thead>

    </table>
    <div class="page-break"></div>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">Children Profile</td>

            </tr>
        </thead>
        <thead>
            <tr>
                <th width="25%" style="text-align: left;">Non School Children </th>
                <td width="25%">{{ (int) $family_profile[0]->non_school_children_no }}</td>
                <!-- <th width="25%" style="text-align: left;">Employed Children</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_employed }}</td> -->
                <th width="25%" style="text-align: left;">Total Childrens</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_total_children }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Children In Primary School</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_children_no_in_primary_school }}</td>
                <th width="25%" style="text-align: left;">Children In Higher Secondary </th>
                <td width="25%">{{ (int) $family_profile[0]->fp_children_no_in_secondary_higher }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Children In College</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_children_no_in_college }}</td>
                <th width="25%" style="text-align: left;">Studing at Home</th>
                <td width="25%">{{ (int) $family_profile[0]->studiedat_home }}</td>
            </tr>
            <!-- <tr>
                <th width="25%" style="text-align: left;">Total Childrens</th>
                <td width="25%">{{ (int) $family_profile[0]->fp_total_children }}</td>
                <td></td>
                <td></td>
            </tr> -->


        </thead>

    </table>
    <br>
    {{-- family memebers info --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="12">Family Member Info</td>

            </tr>
            <tr>
                <th>Name</th>
                <th>DOB</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Relation</th>
                <th>Education</th>
                <th>Marital Status</th>
                <th>Differently Abled</th>
                <th>Earning Income</th>
                <th>Earning Description</th>
                <th>Malnutritions</th>
                <th>Vulnerable</th>
            </tr>
        </thead>
        <thead>
            @foreach ($family_member_info as $res)
            @php
                $MGenderData = getMstCommonData(1,$res->gender  ?? null);
            @endphp
            @php
                $MRelationData = getMstCommonData(5,$res->relation  ?? null);
            @endphp
            @php
                $MeducationData = getMstCommonData(6,$res->education  ?? null);
            @endphp
            @php
                $MaritalStatusData = getMstCommonData(35,$res->maritalStatus  ?? null);
            @endphp
             @php
                $malnutritionsData = getMstCommonData(3,$res->malnutritions  ?? null);
            @endphp
            @php
                $differentlyAbledData = getMstCommonData(3,$res->differentlyAbled  ?? null);
            @endphp
            @php
                $vulnerableData = getMstCommonData(3,$res->vulnerable  ?? null);
            @endphp
                <tr>
                    <td>{{ $res->name }}</td>
                    <td>{{ $res->dob }}</td>
                    <td>{{ $res->age }}</td>
                    <td>{{ $MGenderData[0]->common_values ?? 'N/A' }}</td>
                    <td>{{ $MRelationData[0]->common_values ?? 'N/A' }}</td>
                    <td>{{ $MeducationData[0]->common_values ?? 'N/A' }}</td>
                    <td>{{ $MaritalStatusData[0]->common_values ?? 'N/A' }}</td>
                    <td>{{ $differentlyAbledData[0]->common_values ?? 'N/A' }}</td>
                    <td>{{ $res->pension != 0 ? 'Yes' : 'No' }}</td>
                    <td>{{ $res->earning_description }}</td>
                    <td>{{ $malnutritionsData[0]->common_values ?? 'N/A' }}</td>
                    <td>{{ $vulnerableData[0]->common_values ?? 'N/A' }}</td>
                </tr>
            @endforeach



        </thead>

    </table>
    <br>
    {{-- govt. program --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="3">Govt. Livelihood Programs</td>

            </tr>
            <tr>
                <th width="40%" style="text-align: left;">Are you aware of Govt. Livelihood Programs?</th>
                @php
                    $Gov_liveilhoodData = getMstCommonData(3,$family_profile[0]->gov_liveilhood_program   ?? null);
                @endphp
                <th>{{ $Gov_liveilhoodData[0]->common_values ?? 'N/A' }}</th>
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
                <td style="background-color:#cea38b" colspan="4">Education</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan=2 style="text-align: left;">A. Family not educated up to at least six years of schooling?</th>
                @php
                    $NotEducatedData = getMstCommonData(3,$family_profile[0]->family_member_not_educated   ?? null);
                @endphp
                <td colspan=2>{{ $NotEducatedData[0]->common_values ?? 'N/A' }}</td>

            </tr>
            @if ($family_profile[0]->family_member_not_educated == 2)
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
                <th colspan=2 style="text-align: left;">B. Any children or adolescents up to age of 13 away from school or deopped out?</th>
                @php
                    $childrenData = getMstCommonData(3,$family_profile[0]->children_or_adolescents_upto_age   ?? null);
                @endphp
                <td colspan=2>{{ $childrenData[0]->common_values ?? 'N/A' }}</td>

            </tr>
            @if ($family_profile[0]->children_or_adolescents_upto_age == 1)
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
                <td style="background-color:#cea38b" colspan="4">Nutrition and Mortality</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan=2 style="text-align: left;">A. Family member have access to all three meals on a daily basis?</th>
                @php
                    $NutritionMoralityData = getMstCommonData(3,$family_profile[0]->aNutritionMortality   ?? null);
                @endphp
                <td colspan=2>{{ $NutritionMoralityData[0]->common_values ?? 'N/A' }}</td>

            </tr>
            @if ($family_profile[0]->aNutritionMortality == 2)
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
                <th colspan=2 style="text-align: left;">B.Does any member suffer due to malnutrition?</th>
                @php
                    $bNutritionMoralityData = getMstCommonData(3,$family_profile[0]->bNutritionMortality   ?? null);
                @endphp
                <td colspan=2>{{ $bNutritionMoralityData[0]->common_values ?? 'N/A' }}</td>

            </tr>
            @if ($family_profile[0]->bNutritionMortality == 1)
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
                <th colspan=2 style="text-align: left;">C.Does any one of the children/adolescents or adults appear to be undernourished
                    (stunted,wasted,under-weight)?</th>
                    @php
                        $cNutritionMoralityData = getMstCommonData(3,$family_profile[0]->cNutritionMortality   ?? null);
                    @endphp
                <td colspan=2>{{ $cNutritionMoralityData[0]->common_values ?? 'N/A' }}</td>

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
                <th colspan=2 style="text-align: left;">D.Have any children or adolescents died below age 18?</th>
                @php
                    $dNutritionMoralityData = getMstCommonData(3,$family_profile[0]->dNutritionMortality   ?? null);
                @endphp
                <td colspan=2>{{ $dNutritionMoralityData[0]->common_values ?? 'N/A' }}</td>

            </tr>
            @if ($family_profile[0]->dNutritionMortality == 1)
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
                <td style="background-color:#cea38b" colspan="2">Standard of Living</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" style="text-align: left;">A.Sanitation Does the family</th>
                @php
                    $SanitizationData = getMstCommonData(8,$family_profile[0]->sanitation   ?? null);
                @endphp 
                <td width="25%">{{ $SanitizationData[0]->common_values ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">B.Electricity Does the house they live in have electercity?</th>
                @php
                    $ElectricityData = getMstCommonData(3,$family_profile[0]->sElectricity   ?? null);
                @endphp
                <td width="25%">{{ $ElectricityData[0]->common_values ?? 'N/A' }}</td>

            </tr>
            <tr>
                <th width="25%" style="text-align: left;">C.Drinking water Do they fetch water for drinking from</th>
                @php
                    $DrinkingWaterData = getMstCommonData(9,$family_profile[0]->sDrinkingWater   ?? null);
                @endphp
                <td width="25%">{{ $DrinkingWaterData[0]->common_values ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">D.Cooking Fuel What is the method used by family</th>
                @php
                    $CookingFuelData = getMstCommonData(10,$family_profile[0]->sCookingFuel   ?? null);
                @endphp 
                <td width="25%">{{ $CookingFuelData[0]->common_values ?? 'N/A' }}</td>
            </tr>




        </tbody>


    </table>
    <br>
    {{-- Health status --}}
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">Health Status</td>

            </tr>
        </thead>
        <tbody>

            <tr>
                <th colspan="2" style="text-align: left;">Health Issues Any member in the house having illness during last 2 years</th>
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
                <td style="background-color:#cea38b" colspan="4">Family Earning</td>

            </tr>
        </thead>
        <thead>
            <!-- <tr>
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
            </tr> -->
            <tr>

                <th width="25%" style="text-align: left;">Total Members Earning Income</th>
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
                <td style="background-color:#cea38b" colspan="4">Family Migration</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" style="text-align: left;">Has family migrated from other place during last 2 years/ Y/No </th>
                @php
                    $MigratedData = getMstCommonData(12,$family_profile[0]->fp_family_migrated   ?? null);
                @endphp
                <td width="25%">{{ $MigratedData[0]->common_values ?? 'N/A' }}</td>
                <th width="25%" style="text-align: left;">Member Reason Of Migration</th>
                <td width="25%">{{ checkna($family_profile[0]->fp_family_reason_of_migration) }}</td>

            </tr>
        </tbody>
    </table>

    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">Family Wealth Ranking </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" style="text-align: left;">Wealth Rank</th>
                @php
                    $WealthData = getMstCommonData(7,$family_profile[0]->fp_wealth_rank ?? null);
                @endphp
                <td width="25%">{{ $WealthData[0]->common_values ?? 'N/A' }}</td>
                <th width="25%"></th>
                <td width="25%"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>FAMILY ASSETS</u></td>
            </tr>
        </thead>
    </table>
    <br>


    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">Land</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" style="text-align: left;">Land Size</th>
                <td width="25%">{{ checkna($assets[0]->fa_land_type) }}</td>
                <th width="25%" style="text-align: left;">Land Cultivated By Family</th>
                <td width="25%">
                    {{ $assets[0]->fa_land_cultivated != '' ? number_format($assets[0]->fa_land_cultivated,2) : '0.00' }}
                </td>

            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Land Mortgaged</th>
                <td width="25%">
                    {{ $assets[0]->fa_land_mortgaged != '' ? $assets[0]->fa_land_mortgaged : 'N/A' }}
                </td>

                <th width="25%" style="text-align: left;">Land Owned but cultivated as sharecroping</th>
                <td width="25%">
                    {{ $assets[0]->fa_land_owned != '' ? number_format($assets[0]->fa_land_owned,2) : '0.00' }}
                </td>
            </tr>
            @if($assets[0]->fa_land_mortgaged !='No')
            <tr>

                <th width="25%" style="text-align: left;">Date of loss mortgage</th>
                <td width="25%">{{ change_date_new($assets[0]->fa_date_of_mortgage)}}
                </td>

                <th width="25%" style="text-align: left;">How much land</th>
                <td width="25%">
                    {{ $assets[0]->fa_mortagged_how_much_land != '' ? number_format($assets[0]->fa_mortagged_how_much_land) : '0.00' }}
                </td>

            </tr>
            @endif
            <tr>

                <th width="25%" style="text-align: left;">Land Not Owned but cultivated as sharecroping</th>
                <td width="25%"> {{ $assets[0]->fa_land_not_owned != '' ? number_format($assets[0]->fa_land_not_owned,2) : '0.00' }}
                </td>
                <th width="25%" style="text-align: left;">Total Land Owned and Cultivated by Family</th>
                <td width="25%">
                    {{ $assets[0]->fa_total_land_owned != '' ? number_format($assets[0]->fa_total_land_owned,2) : '0.00' }}
                </td>
            </tr>

        </tbody>
    </table>
    <div class="page-break"></div>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="2">Livestock</td>

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
                        <td width="50%" style="text-align: center;">{{ checkna($row->animal_Types) }}</td>
                        <td width="50%" style="text-align: center;">{{ $row->no_of_animals != '' ? $row->no_of_animals : 0 }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">Home Gadgets/Equipment</td>

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
                <th width="25%" style="text-align: left;">Tv color</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_tvcolor == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%" style="text-align: left;">Tv black/white</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_tvblackwhite == 1 ? 'Yes' : 'No' }}</td>

            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Air conditioners</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_airconditioners == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%" style="text-align: left;">Coolers</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_coolers == 1 ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Sewingmachines</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_sewingmachines == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%" style="text-align: left;">Smartphone</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->fa_smartphone == 1 ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Wet Grinder</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->wet_grinder == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%" style="text-align: left;">Mixi</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->mixi == 1 ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Washing Machines</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->washing_machines == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%" style="text-align: left;">Computer</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->computer == 1 ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Refrigerator</th>
                <td width="25%">{{ (int) $assets_gadgets[0]->refrigerator == 1 ? 'Yes' : 'No' }}</td>
                <th width="25%" style="text-align: left;">Other</th>
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
                <td style="background-color:#cea38b" colspan="4">Housing Unit/Others Assets</td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" style="text-align: left;">House Ownership</th>
                <td width="25%">{{ checkna($assets[0]->house_ownership) }}</td>
                <th width="25%" style="text-align: left;">Pacca Kaccha House</th>
                <td width="25%">{{ checkna($assets[0]->fa_Pacca_Kaccha_house) }}</td>

            </tr>
            <tr>
                <th width="25%" style="text-align: left;">Animalsheds</th>
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
                <td style="background-color: #cea38b;" colspan="2">Vehicle</td>

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
                        <td width="50%" style="text-align: center;">{{ checkna($row->vehicle_Types) }}</td>
                        <td width="50%" style="text-align: center;">{{ $row->no_of_vehicle != '' ? $row->no_of_vehicle : 0 }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color: #cea38b;" colspan="2">Machinery</td>

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
                        <td width="50%" style="text-align: center;">{{ checkna($row->machinery_Types) }}</td>
                        <td width="50%" style="text-align: center;">{{ $row->no_of_machinery != '' ? $row->no_of_machinery : 0 }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <br>



    <table class="table table-bordered table-stripped table1 " style="margin-top:5px;" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="4">Personal Items/Others</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" style="text-align: left;">A. Does the family own any jewelry</th>
                <td width="25%">{{ checkna($assets[0]->fa_jewelry_yes_no) }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th width="25%" style="text-align: left;">B. Jewelry Pawned to take Loan </th>
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
                <th width="25%" style="text-align: left;">C. Any jewelry pawned to take loan got lost</th>
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
                <td style="background-color:#cea38b" colspan="4">Others</td>
            </tr>
        </thead>
        <tr>
            <th width="25%" style="text-align: left;">Any other asset not shown above (specify)</th>
            <td width="25%">{{ checkna($assets[0]->fa_other_assets_A) }}</td>
            <th width="25%" style="text-align: left;">Has your family sold any labor in advance during last two years</th>
            <td width="25%">{{ checkna($assets[0]->fa_other_assets_B) }}</td>
        </tr>
        <tr>
            <th width="25%" style="font-weight: bold;">Explain Purpose</td>
            <td width="25%" style="text-align: left;">{{ checkna($assets[0]->fa_other_assets_C) }}</td>
            <td width="25%" style="font-weight: bold;">No of labor days/sold/advanced</td>
            <td width="25%">{{ checkna($assets[0]->fa_other_assets_D) }}</td>
        </tr>
    </table>
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>GOALS</u></td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">

        <tbody>
            <tr style="background-color:#cea38b">
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
    <table class="table table1 " cellspacing="0" style="text-align: left;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>AGRICULTURE AND PRODUCTION</u></td>
            </tr>
        </thead>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">

        <tbody>
            <tr style="background-color:#cea38b">
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




    <table class="table table1 " cellspacing="0" style="border:none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>SAVINGS</u></td>
            </tr>
        </thead>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="6">Type Of Saving</td>
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
                <td style="background-color:#cea38b" colspan="7">Other Saving Source</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th class="tdc">Loan</th>
                <th class="tdc">Where Fixed Deposit Made</th>
                <th class="tdc">Date of Deposit</th>
                <th class="tdc">Fixed Deposit Term Period</th>
                <th class="tdc">Interest</th>
                <th class="tdc">Saved During Last 12 Months</th>
                <th class="tdc">Amount</th>
            </tr>
            @if (!empty($savings_source_other))
                @php $sum=0; @endphp
                @foreach ($savings_source_other as $row)
                    @php $sum=$sum+(float)$row->other_amount; @endphp
                    <tr>
                        <td class="tdc">{{ $row->other_loan ?? '' }}</td>
                        <td class="tdc">{{ $row->other_where_fixed_deposit_made ?? '' }}</td>
                        <td class="tdc">{{ change_date_month_name_char(str_replace('/','-',$row->other_date_of_deposit)) ?? '' }}</td>
                        <td class="tdc">{{ $row->other_fixed_deposit_term_period ?? '' }}</td>
                        <td class="tdc">{{ $row->other_interest ?? '' }}</td>
                        <td class="tdc">{{ $row->last_saved_amt ?? '' }}</td>
                        <td class="tdc">{{ $row->other_amount ?? '' }}</td>
                    </tr>
                @endforeach

                <tr class="total">
                    <th colspan="6">Total</th>
                    <th class="tdc">{{ $sum ?? 0 }}</th>
                </tr>
            @endif

        </tbody>
    </table>
    <br>
    {{-- LOAN OUTSTANDING --}}
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>FAMILY LOAN OUTSTANDING</u></td>
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
                        $shg_total = $shg_total + checkZero($res->lo_next_year);
                        $shg_amount = $shg_amount + checkZero($res->lo_principle_amount);
                        $shg_overdue = $shg_overdue + checkZero($res->overdue);
                        $shg_cumulative = $shg_cumulative + checkZero($res->total_paid_interest);
                        $shg_paid = $shg_paid + checkZero($res->current_year_interest);
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
                        $money_total = $money_total + checkZero($res->lo_next_year);
                        $money_amount = $money_amount + checkZero($res->lo_principle_amount);
                        $money_overdue = $money_overdue + checkZero($res->overdue);
                        $money_cumulative = $money_cumulative + checkZero($res->total_paid_interest);
                        $money_paid = $money_paid + checkZero($res->current_year_interest);
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
                        $bank_total = $bank_total + checkZero($res->lo_next_year);
                        $bank_amount = $bank_amount + checkZero($res->lo_principle_amount);
                        $bank_overdue = $bank_overdue + checkZero($res->overdue);
                        $bank_cumulative = $bank_cumulative + checkZero($res->total_paid_interest);
                        $bank_paid = $bank_paid + checkZero($res->current_year_interest);
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
            {{-- MFI LOAN --}}
            <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    MFI LOAN
                </td>
            </tr>
            @php
                $mfi_total = 0;
                $mfi_amount = 0;
                $mfi_overdue = 0;
                $mfi_cumulative = 0;
                $mfi_paid = 0;
            @endphp
            @if (!empty($mfi_loan))

                @foreach ($mfi_loan as $res)
                    @php
                        $mfi_total = $mfi_total + checkZero($res->lo_next_year);
                        $mfi_amount = $mfi_amount + checkZero($res->lo_principle_amount);
                        $mfi_overdue = $mfi_overdue + checkZero($res->overdue);
                        $mfi_cumulative = $mfi_cumulative + checkZero($res->total_paid_interest);
                        $mfi_paid = $mfi_paid + checkZero($res->current_year_interest);
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
                    <td>{{ $mfi_amount }}</td>
                    <th colspan="8"></th>
                    <th>{{ $mfi_paid }}</th>
                    <th></th>
                    <td>{{ $mfi_cumulative }}</td>
                    <td>{{ $mfi_overdue }}</td>
                    <td>{{ $mfi_total }}</td>
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

              {{-- NBFC LOAN --}}
              <tr class="back-color">
                <td colspan="15" style="font-weight: bold;">
                    NBFC LOAN
                </td>
            </tr>
            @php
                $nbfc_total = 0;
                $nbfc_amount = 0;
                $nbfc_overdue = 0;
                $nbfc_cumulative = 0;
                $nbfc_paid = 0;
            @endphp
            @if (!empty($nbfc_loan))

                @foreach ($nbfc_loan as $res)
                    @php
                        $nbfc_total = $nbfc_total + checkZero($res->lo_next_year);
                        $nbfc_amount = $nbfc_amount + checkZero($res->lo_principle_amount);
                        $nbfc_overdue = $nbfc_overdue + checkZero($res->overdue);
                        $nbfc_cumulative = $nbfc_cumulative + checkZero($res->total_paid_interest);
                        $nbfc_paid = $nbfc_paid + checkZero($res->current_year_interest);
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
                    <td>{{ $nbfc_amount }}</td>
                    <th colspan="8"></th>
                    <th>{{ $nbfc_paid }}</th>
                    <th></th>
                    <td>{{ $nbfc_cumulative }}</td>
                    <td>{{ $nbfc_overdue }}</td>
                    <td>{{ $nbfc_total }}</td>
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
                        $cluster_total = $cluster_total + checkZero($res->lo_next_year);
                        $cluster_amount = $cluster_amount + checkZero($res->lo_principle_amount);
                        $cluster_overdue = $cluster_overdue + checkZero($res->overdue);
                        $cluster_cumulative = $cluster_cumulative + checkZero($res->total_paid_interest);
                        $cluster_paid = $cluster_paid + checkZero($res->current_year_interest);
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
                        $fed_total = $fed_total + checkZero($res->lo_next_year);
                        $fed_amount = $fed_amount + checkZero($res->lo_principle_amount);
                        $fed_overdue = $fed_overdue + checkZero($res->overdue);
                        $fed_cumulative = $fed_cumulative + checkZero($res->total_paid_interest);
                        $fed_paid = $fed_paid + checkZero($res->current_year_interest);
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
                        $other_total = $other_total + checkZero($res->lo_next_year);
                        $other_amount = $other_amount + checkZero($res->lo_principle_amount);
                        $other_overdue = $other_overdue + checkZero($res->overdue);
                        $other_cumulative = $other_cumulative + checkZero($res->total_paid_interest);
                        $other_paid = $other_paid + checkZero($res->current_year_interest);
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
                <td>{{ $other_amount + $fed_amount + $cluster_amount + $bank_amount + $money_amount + $shg_amount + $mfi_amount + $nbfc_amount}}
                </td>
                <td colspan="8"></td>
                </td>
                <td>{{ $other_paid + $fed_paid + $cluster_paid + $bank_paid + $money_paid + $shg_paid + $mfi_paid + $nbfc_paid  }}
                </td>
                <td></td>
                <td>{{ $other_cumulative + $fed_cumulative + $cluster_cumulative + $bank_cumulative + $money_cumulative + $shg_cumulative + $mfi_cumulative + $nbfc_cumulative}}
                </td>
                <td>{{ $other_overdue + $fed_overdue + $cluster_overdue + $bank_overdue + $money_overdue + $shg_overdue + $mfi_overdue + $nbfc_overdue}}
                </td>
                <td>{{ $other_total + $fed_total + $cluster_total + $bank_total + $money_total + $shg_total + $mfi_total + $nbfc_total}}
                </td>
            </tr>

        </tbody>
    </table>
    <br>
    {{-- budget --}}
    <table class="table table1 " cellspacing="0" style="border:none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>FAMILY’S CURRENT AND NEXT YEAR BUDGET</u></td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="3">Income</td>
            </tr>
        </thead>

        <tbody style="text-align: center;">
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
                <td>Pension Income </td>
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

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="7">Expenditures for the Current Year and Next Year Forecast</td>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th width="4%" class="tdc">S.No</th>
                <th>Type</th>
                <th>Sub Type</th>
                <th>Spend type (Monthly/Yearly/season)</th>
                <th>Amount Per unit</th>
                <th>Total Expenditure for Current year (Amount)</th>
                <th>Forecast for Expenditure Next year (Amount)</th>
            </tr>
            {{-- Normal Expenditure --}}
            <tr>
                <th class="tdc">1</th>
                <th>Normal Expenditure </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            @php
                $sum_n = 0;
                $prev = '';
                $sum_ne = 0;
                $sum_n1 = 0;
                $sum_ne1 = 0;

            @endphp
            @if (!empty($normal_expenditure_first))
                @foreach ($normal_expenditure_first as $row)
                    @php
                        $sum_n = $sum_n + ($row->total_current != '' ? $row->total_current : 0);
                        $sum_ne = $sum_ne + ($row->total_next != '' ? $row->total_next : 0);
                    @endphp
                    <tr>
                        <td></td>
                        <td>
                            @php
                                if($prev != $row->e_type)
                                {
                                    echo $row->e_type;
                                }
                                $prev = $row->e_type;

                                $e_sub_type = 'N/A';
                                if($row->e_sub_type !='Other'){
                                    $e_sub_type = $row->e_sub_type;
                                }
                            @endphp

                           </td>
                        <td>{{ $e_sub_type }}</td>
                        <td>{{ $row->e_spend_type }}</td>
                        <td>{{ $row->e_amount }}</td>
                        <td>{{ $row->total_current }}</td>
                        <td>{{ $row->total_next }}</td>
                    </tr>
                @endforeach
                @endif
                @if (!empty($normal_expenditure_second))
                @foreach ($normal_expenditure_second as $row)
                    @php
                        $sum_n1 = $sum_n1 + ($row->total_current != '' ? $row->total_current : 0);
                        $sum_ne1 = $sum_ne1 + ($row->total_next != '' ? $row->total_next : 0);
                    @endphp
                    <tr>
                        <td></td>
                        <td>
                            @php
                                if($prev != $row->e_type)
                                {
                                    echo $row->e_type;
                                }
                                $prev = $row->e_type;
                            @endphp

                           </td>
                        <td>{{ checkna($row->e_sub_type) }}</td>
                        <td>{{ $row->e_spend_type }}</td>
                        <td>{{ $row->e_amount }}</td>
                        <td>{{ $row->total_current }}</td>
                        <td>{{ $row->total_next }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <th></th>
                    <th colspan="3">Sub-total Normal Expenditure</th>
                    <th></th>
                    <th>{{ $sum_n+$sum_n1 }}</th>
                    <th>{{ $sum_ne+$sum_ne1 }}</th>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                </tr>
                <tr class="total">
                    <th></th>
                    <th colspan="3">Sub-total Normal Expenditure</th>
                    <th></th>
                    <th colspan="">0</th>
                    <th>0</th>
                </tr>

            @endif
            {{-- social expenditure --}}
            <tr>
                <th class="tdc">2</th>
                <th>Social Expenditure</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>


            @php
                $sum_s = 0;
                $sum_sn = 0;
                $prev ='';
            @endphp
            @if (!empty($social_expenditure))


                @foreach ($social_expenditure as $row)
                    @php
                        $sum_s = $sum_s + ($row->total_current != '' ? $row->total_current : 0);
                        $sum_sn = $sum_sn + ($row->total_next != '' ? $row->total_next : 0);
                    @endphp
                    <tr>
                        <td></td>
                        <td>
                            @php
                                if($prev != $row->e_type)
                                {
                                    echo $row->e_type;
                                }
                                $prev = $row->e_type;
                            @endphp

                           </td>
                        <td>N/A</td>
                        <td>{{ $row->e_spend_type }}</td>
                        <td>{{ $row->e_amount }}</td>
                        <td>{{ $row->total_current }}</td>
                        <td>{{ $row->total_next }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <th></th>
                    <th colspan="3">Sub-total Social Expenditure</th>
                    <th></th>
                    <th colspan="">{{ $sum_s }}</th>
                    <th>{{ $sum_sn }}</th>
                </tr>
            @else
            <tr>
                <td></td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
            </tr>
            <tr class="total">
                <th></th>
                <th colspan="3">Sub-total Social Expenditure</th>
                <th></th>
                <th colspan="">0</th>
                <th>0</th>
            </tr>

            @endif
            {{-- Wasteful expenditure --}}
            <tr>
                <th class="tdc">3</th>
                <th>Wasteful Expenditure</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>


            @php
                $sum_w = 0;
                $sum_wn = 0;
                $prev ='';
            @endphp
            @if (!empty($wasteful_expenditure))


                @foreach ($wasteful_expenditure as $row)
                    @php
                        $sum_w = $sum_w + ($row->total_current != '' ? $row->total_current : 0);
                        $sum_wn = $sum_wn + ($row->total_next != '' ? $row->total_next : 0);
                    @endphp
                    <tr>
                        <td></td>
                        <td>
                            @php
                                if($prev != $row->e_type)
                                {
                                    echo $row->e_type;
                                }
                                $prev = $row->e_type;
                            @endphp

                        </td>
                        <td>N/A</td>
                        <td>{{ $row->e_spend_type }}</td>
                        <td>{{ $row->e_amount }}</td>
                        <td>{{ $row->total_current }}</td>
                        <td>{{ $row->total_next }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <th></th>
                    <th colspan="3">Sub-total Wasteful Expenditure</th>
                    <th></th>
                    <th colspan="">{{ $sum_w }}</th>
                    <th>{{ $sum_wn }}</th>
                </tr>
            @else
            <tr>
                <td></td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
            </tr>
            <tr class="total">
                <th></th>
                <th colspan="3">Sub-total Wasteful Expenditure</th>
                <th></th>
                <th colspan="">0</th>
                <th>0</th>
            </tr>

            @endif
            {{-- production/business expenditure --}}
            <tr>
                <th class="tdc">4</th>
                <th>Production/Business Expenses</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>


            @php
                $sum_p = 0;
                $sum_pn = 0;
                $prev ='';
            @endphp
            @if (!empty($production_expenditure))


                @foreach ($production_expenditure as $row)
                    @php
                        $sum_p = $sum_p + ($row->total_current != '' ? $row->total_current : 0);
                        $sum_pn = $sum_pn + ($row->total_next != '' ? $row->total_next : 0);
                    @endphp
                    <tr>
                        <td></td>
                        <td>
                            @php
                                if($prev != $row->e_type)
                                {
                                    echo $row->e_type;
                                }
                                $prev = $row->e_type;
                            @endphp

                        </td>
                        <td>N/A</td>
                        <td>{{ $row->e_spend_type }}</td>
                        <td>{{ $row->e_amount }}</td>
                        <td>{{ $row->total_current }}</td>
                        <td>{{ $row->total_next }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <th></th>
                    <th colspan="3">Sub-total Production/Business Expenditure</th>
                    <th></th>
                    <th colspan="">{{ $sum_p }}</th>
                    <th>{{ $sum_pn }}</th>
                </tr>
            @else
            <tr>
                <td></td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
            </tr>
            <tr class="total">
                <th></th>
                <th colspan="3">Sub-total Production/Business Expenditure</th>
                <th></th>
                <th colspan="">0</th>
                <th>0</th>
            </tr>

            @endif
            {{-- loan expenditure --}}
            <tr>
                <th class="tdc">5</th>
                <th>Loan Expenditure</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>


            @php
                $sum_l = 0;
                $sum_ln = 0;

            @endphp
            @if (!empty($loan_expenditure))



                @foreach ($loan_expenditure as $data)

                    @php
                    $sum_l = $sum_l + (int) $data->current_year_interest;
                        $sum_ln = $sum_ln + (int) $data->lo_next_year;
                        $spend = '';
                        if ($data->lo_tenure_mode == 0) {
                            $spend = $data->lo_no_of_tenure . '-' . 'Months';
                        } elseif ($data->lo_tenure_mode == 1) {
                            $spend = $data->lo_no_of_tenure . '-' . 'Year';
                        }
                    @endphp
                    <tr>
                        <td></td>
                        <td>{{ $data->lo_type }}</td>
                        <td>N/A</td>
                        <td>{{ $spend }}</td>
                        <td>{{ (int) $data->monthly_emi }}</td>
                        <td>{{ (int) $data->current_year_interest }}</td>
                        <td>{{ (int) $data->lo_next_year }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <th></th>
                    <th colspan="3">Sub-total Loan Expenditure</th>
                    <th></th>
                    <th colspan="">{{ $sum_l }}</th>
                    <th>{{ $sum_ln }}</th>
                </tr>
            @else
            <tr>
                <td></td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
            </tr>
            <tr class="total">
                <th></th>
                <th colspan="3">Sub-total Loan Expenditure</th>
                <th></th>
                <th colspan="">0</th>
                <th>0</th>
            </tr>

            @endif
            {{-- Savings expenditure --}}
            <tr>
                <th class="tdc">6</th>
                <th>Savings Expenses</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>


            @php
                $sum_savi = 0;

            @endphp
            @if (!empty($saving_expenditure))


                @foreach ($saving_expenditure as $row)
                    @php
                        $sum_savi = $sum_savi + ($row->SUM != '' ? $row->SUM : 0);

                    @endphp
                    <tr>
                        <td></td>
                        <td>
                            {{ $row->type}}

                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $row->SUM }}</td>
                        <td></td>
                    </tr>
                @endforeach
                <tr class="total">
                    <th></th>
                    <th colspan="3">Sub-total Savings Expenditure</th>
                    <th></th>
                    <th colspan="">{{ $sum_savi }}</th>
                    <th></th>
                </tr>
            @else
            <tr>
                <td></td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
            </tr>
            <tr class="total">
                <th></th>
                <th colspan="3">Sub-total Production/Business Expenditure</th>
                <th></th>
                <th colspan="">0</th>
                <th>0</th>
            </tr>

            @endif
            <tr>
                <td></td>
                <th colspan="3">Grand Total </th>
                <th></th>
                <th colspan="">{{ $sum_n +$sum_n1+ $sum_l + $sum_w + $sum_s + $sum_p + $sum_savi }}</th>
                <th>{{ $sum_ne+$sum_ne1 + $sum_ln + $sum_wn + $sum_sn + $sum_pn }}</th>
            </tr>
        </tbody>


    </table>
    <br>






    {{-- Analysis --}}
     <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>FAMILY’S CURRENT YEAR AND NEXT YEAR ANALYSIS</u></td>
            </tr>
        </thead>
    </table>
    <br>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="8">Indicators & Score</td>
            </tr>
        </thead>
        <tr>
            <th width="4%" class="tdc">SN</th>
            <th width="10%">Objective</th>
            <th width="25%">Indicators</th>
            <th width="10%" class="tdc">Total Score per objective</th>
            <th width="16%" colspan="2" class="tdc">Current Year</th>
            <th width="16%" colspan="2" class="tdc">Next Year</th>
        </tr>
        <tbody>
            <tr>
                <td></td>
                <td colspan="2"></td>
                <td></td>
                <th class="tdc">Score</th>
                <th class="tdc">Risk Level</th>
                <th class="tdc">Score</th>
                <th class="tdc">Risk Level</th>

            </tr>
            <tr>
                <th class="tdc">A</th>
                <th colspan="2">Family Budget</th>
                <th class="tdc">15</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            <tr>
                <th class="tdc">1</th>
                <td rowspan="2"></td>
                <td>Income and expenditure gap</td>
                <td class="tdc">5</td>
                <td class="tdc">{{ $analysis_1_cy }}</td>

                <td>
                    <div class="round" style="background:{{ $show1_cy }} ;margin-left:45%; "></div>
                </td>
                <td class="tdc">{{ $analysis_1_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show1_ny }} ;margin-left:45%; "></div>
                </td>
            </tr>
            <tr>
                <th class="tdc">2</th>

                <td>Income and expenditure ratio</td>
                <td class="tdc">10</td>
                <td class="tdc">{{ $analysis_2_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show2_cy }} ;margin-left:45%; "></div>
                </td>
                <td class="tdc">{{ $analysis_2_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show2_ny }} ;margin-left:45%; "></div>
                </td>
            </tr>
            <tr>
                <th class="tdc">B</th>
                <th colspan="2">Family Savings</th>
                <th class="tdc">23</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            <tr>
                <th class="tdc">3</th>
                <td></td>
                <td>Compulsory savings contributed during last 12 months</td>
                <td class="tdc">10</td>
                <td class="tdc">{{ $analysis_3_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show3_cy }} ;margin-left:45%; "></div>

                </td>
                <td class="tdc">{{ $analysis_3_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show3_cy }} ;margin-left:45%; "></div>
                </td>
            </tr>
            <tr>
                <th class="tdc">4</th>
                <td></td>
                <td>Voluntary savings contributed during last 12 months</td>
                <td class="tdc">2</td>
                <td class="tdc">{{ $analysis_4_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show4_cy }} ;margin-left:45%; "></div>
                </td>
                <td class="tdc">{{ $analysis_4_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show4_cy }} ;margin-left:45%; "></div>
                </td>
            </tr>
            <tr>
                <th class="tdc">5</th>
                <td></td>
                <td>Other Saving Source</td>
                <td class="tdc">2</td>
                <td class="tdc">{{ $analysis_5_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show5_cy }} ;margin-left:45%; "></div>
                </td>
                <td class="tdc">{{ $analysis_5_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show5_ny }} ;margin-left:45%; "></div>
                </td>
            </tr>
            <tr>
                <th class="tdc">6</th>
                <td></td>
                <td>Annual Savings to annual income ratio</td>
                <td class="tdc">8</td>
                <td class="tdc">{{ $analysis_5_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show5_cy }} ;margin-left:45%; "></div>
                </td>
                <td class="tdc">{{ $analysis_5_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show5_ny }} ;margin-left:45%; "></div>

                </td>
            </tr>
            <tr>
                <th class="tdc">7</th>
                <td></td>
                <td>Updated passbook in possession of family</td>
                <td class="tdc">1</td>
                <td class="tdc">{{ $analysis_6_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show6_cy }} ;margin-left:45%; "></div>
                </td>
                <td class="tdc">{{ $analysis_6_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show6_cy }} ;margin-left:45%; "></div>
                </td>
            </tr>
            <tr>
                <th class="tdc">C</th>
                <th colspan="2">Family Credit History</th>
                <th class="tdc">50</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            <tr>
                <th class="tdc">8</th>
                <td></td>
                <td>Annual Loan repayment and income ratio</td>
                <td class="tdc">10</td>
                <td class="tdc">{{ $analysis_7_cy }}</td>
                <td>

                    <div class="round" style="background:{{ $show7_cy }} ;margin-left:45%; "></div>

                </td>
                <td class="tdc">{{ $analysis_7_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show7_ny }} ;margin-left:45%; "></div>

                </td>
            </tr>
            <tr>
                <th class="tdc">9</th>
                <td></td>
                <td>Debt service ratio</td>
                <td class="tdc">10</td>
                <td class="tdc">{{ $analysis_8_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $show8_cy }} ;margin-left:45%; "></div>
                </td>
                <td class="tdc">{{ $analysis_8_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show8_ny }} ;margin-left:45%; "></div>
                </td>
            </tr>
            {{-- <tr>
                <th class="tdc">9</th>
                <td></td>
                <td>Total Overdue Internal loans</td>
                <td class="tdc">5</td>
                <td class="tdc">{{ $analysis_9_cy }}</td>

                <td>
                    <div class="round" style="background:{{ $show9_cy }} ;margin-left:45%; "></div>
                </td>

                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
            </tr> --}}
            <tr>
                <th class="tdc">10</th>
                <td></td>
                <td>Internal & External loan overdue</td>
                <td class="tdc">20</td>
                <td class="tdc">{{ $analysis_10_cy }}</td>

                <td>
                    <div class="round" style="background:{{ $show10_cy }} ;margin-left:45%; "></div>
                </td>

                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>
            </tr>
            <tr>
                <th class="tdc">11</th>
                <td></td>
                <td>Family Indebtedness</td>
                <td class="tdc">10</td>
                <td class="tdc">{{ $analysis_11_cy }}</td>

                <td>
                    <div class="round" style="background:{{ $show11_cy }} ;margin-left:45%; "></div>
                </td>

                <td class="tdc">N/A</td>
                <td class="tdc">N/A</td>

            </tr>
            <tr>
                <th class="tdc">D</th>
                <th colspan="2">Family Commitment to Group Rules</th>
                <th class="tdc">12</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            <tr>
                <th class="tdc">12</th>
                <td></td>
                <td>Meeting attendance during last 12 months</td>
                <td class="tdc">10</td>
                <td class="tdc">{{ $analysis_12_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show12_ny }} ;margin-left:45%; "></div>
                </td>
                <td class="tdc">{{ $analysis_12_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show12_ny }} ;margin-left:45%; "></div>
                </td>
            </tr>
            <tr>
                <th class="tdc">13</th>
                <td></td>
                <td>Understanding of Group rules</td>
                <td class="tdc">2</td>
                <td class="tdc">{{ $analysis_13_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show13_ny }} ;margin-left:45%; "></div>
                </td>
                <td class="tdc">{{ $analysis_13_ny }}</td>
                <td>
                    <div class="round" style="background:{{ $show13_ny }} ;margin-left:45%; "></div>
                </td>
            </tr>
            <tr>
                <td></td>

                <td colspan="2">Total</td>
                <td class="tdc">100</td>
                <td class="tdc">{{ $grand_total_cy }}</td>
                <td>
                    <div class="round" style="background:{{ $grdcolor }} ;margin-left:45%; "></div>
                </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <br>
    {{-- challenges --}}
    <table class="table table1 " cellspacing="0" style="border:none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>CHALLENGES AND ACTION PLAN</u></td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="2">Top Challenges</td>
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
                <td style="background-color:#cea38b" width="auto">Action Plan</td>
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
    @if ($business_investment_plan[0]->is_buisness_plan_avl == 'No')
    <table class="table table-bordered table-stripped table1" cellspacing="0">

        <thead class="back-color">
            <tr>
                <th width="25%">Business Plan</th>
                <td width="25%">{{ $business_investment_plan[0]->is_buisness_plan_avl }}</td>
                <th width="25%">Comments</th>
                <td width="25%">{{ $business_investment_plan[0]->comments }}</td>
            </tr>
        </thead>

    </table>
    @else

    <table class="table table-bordered table-stripped table1" cellspacing="0">

        <thead class="back-color">
            <tr>
                <th width="50%">Business Plan</th>
                <td width="50%">{{ $business_investment_plan[0]->is_buisness_plan_avl }}</td>
            </tr>
        </thead>

    </table>
    @endif
    <br>

    @if ($business_investment_plan[0]->is_buisness_plan_avl != 'No')
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

    
    @endif

    <br>

    {{-- Family/SHG Member Commitment --}}
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>FAMILY/SHG MEMBER</u></td>
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
                <th style="text-align: left;">Does member attend meetings regularly?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_meeting_yes_no) }}</td>
            </tr>

            <tr>
                <th class="tdc">2</th>
                <th style="text-align: left;">No. of meetings attended during last 12 months ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_meeting_attend) }}</td>
            </tr>

            <tr>
                <th class="tdc">3</th>
                <th style="text-align: left;">Reasons for not attending some meetings ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_metting_not_attend) }}</td>
            </tr>

            <tr>
                <th class="tdc">4</th>
                <th style="text-align: left;">What is her understanding of rules of her group ?</th>
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
                <th style="text-align: left;">If the member is aware of all categories ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_member_aware_categories) }}</td>
            </tr>
            <tr>
                <th class="tdc">6</th>
                <th style="text-align: left;">Does member and family participate in the community development
                    activities ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_somewhat_yes_no) }}</td>
            </tr>

            <tr>
                <th class="tdc">7</th>
                <th style="text-align: left;">Specify which activities member has participated during last 12
                    months ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_family_member_participate) }}
                </td>
            </tr>
            <tr>
                <th class="tdc">8</th>
                <th style="text-align: left;">Number of activities member has participates ?</th>
                <td>{{ checkna($shgmember_commitment[0]->yo_family_member_participate_no_of_activity) }}
                </td>
            </tr>



        </tbody>

    </table>
    <div class="page-break"></div>
    <br>

    {{-- observations --}}
    <table class="table table1 " cellspacing="0" style="border: none;">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:white;"><u>OBSERVATIONS</u></td>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table table-bordered table-stripped table1" cellspacing="0">
        <thead>
            <tr class="table-primary">
                <td style="background-color:#cea38b" colspan="3">Key Highlights And Observations About The Family
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
        <tbody >
            <tr>
                <th scope="row">1</th>
                <th>Who participated in the family?</th>
                <td colspan="2">
                    {{ $observation_this_year_member[0]->participate_family }}
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <th>How long the family has been living in this house?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_past_life }}</td>
            </tr>
            {{-- @if (!empty($observation_this_year[0]->fdip_observation_who_was))
            <tr>
                <th scope="row">2a</th>
                <th>Who was contributing mostly</th>
                <td>{{ $observation_this_year[0]->fdip_observation_who_was }}
                </td>
            </tr>
            @endif
            @if (!empty($observation_this_year[0]->fdip_observation_describe))
            <tr>
                <th scope="row">2b</th>
                <th>Describe it</th>
                <td>{{ $observation_this_year[0]->fdip_observation_describe }}
                </td>
            </tr>
            @endif --}}
            <tr>
                <th scope="row">3</th>
                <th>Give a few highlights about this family (who they are? What they do for living? were they ready for discussion? whether they actively participated, etc) </th>
                <td>{{ $observation_this_year[0]->fdip_observation_daily  }}</td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <th>What is special that you observed about this family? What are the three things you would like to highlight for this family (e.g. Readiness or reluctance to change,  attitudes in goal setting, feelings about commitments to act and unity within family, and so on) </th>
                <td>
                    <ol type="A" >
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
                <td scope="row">5</td>
                <th>What is this family burdened with or worried about (things that bother them on a daily basis)?
                </th>
                <td>{{ $observation_this_year[0]->fdip_observation_vulnerabilities }}
                    @if ($observation_this_year[0]->fdip_observation_vulnerabilities == 'Yes')
                    <br>
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
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="row">6</td>
                <th>In your assessment, what are key risks this family faces? Did this discussion help them understand their risks?”</th>
                <td>{{ $observation_this_year[0]->fdip_risk_assesment }}</td>
            </tr>

            <tr>
                <td scope="row">7</td>
                <th>Does their SHG help them?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_how }}</td>
            </tr>
            <tr>
                <td scope="row">8</td>
                <th>What was this family’s feedback on FDIP (did this discussion help them, if yes, in what ways)</th>
                <td>{{ $observation_this_year[0]->fdip_observation_agreement }}
                    @if ($observation_this_year[0]->fdip_observation_agreement == 'Yes')
                    <ol>
                        <li>{{ $observation_this_year[0]->fdip_observation_agreement_edittext }}</li>
                    </ol>

                    @endif
                </td>
            </tr>
            <tr>
                <td scope="row">9</td>
                <th>Are there in any observations that you have captured in other sections (e.g. family profile, assets, income, expenditures, loans, savings) that you would want to describe here                                                </th>
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
                        @if ($observation_this_year[0]->fdip_observation_highlights_f_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_f_9 }}
                        </li>
                        @endif
                        @if ($observation_this_year[0]->fdip_observation_highlights_g_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_g_9 }}
                        </li>
                        @endif
                        @if ($observation_this_year[0]->fdip_observation_highlights_h_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_h_9 }}
                        </li>
                        @endif
                        @if ($observation_this_year[0]->fdip_observation_highlights_i_9 != '')
                        <li>{{ $observation_this_year[0]->fdip_observation_highlights_i_9 }}
                        </li>
                        @endif
                    </ol>
                </td>
            </tr>
            <tr>
                <td scope="row">10</td>
                <th>Does this family want to take another loan for existing or new business (productive activities) – yes/no</th>
                <td>{{ $observation_this_year[0]->loan_new_existing !='1' ? 'Yes' :'No' }}</td>
            </tr>
            @if ($observation_this_year[0]->loan_new_existing == 0)
            <tr>
                <td scope="row">10.a</td>
                <th>Which trade they want to take loan for?</th>
                <td>{{ $observation_this_year[0]->fdip_which_trade_loan }}</td>
            </tr>
            <tr>
                <td scope="row">10.b</td>
                <th>Is this trade feasible in your opinion?</th>
                <td>{{ $observation_this_year[0]->fdip_which_trade_feasible }}</td>
            </tr>
            <tr>
                <td scope="row">10.c</td>
                <th>Who in the family will run this business?  </th>
                <td>{{ $observation_this_year[0]->fdip_who_run_family_buisness }}</td>
            </tr>
            <tr>
                <td scope="row">10.d</td>
                <th>What is the amount of loan they want to take?</th>
                <td>{{ $observation_this_year[0]->fdip_observation_amount_of_loan }}</td>
            </tr>
            <tr>
                <td scope="row">10.e</td>
                <th>When will they prepare the business plan?</th>
                <td>{{ $observation_this_year[0]->fdip_when_will_prepare_buisness_plan }}</td>
            </tr>
            @elseif($observation_this_year[0]->loan_new_existing == 1)
            <tr>
                <td scope="row">10.a</td>
                <th>Why this family has decided not to take another loan and start business/trade (state reasons for not preparing an investment plan)</th>
                <td>{{ $observation_this_year[0]->fdip_why_family_decided_not_take_loan }}</td>
            </tr>
            @endif

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
                <th>Has family prepared their business plan? Who helped in preparing the business plan?</th>
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
            {{-- <tr>
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
            </tr> --}}
            <tr>
                <td class="tdc">5</td>
                <th>Did you observe any change in the family from the 1st visit?, if yes describe</td>
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
    <br><br><br>
    @if (!empty($t_q_a))

        <table class="table table-bordered table-stripped table1" cellspacing="0">
            <thead>
                <tr class="table-primary" style="text-align: center;">
                    <td style="background-color:#01a9ac" colspan="3">District Manager Verification/Comments</td>
                </tr>
            </thead>
            <tbody class="back-color">
                <tr>
                    <th>Verification</th>
                    <th>Comments</th>
                    <th>Date</th>
                </tr>
                @foreach ($t_q_a as $res)
                    @if ($res->qa_status != 'P')
                        @php
                            $status = '';
                            if ($res->qa_status == 'V') {
                                $status = 'Verified';
                            } elseif ($res->qa_status == 'R') {
                                $status = 'Rejected';
                            } else {
                                $status = 'N/A';
                            }
                        @endphp
                        <tr>
                            <td >{{ $status }}</td>
                            <td><?php echo $res->remark ;  ?></td>
                            <td>{{ change_date_month_name_char(str_replace('/', '-', $res->created_at)) ?? 'N/A' }}
                            </td>
                        </tr>
                    @endif
                @endforeach



            </tbody>

        </table>

    @endif




</body>

</html>
