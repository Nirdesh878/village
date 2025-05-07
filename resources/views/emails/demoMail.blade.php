<html>
<head>
 <title>DART</title>
</head>
<body>

 
 <div style="width:90%;margin:0 auto;background:#fff;padding:0px;text-align:center;border:1px solid #ccc;">
    <div style="width:90%;background:#fff;margin:0 auto;padding-top:10px; text-align:center;">
         
        <font  style="text-shadow: 2px 2px 5px red; font-size: 40px; color: #B22222">DART </font>
        
        <hr style="width:98%;border:1px solid #ccc;margin-top:10px;"/>
    </div>
    <div style="width:90%;background:transparent;text-align:left;color:#000;margin-top: 4.5%;margin-bottom: 5.5%;padding:0px;">
        @php
        $name  = '';
        $task = '';
        $user_name = '';
        $manager_name = '';
        $status_n='';
        $time = '';
        $host = '';
        $user_name = $data['data']['user_name'];
        $manager_name = $data['data']['manager_name'];
        $status =$data['data']['status'];
        if($status == 'L')
        {
          $time = $data['data']['date'];
          $host = $data['data']['host'];
          
        }
        elseif($status !='L')
        {
            $name  = $data['data']['name'];
            $task = $data['data']['task'];
            
            
            if($status == 'V')
            {
            $status_n = 'Verified';
            }
            elseif($status == 'R')
            {
             $status_n = 'Rejected';
            }
            elseif($status == 'A')
            {
              $status_n = 'assigned';
            }
            elseif($status == 'S')
            {
              $status_n = 'submitted';
            }
        }
        
        @endphp
        <div style="width:86%;margin:0 auto;">
            <p>Dear {{$user_name}}</p>
            <p>Welcome!</p>
            @if($status !='L')
            <p>{{$manager_name}}.  has {{$status_n}} the {{$name}} ({{$task}}) task . Please Check.</p>
            @else
            <p>{{$manager_name}} has Loged in </p>
            <p>Loged in Time {{$time}}</p>
            <p>User IP Address {{$host}}</p>
            @endif
            <p>Greetings from DART team.</p>
            <p>Thanks<br>Administrator<br>DART</p>
            <p>Disclaimer<br>The contents of this Email communication are confidential to the addressee.</p>
        </div>
    </div>
    <div style="width:100%;background:#B22222;margin:0 auto;padding-top:10px;padding-bottom:10px; text-align:center;">
        
    </div> 
</div>
 

</body>
</html>

