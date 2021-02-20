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
        <form action="guestcarSetting.php">

            <!-- <div>
              <tr>
                  <th>
                    <input type="hidden" name="carno" id="carno" >
                    <input type="text" name="dong" id="dong" placeholder="동 입력(숫자)" onfocus="this.placeholder = ''" onblur="if(this.placeholder=='')this.placeholder='동 입력(숫자)';">
                    <input type="text" name="ho" id="ho" placeholder="호 입력(숫자)" onfocus="this.placeholder = ''" onblur="if(this.placeholder=='')this.placeholder='호 입력(숫자)';">
                    <input type="text" name="sdate" id="GuestInDate" placeholder="검색시작날자"> ~
                    <input type="text" name="edate" id="GuestOutDate"  placeholder="검색종료날자" />
                    <button type="submit">검색</button>
                    <button type="submit" id="save">저장</button>
                  </th>
              </tr>
            </div> -->

            <div>
        		<table class="table table-striped">

                    <!-- <head>
                        <tr>
                            <th>내용</th>
                            <th>설정값</th>
                            <th>설정/미설정</th>
                        </tr>
                    </head> -->

                    <?php include 'getguestconfig.php'; ?>

                    <tbody>
                      <tr>
                          <th>각 세대 사전방문예약 등록시 최대 주차일수 지정(예약당일제외)</th>
                          <th><input type="text" name="guestmaxparkday" id="guestmaxparkday" placeholder="0 입력시 입차당일만 허용" value = <?php echo $db_guestcarreg_MaxParkDay ?>>(일)</th>
                          <th><button type="submit" id="guestmaxparksave">저장</th>
                      </tr>
                      <tr>
                          <th>각 세대 사전방문예약 최대 등록건수</th>
                          <th><input type="text" name="guestregcount" id="guestregcount" placeholder="0 입력시 무제한등록" value = <?php echo $db_guestcarreg_MaxParkCount ?>>(건,월)</th>
                          <th><button type="submit" id="guestregcountsave">저장</th>
                      </tr>
                      <tr>
                          <th>각 세대 사전방문예약차량 누적주차시간합계</th>
                          <th><input type="text" name="guestregtime" id="guestregtime" placeholder="0 입력시 사용안함" value = <?php echo $db_guestcarreg_MaxParkTime ?>>(건,월)</th>
                          <th><button type="submit" id="guestregtimesave">저장</th>
                      </tr>
                      <tr>
                          <th>방문차량 중복입차 허용건수</th>
                          <th><input type="text" name="guestdupincarcount" id="guestdupincarcount"  value = <?php echo $db_guestcar_MaxDupInCar ?>>(건,월)</th>
                          <th><button type="submit" id="guestdupincarcountsave">저장</th>
                      </tr>

                      <!-- <tr>
                          <th>사전방문예약 등록 제한 차량번호</th>
                          <th>
                              <input type="text" name="dupincar" id="dupincar" placeholder="">
                              <select name="sel" style="width:300px"></select>
                              <input type="button" value="추가" onClick="add();"/>
                              <input type="button" value="전부 삭제" onClick="clearAll();"/>
                          </th>
                          <th>미설정</th>
                      </tr> -->

                      <!-- <tr>
                          <th>출입제한 차량</th>
                          <th>
                              <select name="sel" style="width:300px"></select>
                              <input type="button" value="전부 삭제" onClick="clearAll();"/>
                          </th>
                          <th>미설정</th>
                      </tr> -->
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


    $('#guestmaxparksave').click(function(e) { // 사전방문예약차량 중복입차 허용건수(차량번호 기준)
      e.preventDefault(); // html에서 <a>, <submit 등의 동작중지한다
      $.ajax({
         type: "POST",
         url: "guestmaxparkdaysave.php",
         data: {
            count:$("#guestmaxparkday").val(),
          },
         dataType: "json",
         success: function (response) {
                if(response.result == 1){
                    alert('처리완료 했습니다.');
                }
                else {
                    alert('처리도중 에러발생했습니다. 잠시후 재시도하세요(ST_E001)');
                    alert(response.result);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('정의되지 않은 에러 발생. 동일현상 반복적으로 발생시 관리실 문의바랍니다(SV_E999)');
            }
     });
   });
   $('#guestregcountsave').click(function(e) { // 각 세대 사전방문예약 등록건수(월)
       e.preventDefault(); // html에서 <a>, <submit 등의 동작중지한다
       $.ajax({
          type: "POST",
          url: "guestregcountsave.php",
          data: {
             count:$("#guestregcount").val(),
           },
          dataType: "json",
          success: function (response) {
                 if(response.result == 1){
                     alert('처리완료 했습니다.');
                 }
                 else {
                     alert('처리도중 에러발생했습니다. 잠시후 재시도하세요(ST_E001)');
                     alert(response.result);
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert('정의되지 않은 에러 발생. 동일현상 반복적으로 발생시 관리실 문의바랍니다(SV_E999)');
             }
      });
    });
    $('#guestregtimesave').click(function(e) { // 각 세대 사전방문예약 누적주차시간(월)
        e.preventDefault(); // html에서 <a>, <submit 등의 동작중지한다
        $.ajax({
           type: "POST",
           url: "guestregtimesave.php",
           data: {
              count:$("#guestregtime").val(),
            },
           dataType: "json",
           success: function (response) {
                  if(response.result == 1){
                      alert('처리완료 했습니다.');
                  }
                  else {
                      alert('처리도중 에러발생했습니다. 잠시후 재시도하세요(ST_E001)');
                      alert(response.result);
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert('정의되지 않은 에러 발생. 동일현상 반복적으로 발생시 관리실 문의바랍니다(SV_E999)');
              }
       });
     });

   $('#guestdupincarcountsave').click(function(e) { // 사전방문예약차량 중복입차 허용건수(차량번호 기준)
        e.preventDefault(); // html에서 <a>, <submit 등의 동작중지한다

        $.ajax({
           type: "POST",
           url: "guestdupincarcountsave.php",
           data: {
              count:$("#guestdupincarcount").val(),
            },
           dataType: "json",
           success: function (response) {
									if(response.result == 1){
											alert('처리완료 했습니다.');
                    }
                  else {
											alert('처리도중 에러발생했습니다. 잠시후 재시도하세요(ST_E001)');
                      alert(response.result);
									}
							},
							error: function(jqXHR, textStatus, errorThrown) {
									alert('정의되지 않은 에러 발생. 동일현상 반복적으로 발생시 관리실 문의바랍니다(SV_E999)');
							}
       });
   });

  </script>




</body>

</html>
