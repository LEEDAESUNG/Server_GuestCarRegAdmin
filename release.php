
<?php
header("Content-Type; text/html; charset=utf-8");

if (isset($_GET)) {

    $carno =$_GET['carno'];
    $dong =$_GET['guestDong'];
    $ho =$_GET['guestHo'];
    $sdate =$_GET['sdate'];
    $edate =$_GET['edate'];

    // $param = "?carno=" . $carno . "&dong=" . $dong . "&ho=" . $ho . "&sdate=" . $sdate . "&edate=" . $edate;

    // $param = "?carno=" . $carno . "&dong=" . $dong . "&ho=" . $ho . "&sdate=" . $sdate . "&edate=" . $edate; //차량별 입차내역 출력
    $param = "?carno=&dong=" . $dong . "&ho=" . $ho . "&sdate=" . $sdate . "&edate=" . $edate;                  // $carno값 없음:중복입차건수 출력

    $prevLocation = "<script>"."location.href='guestcarList.php".$param."'"."</script>";


    include "dbinfo.inc";
    if ($conn) {
        try
        {
            $dt = date("Y-m-d H:i:s");

            $sql = "DELETE FROM tb_reg WHERE CAR_NO = '$carno' ";
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);

            echo $prevLocation;
            exit;
        }
        catch (Exception $e)
        {
            mysqli_close($conn);

            echo $prevLocation;
            exit;
        }
    }
}
?>
