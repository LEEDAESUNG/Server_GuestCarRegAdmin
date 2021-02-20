<?php
  session_start();
  if(!isset($_SESSION['username']) || !isset($_SESSION['userpass'])) {
      echo "<p>로그인 해 주세요. <a href=\"login.php\">[로그인]</a></p>";
      echo("<script>location.href='login.php';</script>");

  } else {

    $username = $_SESSION['username'];
    $userpass = $_SESSION['userpass'];

    if(isset($_POST['GuestCarno']) == true) {
        //$guestCarno = $_POST['GuestCarno'];
        //$guestCarno = trim($_POST['GuestCarno'], " "); //빈 공간 제거
        $guestCarno = preg_replace("/\s+/", "", $_POST['GuestCarno']);
    }
    else {
        $guestCarno = "";
    }
    if(isset($_POST['GuestDong']) == true) {
        //$guestDong = $_POST['GuestDong'];
        //$guestDong = trim($_POST['GuestDong'], " ");
        $guestDong = preg_replace("/\s+/", "", $_POST['GuestDong']);
    }
    else {
        $guestDong = "";
    }
    if(isset($_POST['GuestHo']) == true) {
        //$guestHo = $_POST['GuestHo'];
        //$guestHo = trim($_POST['GuestHo'], " ");
        $guestHo = preg_replace("/\s+/", "", $_POST['GuestHo']);
    }
    else {
        $guestHo = "";
    }
    if(isset($_POST['GuestName']) == true) {
        //$guestName = $_POST['GuestName'];
        $guestName = preg_replace("/\s+/", "", $_POST['GuestName']);
    }
    else {
        $guestName = "";
    }
    if(isset($_POST['GuestTel']) == true) {
        //$guestTel = $_POST['GuestTel'];
        $guestTel = preg_replace("/\s+/", "", $_POST['GuestTel']);
    }
    else {
        $guestTel = "";
    }
    if(isset($_POST['GuestInDate']) == true) {
        $guestInDate = $_POST['GuestInDate'];
        $guestSdata=$guestInDate." 00:00:00";
    }
    else {
        $guestInDate = "";
    }
    if(isset($_POST['GuestOutDate']) == true) {
        $guestOutDate = $_POST['GuestOutDate'];
        $guestEdata=$guestOutDate." 23:59:59";
    }
    else {
        $guestOutDate = "";
    }


    if( isset($_POST['GuestInMethod']) == true) {
        if($_POST['GuestInMethod'] == "RightNow"){
          $guestPass ="Y"; //즉시입차
        }
        else {
          $guestPass ="N"; // 입차 예약
        }
    }
    else {
        $guestPass ="N";
    }

      //한글:3byte
      if( strlen($guestCarno)<9 ) {
        echo("
          <script> window.alert('차량번호 전체 입력바랍니다. 다시 입력해주세요.(I00001)');
  			           window.location.replace('guestcarreg.php');
          </script>
        ");
        exit();
      }
      if( strlen($guestDong)==0 || strlen($guestHo)==0 ) {
          echo("
            <script> window.alert('동,호수를 다시 입력해주세요.(I00002)');
    			           window.location.replace('guestcarreg.php');
            </script>
          ");
          exit();
        }
      if(strcmp($guestInDate,$guestOutDate)>0 )
      {
        echo("
          <script> window.alert('방문예약일자를 재확인해주세요.(I00003)');
  			           window.location.replace('guestcarreg.php');
          </script>
        ");
        exit();
      }

    //$conn=mysqli_connect("localhost", "admin", "jawootek", "jwt_sanps");
    include "dbinfo.inc";
		if (!$conn) {
			echo "인터넷 접속이 원활하지 않습니다. 잠시후 재시도 바랍니다.(I00004)";// echo mysqli_connect_error();
			echo("<script>location.href='login.php';</script>");
			exit();
		}


    //기존 등록차량인지 확인
    $sql = "SELECT * FROM tb_guestReg WHERE CAR_NO = '$guestCarno' ";
		$result=mysqli_query($conn, $sql);
    $total_rows = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result))
    {
        $sch_Carno = $row['CAR_NO'];
        $sch_StartDate = $row['START_DATE'];
        $sch_EndDate = $row['END_DATE'];

        if(strcmp($guestEdata,$sch_StartDate)<0 || strcmp($guestSdata,$sch_EndDate)>0 )
        {
             //신규등록 가능
        }
        else
        {
            mysqli_close($conn);
            echo("
            	  <script> window.alert('기존 등록차량의 방문예약일과 중복됩니다.(I00005)');
            	           window.location.replace('guestcarreg.php');
            	  </script>
            ");
            exit();
        }
    }


    $dt = date("Y-m-d H:i:s");


    //즉시 입차시 => 입차등록
    if($_POST['GuestInMethod'] == "RightNow"){
        $sql = "DELETE FROM tb_now WHERE CAR_NO = '$guestCarno'";
        $result = mysqli_query($conn, $sql);

        $sql = "INSERT INTO tb_now   (CAR_NO,REC_NO,CAR_GUBUN,DRIVER_NAME,DRIVER_PHONE,DRIVER_DEPT,DRIVER_CLASS,START_DATE,END_DATE,PASS_GATE,PASS_INOUT,PASS_DATE,PASS_YN,PASS_RESULT,CALC) values ('$guestCarno','$guestCarno','방문예약','$guestName','$guestTel','$guestDong','$guestHo','$guestSdata','$guestEdata','0','IN','$dt.000', 'Y','방문예약입차','0')";
        $result = mysqli_query($conn, $sql);

        $sql = "INSERT INTO tb_inout (CAR_NO,REC_NO,CAR_GUBUN,DRIVER_NAME,DRIVER_PHONE,DRIVER_DEPT,DRIVER_CLASS,START_DATE,END_DATE,PASS_GATE,PASS_INOUT,PASS_DATE,PASS_YN,PASS_RESULT,CALC) values ('$guestCarno','$guestCarno','방문예약','$guestName','$guestTel','$guestDong','$guestHo','$guestSdata','$guestEdata','0','IN','$dt.000', 'Y','방문예약입차','0')";
        $result = mysqli_query($conn, $sql);
    }


    $sql = "insert into tb_guestReg (CAR_NO,CAR_GUBUN,CAR_FEE,DRIVER_NAME,DRIVER_PHONE,DRIVER_DEPT,DRIVER_CLASS,START_DATE,END_DATE,REG_DATE,DAY_ROTATION_YN,LANE1,LANE2,LANE3,LANE4,LANE5,LANE6,WEEK1,WEEK2,WEEK3,WEEK4,WEEK5,WEEK6,WEEK7,ROTATION,PASS_YN,GUESTREG_ID) VALUES ( '$guestCarno','방문예약','0','$guestName','$guestTel','$guestDong','$guestHo','$guestSdata','$guestEdata','$dt','적용','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','N','$guestPass','$username') ";
    $result = mysqli_query($conn, $sql);
    if( $result)
    {
      //$id = $username."(APP)";
      $id = $username;
      $sql = "insert into tb_reg_log (CAR_NO,CAR_GUBUN,CAR_FEE,DRIVER_NAME,DRIVER_PHONE,DRIVER_DEPT,DRIVER_CLASS,START_DATE,END_DATE,REG_DATE,ACTION_LOG,ACTION_ID,LANE1,LANE2,LANE3,LANE4,LANE5,LANE6,WEEK1,WEEK2,WEEK3,WEEK4,WEEK5,WEEK6,WEEK7,ROTATION) VALUES ( '$guestCarno','방문예약','0','$guestName','$guestTel','$guestDong','$guestHo','$guestSdata','$guestEdata','$dt','등록','$id','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','N') ";
      $result = mysqli_query($conn, $sql);

      mysqli_close($conn);
      header("Content-Type: text/html; charset=UTF-8");
      echo "<script>alert('방문예약차량 등록했습니다.');";
      echo "window.location.replace('guestcarreg.php');</script>";
    }
    else {
      mysqli_close($conn);
      header("Content-Type: text/html; charset=UTF-8");
      echo "<script>alert('방문예약차량 등록실패했습니다. 재시도하세요.(I00006)');";
      echo "window.location.replace('guestcarreg.php');</script>";
    }




  }
 ?>
