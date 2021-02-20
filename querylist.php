<?php

if(isset($_GET['carno'])) {
  $carno = $_GET['carno'];
}
else {
  $carno = "";
}
if(isset($_GET['dong'])) {
  $dong = $_GET['dong'];
}
else {
  $dong = "";
}
if(isset($_GET['ho'])) {
  $ho = $_GET['ho'];
}
else {
  $ho = "";
}

if(isset($_GET['sdate'])) {
  $startDate = $_GET['sdate'];
  $startDate = $startDate." 00:00:00";
}
else {
  $startDate = "";
}
if(isset($_GET['edate'])) {
  $endDate = $_GET['edate'];
  $endDate = $endDate." 23:59:59";
}
else {
  $endDate = "";
}

  $dt = date("Y-m-d").' 00:00:00'; //오늘날짜

  if(strlen($startDate) > 0 && strlen($endDate) > 0) {
      $sql = "select * from tb_guestReg where '$startDate' <= START_DATE AND END_DATE<='$endDate' ";
  }
  else {
      $sql = "select * from tb_guestReg where '$dt' <= START_DATE ";
  }

  if(strlen($carno) > 0 ) {
      if(strpos($sql, "where") == true) {
          $sql = $sql." AND CAR_NO like '%$carno%' ";
      }
      else {
          $sql = $sql." where CAR_NO like '%$carno%' ";
      }
  }

  if(strlen($dong) > 0 ) {
      if(strpos($sql, "where") == true) {
          $sql = $sql." AND DRIVER_DEPT = '$dong' ";
      }
      else {
        $sql = $sql." where DRIVER_DEPT = '$dong' ";
      }
  }
  if(strlen($ho) > 0 ) {
      if(strpos($sql, "where") == true) {
          $sql = $sql." AND DRIVER_CLASS = '$ho' ";
      }
      else {
        $sql = $sql." where DRIVER_CLASS = '$ho' ";
      }
  }

  $sql = $sql." ORDER BY REG_DATE DESC";

?>
