

  <?php
    include "dbinfo.inc";

    $db_guestcarreg_YN = "";
    $db_guestcarreg_MaxParkDay = "";
    $db_guestcarreg_MaxParkCount = "";
    $db_guestcarreg_MaxParkTime = "";
    $db_guestcar_MaxDupInCar = "";      //중복입차 허용횟수
    $db_guestcarreg_VisitCount = "";

    $conn=mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    $sql = "select * from tb_config where Title = '방문예약'; ";

    $result=mysqli_query($conn, $sql);
    $total_rows = mysqli_num_rows($result);

    while($row = mysqli_fetch_array($result))
    {
        if($row['Name'] == "GuestCarReg_MaxParkDay"){
            $db_guestcarreg_MaxParkDay = $row['Content'];
            if(!$db_guestcarreg_MaxParkDay){
                $db_guestcarreg_MaxParkDay = "0";
            }
        }
        else if($row['Name'] == "GuestCarReg_MaxParkCount"){
            $db_guestcarreg_MaxParkCount = $row['Content'];
            if(!$db_guestcarreg_MaxParkCount){
                $db_guestcarreg_MaxParkCount = "0";
            }
        }
        else if($row['Name'] == "GuestCarReg_MaxParkTime"){
            $db_guestcarreg_MaxParkTime = $row['Content'];
            if(!$db_guestcarreg_MaxParkTime){
                $db_guestcarreg_MaxParkTime = "0";
            }
        }
        else if($row['Name'] == "GuestCarReg_MaxDupInCar"){
            $db_guestcar_MaxDupInCar = $row['Content'];
            if(!$db_guestcar_MaxDupInCar){
                $db_guestcar_MaxDupInCar = "0";
            }
        }

    }
    mysqli_close($conn);
?>
