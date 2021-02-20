
<?php

// 각 세대 사전방문예약 최대 누적주차시간(월) - 출구LPR 있을경우에만 사용가능

if (isset($_POST)) {

    $maxtime = $_POST['count'];
    if(!$maxtime){
        $maxtime=0;
    }

    include "dbinfo.inc";
    if ($conn) {
        try
        {
            $dt = date("Y-m-d H:i:s");

            $sql = "UPDATE tb_config SET Content = '$maxtime' WHERE Name = 'GuestCarReg_MaxParkTime'"; //신규가입회언에게 적용
            $result = mysqli_query($conn, $sql);
            $sql = "UPDATE tb_guestreg_admin SET MAXPARKTIME = '$maxtime'"; //현재 가입유저에게 적용
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
