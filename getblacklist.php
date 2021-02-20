

  <?php
    //include "dbinfo.inc";

    //정기권에서 블랙리스트 확인
    $conn2=mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    $sql2 = "select CAR_GUBUN from tb_reg where CAR_NO = '$db_carno' ";
    $result2=mysqli_query($conn2, $sql2);
    $total_rows2 = mysqli_num_rows($result2);
    if($total_rows2>0)
    {
        $row2 = mysqli_fetch_array($result2);

        // if($row2['CAR_GUBUN'] == "출입제한")
        // {
        //     $db_gubun = '출입제한';
        // }
        // else
        // {
        //     $db_gubun = "";
        // }

        $db_gubun = $row2['CAR_GUBUN'];
        if(!$db_gubun)
          $db_gubun="정기권";
    }
    else
    {
      $db_gubun = "미등록";
    }
    mysqli_close($conn2);
?>
