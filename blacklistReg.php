
<?php
header("Content-Type; text/html; charset=utf-8");

if (isset($_GET)) {

    $carno =$_GET['carno'];
    $dong =$_GET['guestDong'];
    $ho =$_GET['guestHo'];
    $sdate =$_GET['sdate'];
    $edate =$_GET['edate'];

    $clientIP = get_client_ip();


    // $param = "?carno=" . $carno . "&dong=" . $dong . "&ho=" . $ho . "&sdate=" . $sdate . "&edate=" . $edate; //차량별 입차내역 출력
    $param = "?carno=&dong=" . $dong . "&ho=" . $ho . "&sdate=" . $sdate . "&edate=" . $edate;                  // $carno값 없음:중복입차건수 출력

    $prevLocation = "<script>"."location.href='guestcarList.php".$param."'"."</script>";

    include "dbinfo.inc";
    if ($conn) {


        try
        {
            $dt = date("Y-m-d H:i:s");

            $sql = "SELECT * FROM tb_reg WHERE CAR_NO = '$carno' ";
            $result=mysqli_query($conn, $sql);
            $total_rows = mysqli_num_rows($result);


            if( $total_rows==0) {
                $sql = "INSERT INTO tb_reg (CAR_NO, CAR_MODEL, CAR_GUBUN, CAR_FEE, DRIVER_NAME, DRIVER_PHONE, DRIVER_DEPT, DRIVER_CLASS, START_DATE, END_DATE, ETC, REG_DATE, UPDATE_DATE, FEE_DATE,DAY_ROTATION_YN,REG_PART,LANE1,LANE2,LANE3,LANE4,LANE5,LANE6,WEEK1,WEEK2,WEEK3,WEEK4,WEEK5,WEEK6,WEEK7,ROTATION,APP_YN,APP_PW) ";
                $sql = $sql." VALUES ('$carno','','출입제한',0,'','','','', '$dt', '9998-12:30 23:59:59', '사전방문관리앱 등록', '$dt', '', '',   '미적용', '$clientIP', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N', 'N', '')";
                $result = mysqli_query($conn, $sql);
                mysqli_close($conn);

                //echo("<script>location.href='guestcarregList.php'.$param;</script>");
                echo $prevLocation;
                exit;
              }
              else {
                $sql = "UPDATE tb_reg SET CAR_GUBUN = '출입제한' WHERE CAR_NO = '$carno' ";
                $result = mysqli_query($conn, $sql);
                mysqli_close($conn);

                echo $prevLocation;
                exit;
            }
        }
        catch (Exception $e)
        {
            mysqli_close($conn);
            echo $prevLocation;
            exit;
        }
    }
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

?>
