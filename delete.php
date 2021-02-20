<?php
  session_start();
  if(!isset($_SESSION['username']) || !isset($_SESSION['userpass']) ) {
      echo "<p>로그인 해 주세요. <a href=\"login.php\">[로그인]</a></p>";
      echo("<script>location.href='login.php';</script>");
  } else {


    $username = $_SESSION['username'];
    $id = $username."(APP)";
    $guestCarno="";
    $guestDong="";
    $guestHo="";
    $guestName="";
    $guestTel="";
    $guestSdata="";
    $guestEdata="";
    $dt = date("Y-m-d H:i:s");

    if(isset($_GET['guestCarno']))    {
      $guestCarno=$_GET['guestCarno'];
    }
    if(isset($_GET['guestDong']))    {
      $guestDong=$_GET['guestDong'];
    }
    if(isset($_GET['guestHo']))    {
      $guestHo=$_GET['guestHo'];
    }
    if(isset($_GET['guestName']))    {
      $guestName=$_GET['guestName'];
    }
    if(isset($_GET['guestTel']))    {
      $guestTel=$_GET['guestTel'];
    }
    if(isset($_GET['sdate']))    {
      $guestSdata=$_GET['sdate'];
      $guestEdata=$guestSdata;
    }

    //$conn=mysqli_connect("localhost", "admin", "jawootek", "jwt_sanps");
    include "dbinfo.inc";
    $sql = "SELECT * FROM tb_guestReg WHERE seq = '$_GET[no]' AND DRIVER_DEPT = '$guestDong' and DRIVER_CLASS = '$guestHo' AND CAR_GUBUN = '방문예약' AND PASS_YN = 'Y' ";
		$result=mysqli_query($conn, $sql);
		$num_match=mysqli_num_rows($result);
		if($num_match) {
      mysqli_close($conn);
			echo("
				<script> window.alert('입차차량은 삭제할 수 없습니다.')
				window.location.replace('guestcarregList.php');
				</script>
			");
      exit;
    }



    $sql = "delete from tb_guestReg where seq = '$_GET[no]' AND DRIVER_DEPT = '$guestDong' and DRIVER_CLASS = '$guestHo' AND CAR_GUBUN = '방문예약' AND PASS_YN = 'N' ";
    $result = mysqli_query($conn, $sql);
    if( $result)
    {
      $sql = "insert into tb_reg_log (CAR_NO,CAR_GUBUN,DRIVER_NAME,DRIVER_PHONE,DRIVER_DEPT,DRIVER_CLASS,START_DATE,END_DATE,REG_DATE,ACTION_LOG,ACTION_ID) VALUES ( '$guestCarno','방문예약','$guestName','$guestTel','$guestDong','$guestHo','$guestSdata','$guestEdata','$dt','삭제','$id') ";
      $result = mysqli_query($conn, $sql);

      mysqli_close($conn);
      header("Content-Type: text/html; charset=UTF-8");
      echo "<script>alert('방문예약차량 삭제되었습니다.');";
      echo "window.location.replace('guestcarregList.php');</script>";
      //echo("<script>location.href='index.php';</script>");
    }
    else {
      mysqli_close($conn);
      header("Content-Type: text/html; charset=UTF-8");
      echo "<script>alert('방문예약차량 삭제실패했습니다. 재시도하세요.');";
      echo "window.location.replace('guestcarregList.php');</script>";
    }


  }
 ?>
