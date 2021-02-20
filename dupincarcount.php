
<?php
header("Content-Type; text/html; charset=utf-8");

if (isset($_POST)) {

    $dupcount = $_POST['count'];

    $prevLocation = "<script>"."location.href='guestcarSetting.php"."</script>";

    include "dbinfo.inc";
    if ($conn) {
        try
        {
            $dt = date("Y-m-d H:i:s");

            $sql = "UPDATE tb_config SET GuestCarReg_MaxDupInCar = '$dupcount' ";
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
