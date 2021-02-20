<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>방문차량 예약 시스템</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">



<script type="text/javascript">

</script>
  <!--
      <script type="text/javascript">
        //document.getElementById('GuestInDate').valueAsDate = new Date();
        //document.getElementById('GuestOutDate').valueAsDate = new Date();
        //let outDate = new Date();
        //outDate.setDate(outDate.getDate() + 4);
        //document.getElementById('GuestOutDate').valueAsDate = outDate;

        $(function() {
          $("#date1").datepicker({
            showOn: "both",
            buttonImage: "images/calendar.gif",
            buttonImageOnly: true,
            buttonText: "Select date"
          });
          $("#date3").datepicker({
              onSelect:function(dateText, inst) {
                  console.log(dateText);
              }
          });

          $( "#GuestInDate" ).datepicker(
               {
                  maxDate: '0',
                  beforeShow : function()
                  {
                    jQuery( this ).datepicker('option','maxDate', jQuery('#GuestOutDate').val() );
                  },
                  altFormat: "dd/mm/yy",
                  dateFormat: 'dd/mm/yy'
                }
        );
        $( "#GuestOutDate" ).datepicker(
             {
              minDate: '0',
              maxDate: '4',
              beforeShow : function()
              {
                jQuery( this ).datepicker('option','minDate', jQuery('#GuestInDate').val() );
              } ,
              altFormat: "dd/mm/yy",
              dateFormat: 'dd/mm/yy'
            }
        );
      });
      </script>
-->

</head>

<body>

  <?php

    session_start();
    if(!isset($_SESSION['ss_dong']) || !isset($_SESSION['ss_ho']) || !isset($_SESSION['ss_carno'])) {
        echo "<p>로그인을 해 주세요. <a href=\"login.php\">[로그인]</a></p>";
        echo("<script>location.href='login.php';</script>");

    } else {
        //$username = $_SESSION['username'];
        //$userpass = $_SESSION['userpass'];
        //echo "<p><strong>$_SESSION['username'].</strong>님 환영합니다.";
        //echo "<a href=\"logout.php\">[로그아웃]</a></p>";
    }
  ?>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"> </div>
      <div class="list-group list-group-flush">
        <a href="/guestcarreg.php" class="list-group-item list-group-item-action bg-light">방문예약</a>
        <a href="/index.php" class="list-group-item list-group-item-action bg-light">예약내역</a>
        <a href="/logout.php" class="list-group-item list-group-item-action bg-light">로그아웃</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      </nav>

      <div class="container-fluid">







		<table class="table table-striped">
      <form action="insert.php" method="post">
        <head>
              <tr>
                <th>차량번호</th>
                <th> <input type="text" name="GuestCarno" > </th>
              </tr>
              <tr>
                <th>방문객명</th>
                <th> <input type="text" name="GuestName" id='GuestName'> </th>
              </tr>
              <tr>
                <th>연락처</th>
                <th> <input type="text" name="GuestTel" id='GuestTel'> </th>
              </tr>
              <tr>
                <th>방문예약시작일자</th>
                <!-- <th> <input type="date" name="GuestInDate" id='GuestInDate' value="2020-01-01"> </th> -->
                <th> <input type="text" name="GuestInDate" id="GuestInDate"> </th>
              </tr>
              <tr>
                <th>방문예약종료일자</th>
                <!-- <th> <input type="date" name="GuestOutDate" id='GuestOutDate' value="2020-01-01"> </th> -->
                <th> <input type="text" name="GuestOutDate" id="GuestOutDate" class="filter-textfields" placeholder="End Date"/> </th>
              </tr>
              <tr>
                <th> </th>
                <th> <button type="submit" name = "GuesetCarReserved" id="GuesetCarReserved">방문예약 등록</button> </th>
              </tr>
          </head>
      </form>
		</table>


<!--
	  <div class="container">
        <form action="webdc_reg.php" method="get">
            <div>
                조회날짜 :
                <input type="date" name="sdate" id='currentSDate'>
                ~ <input type="date" name="edate" id='currentEDate' value="2000-01-01"> <button type="submit">웹할인 조회</button>
            </div>
        </form>

        <script>
          document.getElementById('currentSDate').valueAsDate = new Date();
          document.getElementById('currentEDate').valueAsDate = new Date();
        </script>
	  </div>
-->










    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

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
  <script>
        /**
      * 주어진 값 다음의 날짜 구하기(과거는 - 마이너스)
      * @param nextDateInt   날짜에 더하거나 빼야할 값
      * @param nowDate       현재 날짜 및 기준날짜( new Date(), 없을 경우 new Date(), yyyymmdd 8자리)
      * @return Date
      */
      function getNextDate(nextDateInt, standardDate){
          var oneDate = 1000 * 3600 * 24;
          var nowDate;
          if( standardDate == undefined )                 nowDate =new Date();
          else if( standardDate.getTime != undefined )    nowDate = standardDate;
          else if( standardDate.length == 8 )             nowDate =new Date(standardDate.substring(0, 4), parseInt(standardDate.substring(4, 6))-1, standardDate.substring(6, 8));

          return new Date(nowDate.getTime() + (oneDate * nextDateInt));
      }

      /*
      * 시작날짜와 종료날짜와의 차이 구하기
      * @param pStartDate 시작일 : 20200801
      * @param pEndDate   종료일 : 20200831
      * @param pType      'D':일수, 'M':개월수
      */
      function fn_calcDayMonthCount(pStartDate, pEndDate, pType) {
          var strSDT = new Date(pStartDate.substring(0,4),pStartDate.substring(4,6)-1,pStartDate.substring(6,8));
          var strEDT = new Date(pEndDate.substring(0,4),pEndDate.substring(4,6)-1,pEndDate.substring(6,8));
          var strTermCnt = 0;

          if(pType == 'D') {  //일수 차이
              strTermCnt = (strEDT.getTime()-strSDT.getTime())/(1000*60*60*24);
          } else {            //개월수 차이
              //년도가 같으면 단순히 월을 마이너스 한다.
              // => 20090301-20090201 의 경우(윤달이 있는 경우) 아래 else의 로직으로는 정상적인 1이 리턴되지 않는다.
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
          $("#GuestInDate").datepicker("setDate",new Date());
          $("#GuestOutDate").datepicker("setDate",new Date());
     });

         $( "#GuestInDate" ).datepicker(
           {
               minDate: '0',
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

                  // (minDate-오늘날짜) 차이계산
                  var a = getToday;
                  var aArr = getToday.split('-');
                  var b = myMinDate;
                  var bArr = myMinDate.split('-');


                  //31일, 윤달 계산 Bug
                  //var nToday = new Date(aArr[0],aArr[1],aArr[2]);
                  //var nStart = new Date(bArr[0],bArr[1],bArr[2]);
                  //var nCalc = (nStart - nToday)/(24 * 3600 * 1000);
                  //var myMaxDate = nCalc + 3;
                  //document.write("aArr:"+aArr+", bArr:"+bArr+"nCalc:" + nCalc);

                  var nCalc = fn_calcDayMonthCount(aArr[0]+aArr[1]+aArr[2], bArr[0]+bArr[1]+bArr[2], 'D')
                  var myMaxDate = nCalc + 3;

                  // 종료일 최소값, 최대값 지정
                  jQuery(this).datepicker('option', 'minDate', myMinDate);
                  jQuery(this).datepicker('option', 'maxDate', myMaxDate);
                }
             }
          );
  </script>
</body>
</html>
