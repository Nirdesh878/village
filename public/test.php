<?php
echo date('d-m-Y H:i');
$res = mail('lalit.ymca@gmail.com', 'test', 'test');
if($res)
{
    echo 'send11';
}
else
{
    echo 'not send11';
}
?>