
<?php

// 각 세대 사전방문예약 등록시 방문차량 최대 주차가능일수 지정

if (isset($_POST)) {

     $count = $_POST['count'];
     if(!$count){
         $count=0;
     }

     include "dbinfo.inc";

    if ($conn) {
        try
        {
            $dt = date("Y-m-d H:i:s");

            $sql = "UPDATE tb_config SET Content = '$count' WHERE Name = 'GuestCarReg_MaxDupInCar'"; //신규가입회언에게 적용
            $result = mysqli_query($conn, $sql);
            $sql = "UPDATE tb_guest_limit SET MAXINPARK = '$count'"; //현재 가입유저에게 적용
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);
            echo json_encode(array('result' => '1')); //정상처리
            exit;
        }
        catch (Exception $e)
        {
            mysqli_close($conn);
            echo json_encode(array('result' => '2')); //예외발생
            exit;
        }
    }
    else {
      echo json_encode(array('result' => '3')); //DB접속 불능
      exit;
    }
}
else
{
  echo json_encode(array('result' => '4')); //POST에러
  exit;
}
?>
