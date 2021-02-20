
<?php
  // UTF-8 저장한다.
  // 엑셀2016에서 파일불러오기 방법 : 엑셀실행 -> 데이터 -> 텍스트 -> 파일선택후열 -> 텍스트마법사실행(다음->쉼표체크,다음->마침) -> 확인
  $resultCode = '1';
  $saveName = "방문예약내역_".date("Ymd_his");

  //$myfile = fopen("C:\\Winpark\Excel\\".$saveName.".TXT", "w") or die("Unable to open file!");

  if( !is_dir("C:\\Winpark")){
      mkdir("C:\\Winpark", 0777, true);
  }
  if( !is_dir("C:\\Winpark\Excel")){
      mkdir("C:\\Winpark\Excel", 0777, true);
  }
  $myfile = fopen("C:\\Winpark\Excel\\".$saveName.".CSV", "w") or die("Unable to open file!");


  $txt = "번호,차량번호,동,호수,방문객명,연락처,방문예약시작일자,방문예약종료일자,등록일자,상태\n";
  $txt = UTF8toEUCKR($txt);//iconv("UTF-8", "EUC-KR", $txt);
  fwrite($myfile, $txt);

  //extract($_POST);
  //if (isset($_POST)) {
  // extract($_GET);
  if (isset($_GET)) {
      $carno =$_GET['carno'];
      $dong = $_GET['dong'];
      $ho = $_GET['ho'];
      $sdate = $_GET['sdate'];
      $edate = $_GET['edate'];

       include "dbinfo.inc";
      if (!$conn) {
          mysqli_close($conn);
          fclose($myfile);
          echo json_encode(array('result' => '3')); //처리지연
          exit;
      }
      else {
          try
          {
              include "querylist.php";
              $result=mysqli_query($conn, $sql);
              $total_rows = mysqli_num_rows($result);

              if( $total_rows==0) {
                  mysqli_close($conn);
                  fclose($myfile);
                  echo json_encode(array('result' => '2')); // 데이터 없음
                  exit;
              }
              else {
                  while($row = mysqli_fetch_array($result))
                  {
                      $db_seq = $row['SEQ'];
                      $db_carno = $row['CAR_NO'];                                                           $db_carno=UTF8toEUCKR($db_carno);
                      $db_drivername = $row['DRIVER_NAME'];                                                 $db_drivername=UTF8toEUCKR($db_drivername);
                      $db_phone = $row['DRIVER_PHONE'];                                                     $db_phone=UTF8toEUCKR($db_phone);
                      $db_dong = $row['DRIVER_DEPT'];                                                       $db_dong=UTF8toEUCKR($db_dong);
                      $db_ho = $row['DRIVER_CLASS'];                                                        $db_ho=UTF8toEUCKR($db_ho);
                      $db_startdate = $row['START_DATE'];   $db_startdate = substr($db_startdate, 0, 10);   $db_startdate=UTF8toEUCKR($db_startdate);
                      $db_enddate = $row['END_DATE'];       $db_enddate = substr($db_enddate, 0, 10);       $db_enddate=UTF8toEUCKR($db_enddate);
                      $db_regdate = $row['REG_DATE'];       $db_regdate = substr($db_regdate, 0, 10);       $db_regdate=UTF8toEUCKR($db_regdate);
                      $db_pass_yn = $row['PASS_YN'];                                                        $db_pass_yn=UTF8toEUCKR($db_pass_yn);

                      $txt = $db_seq.",".$db_carno.",".$db_dong.",".$db_ho.",".$db_drivername.",".$db_phone.",".$db_startdate.",".$db_enddate.",".$db_regdate;
                      if($db_pass_yn=="Y") {
                        $status=UTF8toEUCKR(",주차");
                      }
                      else {
                        $status=UTF8toEUCKR(",방문예약");
                      }

                      $txt = $txt.$status."\n";
                      fwrite($myfile, $txt);
                  } //while
              }
          }
          catch(Exception $e) {
              fclose($myfile);
              mysqli_close($conn);
              echo json_encode(array('result' => '-1')); // 예외발생
              exit;
          }
     } // else

       fclose($myfile);
       mysqli_close($conn);
       //echo json_encode(array('result' => '1')); //정상처리
       $filename = 'C:\Winpark\Excel\\'.$saveName.'.CSV 저장완료했습니다.';
       echo json_encode(array('result' => $filename)); //저장 완료
       exit;
   }  // if (isset($_GET))

   else {
     fclose($myfile);
     echo json_encode(array('result' => '3')); //처리지연
     exit;
   }
  //
  // fclose($myfile);
  // echo json_encode(array('result' => '3')); // 예외발생
  exit;

  function UTF8toEUCKR($str)
  {
      //return iconv("UTF-8", "EUC-KR", $str);

      try {
          $str = mb_substr($str,0);
      }
      catch (Exception $e) {
          $str = "err";
      }
      return $str;
  }
?>
