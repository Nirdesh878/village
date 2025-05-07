<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Partners</title>
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
<h5 style="font-family: Arial, Helvetica, sans-serif;position:relative;left:80%;top:-50px;">Generated On- @php
                echo generated_date();
                @endphp
            </h5>
    <div class="page-header-title">
        <div class="d-inline">
            <h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;font-size:30px;"><u>Partners<u> 
            </h2>
        </div>

    </div>

    <table class="table table-bordered table-stripped table1 " cellspacing="0">
        <thead>
            <tr class="table-primary" style="text-align: center;">
                <td style="background-color:#01a9ac" colspan="7">Partners</td>
                
            </tr>
            <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Contact Person</th>
        <th>Country</th>
        <th>Email</th>
        <th>Number</th>
        <th>Address</th>
            </tr>
    </thead>
        <tbody>
            @php
            $i = 1;
           
            @endphp 
            @foreach ($partner as $row )
            <tr>
                <td>{{$i}}</td>
                <td>{{$row->partners_name}}</td>
                <td>{{$row->contact_person}}</td>
                <td>{{$row->country_name}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->contact_number}}</td>
                <td>{{$row->address}}</td>
                
            </tr>
            @php $i++ ; @endphp
            @endforeach
            
        </tbody>

    </table>
    
   
</body>

</html>