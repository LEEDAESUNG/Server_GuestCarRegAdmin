<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!--<title> 방문차량 예약 시스템(관리자용) </title>-->
  <title>사전방문 예약 시스템(관리자용)</title>
  <link rel="icon" type="image/png" href="images/icons/Parking_Red.ico"/>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">




</head>

<body>
  <nav class="navbar navbar-light bg-light">
  <a class="navbar-brand mb-0 h1" href = "/guestcarregList.php" >
    <img src="/images/icons/Parking_Red.ico" width="30" height="30" class="d-inline-block align-top" alt="">
    Parking System
  </a>
  </nav>

  <?php

    session_start();
    if( !isset($_SESSION['username']) || !isset($_SESSION['userpass']) ) {
        echo "<p>로그인을 해 주세요. <a href=\"login.php\">[로그인]</a></p>";
        echo("<script>location.href='login.php';</script>");
        exit();
    } else {
        //$username = $_SESSION['username'];
        //$userpass = $_SESSION['userpass'];
        //echo "<p><strong>$_SESSION['username'].</strong>님 환영합니다.";
        //echo "<a href=\"logout.php\">[로그아웃]</a></p>";
    }
  ?>

  <div class="d-flex" id="wrapper">

    <?php include "Leftmenu.php" ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle">메뉴</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      </nav>

      <div class="container-fluid">









    <div>
        <form action="guestcarList.php" method="get">

            <div>
              <tr>
                  <th>
                    <!-- <input type="hidden" name="carno" id="carno" > -->
                    <input type="text" name="dong" id="dong" placeholder="동 입력(숫자)" onfocus="this.placeholder = ''" onblur="if(this.placeholder=='')this.placeholder='동 입력(숫자)';">
                    <input type="text" name="ho" id="ho" placeholder="호 입력(숫자)" onfocus="this.placeholder = ''" onblur="if(this.placeholder=='')this.placeholder='호 입력(숫자)';">
                    <input type="text" name="sdate" id="GuestInDate" placeholder="검색시작날자"> ~
                    <input type="text" name="edate" id="GuestOutDate"  placeholder="검색종료날자" />
                    <button type="submit">검색</button>
                    <button type="submit" id="save">저장</button>
                  </th>
              </tr>
            </div>

            <div>
        		<table class="table table-striped">

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
                  $sdate = $_GET['sdate'];
                  $startDate = $sdate." 00:00:00";
                }
                else {
                  $startDate = date("Y-m-d").' 00:00:00';
                }
                if(isset($_GET['edate'])) {
                  $edate = $_GET['edate'];
                  $endDate = $edate." 23:59:59";
                }
                else {
                  $endDate = date("Y-m-d").' 00:00:00';
                }
                $dt = date("Y-m-d").' 00:00:00'; //오늘날짜

                if($carno) { //차량별 입차내역
                    $sql = "SELECT * from tb_guestReg_daily where CAR_NO = '$carno' AND '$startDate' <= IN_TIME AND OUT_TIME<='$endDate' ORDER BY REG_DATE DESC";
                }
                else{ // 중목입차건수 및 주차시간
                    //$sql = "SELECT CAR_NO, count(*) as INCOUNT, sum(PARKTIME) as PARKTIME from tb_guestReg_daily where '$startDate' <= IN_TIME AND OUT_TIME<='$endDate' GROUP BY CAR_NO ORDER BY INCOUNT DESC";
                    $sql = "SELECT CAR_NO, count(*) as INCOUNT, sum(PARKTIME) as PARKTIME from tb_guestReg_daily where '$startDate' <= IN_TIME AND OUT_TIME<='$endDate'" ;
                    if($dong){
                      $sql = $sql." AND DRIVER_DEPT = '$dong' ";
                    }
                    if($ho){
                      $sql = $sql." AND DRIVER_CLASS = '$ho' ";
                    }
                    $sql = $sql." GROUP BY CAR_NO ORDER BY INCOUNT DESC";
                }

                if(!$carno) { //중복입차건수 및 주차시간
              ?>

                    <head>
                        <tr>
                            <th>차량번호</th>
                            <th>중복입차횟수</th>
                            <th>누적주차시간(분)</th>
                            <th>출입제한</th>
                        </tr>
                    </head>

                    <tbody>
              <?php
                    }
                else { //차량별 입차내역
              ?>
                    <head>
                        <tr>
                            <th>차량번호</th>
                            <th>동</th>
                            <th>호수</th>
                            <th>입차일시</th>
                            <th>출차일시</th>
                            <th>주차시간(분)</th>
                        </tr>
                    </head>

                    <tbody>
              <?php
                    }
                      include "dbinfo.inc";

                      $result=mysqli_query($conn, $sql);
                      $total_rows = mysqli_num_rows($result);
                      if( $total_rows==0) {
                      }
                      else {

                        if(!$carno) {
                              while($row = mysqli_fetch_array($result))
                              {
                                $db_carno = $row['CAR_NO'];
                                $db_dong = $dong; // 텍스트박스 입력값
                                $db_ho = $ho;     // 텍스트박스 입력값
                                $db_incount = $row['INCOUNT'];
                                $db_parktime = $row['PARKTIME'];
              ?>
                              <tr>
                                  <th>
                                      <!-- <?php echo $db_carno ?> -->
                                      <a href="/guestcarList.php?carno=<?php echo $db_carno ?>&sdate=<?php echo $sdate ?>&edate=<?php echo $edate ?>" role = "button"> <?php echo $db_carno ?> </a>
                                  </th>
                                  <th>
                                      <?php echo $db_incount ?>
                                  </th>
                                  <th>
                                      <?php echo $db_parktime ?>
                                  </th>

                                  <th>
                              <?php
                                    include "getblacklist.php";
                                    if($db_gubun == '출입제한')
                                    {
                              ?>
                                      <a href="/release.php?    carno=<?php echo $db_carno ?>&guestDong=<?php echo $db_dong ?>&guestHo=<?php echo $db_ho ?>&sdate=<?php echo $sdate ?>&edate=<?php echo $edate ?>" role = "button" OnClick="return confirm('출입제한 해제 하시겠습니까?\n')" style="color: red">
                                          출입제한</a>
                              <?php
                                    }
                                    else if($db_gubun == '미등록')
                                    {
                              ?>
                                      <a href="/blacklistReg.php?carno=<?php echo $db_carno ?>&guestDong=<?php echo $db_dong ?>&guestHo=<?php echo $db_ho ?>&sdate=<?php echo $sdate ?>&edate=<?php echo $edate ?>" role = "button" OnClick="return confirm('출입제한 차량으로 등록하시겠습니까?\n등록 후에는 입출차가 제한됩니다.\n')" style="color: orange">
                                            미등록</a>
                              <?php
                                    }
                                    else
                                    {
                              ?>
                                      <a href="/blacklistReg.php?carno=<?php echo $db_carno ?>&guestDong=<?php echo $db_dong ?>&guestHo=<?php echo $db_ho ?>&sdate=<?php echo $sdate ?>&edate=<?php echo $edate ?>" role = "button" OnClick="return confirm('출입제한 차량으로 등록하시겠습니까?\n등록 후에는 입출차가 제한됩니다.\n')" style="color: blue">
                                            <?php echo $db_gubun ?></a>
                              <?php
                                    }
                              ?>
                                  </th>
                              </tr>
              <?php
                              } //while
                          }
                          else{
                              while($row = mysqli_fetch_array($result))
                              {
                                $db_carno = $row['CAR_NO'];
                                $db_dong = $row['DRIVER_DEPT'];
                                $db_ho = $row['DRIVER_CLASS'];
                                $db_intime = $row['IN_TIME'];
                                $db_outtime = $row['OUT_TIME'];
                                $db_parktime = $row['PARKTIME'];
              ?>
                              <tr>
                                  <th>
                                      <?php echo $db_carno ?>
                                  </th>
                                  <th>
                                      <?php echo $db_dong ?>
                                  </th>
                                  <th>
                                      <?php echo $db_ho ?>
                                  </th>
                                  <th>
                                      <?php echo $db_intime ?>
                                  </th>
                                  <th>
                                      <?php echo $db_outtime ?>
                                  </th>
                                  <th>
                                      <?php echo $db_parktime ?>
                                  </th>
                              </tr>
              <?php
                            } //while
                          } //else
                      } // else
                      mysqli_close($conn);
              ?>
                    </tbody>
        		</table>
            </div>
      </form>
	  </div>






  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>



  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script charset='euc-kr'>
  function fn_calcDayMonthCount(pStartDate, pEndDate, pType) {
      var strSDT = new Date(pStartDate.substring(0,4),pStartDate.substring(4,6)-1,pStartDate.substring(6,8));
      var strEDT = new Date(pEndDate.substring(0,4),pEndDate.substring(4,6)-1,pEndDate.substring(6,8));
      var strTermCnt = 0;

      if(pType == 'D') {  //일수 차이
          strTermCnt = (strEDT.getTime()-strSDT.getTime())/(1000*60*60*24);
      } else {            //개월수 차이
          //년도가 같으면 단순히 월을 마이너스 한다.
          // => 20200301-20200201 의 경우(윤달이 있는 경우) 아래 else의 로직으로는 정상적인 1이 리턴되지 않는다.
          if(pEndDate.substring(0,4) == pStartDate.substring(0,4)) {
              strTermCnt = pEndDate.substring(4,6) * 1 - pStartDate.substring(4,6) * 1;
          } else {
              //strTermCnt = Math.floor((strEDT.getTime()-strSDT.getTime())/(1000*60*60*24*365.25/12));
              strTermCnt = Math.round((strEDT.getTime()-strSDT.getTime())/(1000*60*60*24*365/12));
          }
      }
      return strTermCnt;
  }

  $(document).ready(function() {
      //url parameter : get method
      var carno = $.urlParam('carno');
      if( carno ) {
          var carno = decodeURI($.urlParam('carno')) //한글처리
      }
      var dong = $.urlParam('dong');
      var ho = $.urlParam('ho');
      var stemp = $.urlParam('sdate');
      var etemp = $.urlParam('edate');

      //이전 검색어 입력
      if(carno){
        //$('#carno').val(carno);
      }
      if(dong){
        $('#dong').val(dong);
      }
      if(ho){
        $('#ho').val(ho);
      }

      if( !stemp) {
        //Initilize : today
        $("#GuestInDate").datepicker("setDate",new Date());
        $("#GuestOutDate").datepicker("setDate",new Date());
      }
      else {
        const tmpSDate = stemp.split("-");
        const tmpEDate = etemp.split("-");
        const newSDate = new Date(tmpSDate[0], tmpSDate[1]-1, tmpSDate[2]);
        const newEDate = new Date(tmpEDate[0], tmpEDate[1]-1, tmpEDate[2]);
        $("#GuestInDate").datepicker("setDate", newSDate);
        $("#GuestOutDate").datepicker("setDate", newEDate);
        console.log(newSDate);
        console.log(newEDate);
    }
  });

  $( "#GuestInDate" ).datepicker(
    {
        //minDate: '0',
       //altFormat: "yy-mm-dd",
        dateFormat: 'yy-mm-dd',
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
        monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
        dayNames: ['일','월','화','수','목','금','토'],
        dayNamesShort: ['일','월','화','수','목','금','토'],
        dayNamesMin: ['일','월','화','수','목','금','토'],
        showMonthAfterYear: true,
        changeMonth: true,
        changeYear: true,
        yearSuffix: '년'
     }
   );

   $("#GuestOutDate").datepicker(
        {
          //maxDate: '3',
         //altFormat: "dd/mm/yy",
         dateFormat: 'yy-mm-dd',
         prevText: '이전 달',
         nextText: '다음 달',
         monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
         monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
         dayNames: ['일','월','화','수','목','금','토'],
         dayNamesShort: ['일','월','화','수','목','금','토'],
         dayNamesMin: ['일','월','화','수','목','금','토'],
         showMonthAfterYear: true,
         changeMonth: true,
         changeYear: true,
         yearSuffix: '년',
         beforeShow: function() {
           var myMinDate=jQuery('#GuestInDate').val();

           /////////////////////////////////////////////////////////
           //오늘날짜
           var date = new Date();
           var year = date.getFullYear();
           var month = date.getMonth() +1;
           var day = date.getDate();
           if((month+"").length < 2) {
             month = "0" + month;
           }
           if((day+"").length < 2) {
             day = "0" + day;
           }
           var getToday = year+"-"+month+"-"+day;
           /////////////////////////////////////////////////////////
           var a = getToday;
           var aArr = getToday.split('-');
           var b = myMinDate;
           var bArr = myMinDate.split('-');

           var nCalc = fn_calcDayMonthCount(aArr[0]+aArr[1]+aArr[2], bArr[0]+bArr[1]+bArr[2], 'D')
           var myMaxDate = nCalc + 30;

           // 종료일 최소값, 최대값 지정
           jQuery(this).datepicker('option', 'minDate', myMinDate);
           //jQuery(this).datepicker('option', 'maxDate', myMaxDate);
         }
      }
   );

   $.urlParam = function(name){
    	 var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
       if (results==null){
           return null;
        }
        else{
           return results[1] || 0;
        }
   }

    $("#carno").focus(function(){
         $('#carno').val("");
      });
    $("#carno").blur(function(){
      });
    $("#dong").focus(function(){
         $('#dong').val("");
       });
    $("#ho").focus(function(){
         $('#ho').val("");
       });

    $('#save').click(function(e) {
        e.preventDefault(); // html에서 <a>, <submit 등의 동작중지한다

        $.ajax({
           type: "GET",
           url: "guestcarListsave.php",
           data: {
              // carno:$("#carno").val(),
              dong:$("#dong").val(),
              ho:$("#ho").val(),
              sdate:$("#GuestInDate").val(),
              edate:$("#GuestOutDate").val(),
            },
           dataType: "json",
           success: function (response) {
									if(response.result == 1){
											alert('처리완료 했습니다.');
                    }
                  else if(response.result == 2){
											alert('검색결과가 없습니다.');
                    }
                  else {
											//alert('저장도중 에러발생했습니다. 잠시후 재시도하세요(SV_E001)');
                      alert(response.result);
									}
							},
							error: function(jqXHR, textStatus, errorThrown) {
									//alert("ajax error : " + textStatus + "\n" + errorThrown);
									alert('정의되지 않은 에러 발생. 동일현상 반복적으로 발생시 관리실 문의바랍니다(SV_E999)');
							}
       });
   });

  </script>




</body>

</html>
