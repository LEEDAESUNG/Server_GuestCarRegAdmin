
<?php

// 각 세대 사전방문예약 최대 등록 건수(월)

if (isset($_POST)) {

    $maxcount = $_POST['count'];
    if(!$maxcount){
        $maxcount=0;
    }
    
    include "dbinfo.inc";
    if ($conn) {
        try
        {
            $dt = date("Y-m-d H:i:s");

            $sql = "UPDATE tb_config SET Content = '$maxcount' WHERE Name = 'GuestCarReg_MaxParkCount'"; //신규가입회언에게 적용
            $result = mysqli_query($conn, $sql);
            $sql = "UPDATE tb_guestreg_admin SET MAXPARKCOUNT = '$maxcount'"; //현재 가입유저에게 적용
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
