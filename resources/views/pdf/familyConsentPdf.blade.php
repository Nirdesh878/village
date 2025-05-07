<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DART/VESTINVILLAGES - CONSENT FORM</title>
</head>
<style>
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
        text-align: ;
    }

    ;

    .table-primary,
    .table-primary>td,
    .table-primary> {
        background-color: #01a9ac;
        color: #ffffff;

        font-size: 16px;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #e9ecef;
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
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:71%;top:-50px;font-size:20px;">Generate On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;">DART/VESTINVILLAGES - CONSENT FORM {{$profile[0]->uin}}
            </h2>
            <p>
                The person doing the interview must have explained to you the program (Information Sheet) before you agree to take part.  If you have any questions, ask the interviewer NOW before you decide whether to join in.  
            </p>
            <p>
                <b>I confirm that I understand that by ticking/initialling each box below, I am consenting to this element of the work, and that unticked/initialled boxes means that I DO NOT consent to that part of the study</b>
            </p>
        </div>
    </div>
    <table class="table table-bordered-dark table-stripped table1 " cellspacing="0" style="border: 1px black solid;">
       
        <tbody>
            <tr >
                <td colspan="2"> I confirm that I have: </td>
                <td width="50px"style="border: 1px black solid;">Tick Box</td>
            </tr>
            <tr>
                <td width="50px" style="border: 1px black solid;" rowspan="4"> 1</td>
                <td style="border: 1px black solid;">read and understood the Information Sheet for the above work.</td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->read_and_understand == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                
                <td style="border: 1px black solid;">considered the information and what will be expected of me.  </td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->considered_the_info == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                
                <td style="border: 1px black solid;">had the opportunity to ask questions which have been answered to my satisfaction</td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->had_the_opportunity == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                
                <td style="border: 1px black solid;">decided I would like to take part in this individual interview with my family members</td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->decided == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td width="50px" style="border: 1px black solid;"> </td>
                <td style="border: 1px black solid;">understood the potential risks of participating and the support that will be available to me should I become distressed during the course of this work.</td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->understood_the_potential == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td colspan="3">I understand and consent to the fact that: </td>
            </tr>
            <tr>
                <td width="50px" style="border: 1px black solid;" rowspan=""> 2</td>
                <td style="border: 1px black solid;">my participation is voluntary. I am free to withdraw at any time, during this interview or after the interview, without giving a reason and without my legal rights being affected.</td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->my_participation == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td></td>
                <td style="border: 1px black solid;">If there is an open loan account on my name or on the name of my household members, 
                    I will only be able to withdraw my data as the loan account is closed at the end of the loan duration.
                    </td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->If_there == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td width="50px" style="border: 1px black solid;" rowspan="2"> 3</td>
                <td style="border: 1px black solid;">my personal information (identifiable information like name, ID number, telephone number) will remain confidential and will be handled in accordance with US data protection law.</td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->my_personal == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td style="border: 1px black solid;">my data will be stored securely in DART/VestinVillages servers. 
                    </td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->my_data == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td width="50px" style="border: 1px black solid;" rowspan="2"> 4</td>
                <td style="border: 1px black solid;">my information may be reviewed by responsible individuals from DART/VestinVillages, our partner organizations and our funders for monitoring and audit purposes.</td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->my_information == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                
                <td style="border: 1px black solid;">DART/VestinVillages authenticated officers will have access to my data to determine eligibility to loans and training needs 
                    </td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->village_invest == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td width="50px" style="border: 1px black solid;" >5</td>
                <td style="border: 1px black solid;">I will not benefit financially from this interview and that this interview allows my household to be considered for a loan through the Village Invest platform, but by no means it equals to eligibility for a loan. </td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->i_will_not == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td width="50px" style="border: 1px black solid;" >6</td>
                <td style="border: 1px black solid;">I am aware of who I should contact if I wish to lodge a complaint.  
                    </td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->i_am_aware == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td width="50px" style="border: 1px black solid;" rowspan="2"> 7</td>
                <td style="border: 1px black solid;"><p><b>Overseas Transfer of Data</b></p>

                    <p>my personal and business data may be published online to attract loans for my business.</p>
                    </td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->my_personal_and_business == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                
                <td style="border: 1px black solid;">my personal data maybe used as marketing material to attract lenders. 
                    </td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->my_personal_data == 1)<span class="checkmark"></span> @endif</td>
            </tr>
            <tr>
                <td width="50px" style="border: 1px black solid;" ></td>
                <td style="border: 1px black solid;">I understand that I can withdraw any of the two consents above at any point in time, without
                    giving a reason, without my legal rights being affected and without my eligibility for a loan being affected.  
                      
                    </td>
                <td width="50px"style="border: 1px black solid;">@if($concent[0]->i_understand_that == 1)<span class="checkmark"></span> @endif</td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    
    
    <table class="table   table1 " cellspacing="0" style="border: white;">
        
        <tbody>
            <tr>
                <td width="20%" style="border-bottom: 1px black solid;height:20px;">{{$concent[0]->name_of_participant}}</td>
                <td width="20%" ></td>
                <td width="20%" style="border-bottom: 1px black solid;">{{change_date_month_name_char(str_replace('/','-',$concent[0]->participant_date))}}</td>
                <td width="20%"></td>
                <td width="20%" style="border-bottom: 1px black solid;"><img src="{{ url('/') }}/signature/fac_{{ $mst_id }}.png" height="30" width="100"></td>
            </tr>
            <tr>
                <td >Name of participant</td>
                <td></td>
                <td>Date</td>
                <td></td>
                <td>Signature</td>
            </tr>
            
            <tr>
                <td width="20%" style="border-bottom: 1px black solid;height:20px;">{{$concent[0]->name_of_facilitator}}</td>
                <td width="20%" ></td>
                <td width="20%" style="border-bottom: 1px black solid;">{{change_date_month_name_char(str_replace('/','-',$concent[0]->facilitator_date))}}</td>
                <td width="20%"></td>
                
                <td width="20%" style="border-bottom: 1px black solid;"><img src="{{ url('/') }}/signature/par_{{ $mst_id }}.png" height="30" width="100"></th></td>
            </tr>
            <tr>
                <td >Name of Field facilitator </td>
                <td></td>
                <td>Date</td>
                <td></td>
                <td>Signature</td>
            </tr>
         

        </tbody>

    </table>

   




</body>

</html>