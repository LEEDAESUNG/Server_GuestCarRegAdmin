<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!--<title>방문차량 예약 시스템(관리자용)</title>-->
  <title>사전방문 예약 시스템(관리자용)</title>
  <link rel="icon" type="image/png" href="images/icons/Parking_Red.ico"/>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">




</head>

<body>
  <nav class="navbar navbar-light bg-light">
  <a class="navbar-brand mb-0 h1" href = "/index.php" >
    <img src="/images/icons/Parking_Red.ico" width="30" height="30" class="d-inline-block align-top" alt="">
    Parking System
  </a>
  </nav>

  <?php

    session_start();
    if(!isset($_SESSION['username']) || !isset($_SESSION['userpass']) ) {
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

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <!-- <div class="sidebar-heading">  </div> -->
      <div class="list-group list-group-flush">
        <a href="/guestcarreg.php" class="list-group-item list-group-item-action bg-light"><img src="/images/icons/raewmian.jpg" align = 'center' width = 200></a>
        <a href="/index.php" class="list-group-item list-group-item-action bg-light"><span class="ui-icon ui-icon-search"></span>&nbsp;&nbsp;&nbsp;주차차량조회</a>
        <a href="/guestcarreg.php" class="list-group-item list-group-item-action bg-light"><span class="ui-icon ui-icon-plus"></span>&nbsp;&nbsp;&nbsp;방문예약등록</a>
        <a href="/guestcarregList.php" class="list-group-item list-group-item-action bg-light"><span class="ui-icon ui-icon-note"></span>&nbsp;&nbsp;&nbsp;방문예약내역</a>
        <a href="/guestcarList.php" class="list-group-item list-group-item-action bg-light"><span class="ui-icon ui-icon-person"></span>&nbsp;&nbsp;&nbsp;방문입차내역</a>
        <a href="/guestcarSetting.php" class="list-group-item list-group-item-action bg-light"><span class="ui-icon ui-icon-gear"></span>&nbsp;&nbsp;&nbsp;설정</a>
        <a href="/logout.php" class="list-group-item list-group-item-action bg-light"><span class="ui-icon ui-icon-extlink"></span>&nbsp;&nbsp;&nbsp;로그아웃</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

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
        <form action="index.php" method="get">
            <div>
                <input type="text" name="carno" placeholder="차량번호 4자리 입력" onfocus="this.placeholder = ''" onblur="if(this.placeholder=='')this.placeholder='차량번호 4자리 입력';"> <button type="submit">주차차량조회</button>
            </div>
            <div style="color:orange; font-weight:bold; font-size:1.5em;">
                *노란색 표시 차량은 "주차허용기간" 초과 또는 미등록차량 입니다.
            </div>

            <div>
        		<table class="table table-striped">
                    <head>
                        <tr>
                            <th>차량번호</th>
                            <th>구분</th> <!-- 입주민, 사전방문등록, 미등록-->
                            <th>동</th>
                            <th>호수</th>
                            <th>연락처</th>
                            <th>주차허용기간</th>
                            <th>입차일시</th>
                            <th>입차결과</th>

                        </tr>
                    </head>

                    <tbody>
                      <?php

                      if(isset($_GET['carno'])) {
                        //$carno = $_GET['carno'];
                        $carno = preg_replace("/\s+/", "", $_GET['carno']);
                      }
                      else {
                        $carno = "";
                      }

                      include "dbinfo.inc";

                      if(strlen($carno) > 0 ) {
                          $regcar_YN = "N";
                          $dt = date("Y-m-d").' 00:00:00'; //오늘날짜
                          $sql = "select * from tb_now where CAR_NO like '%$carno%' ORDER BY CAR_NO ";

                          $result=mysqli_query($conn, $sql);
                          $total_rows = mysqli_num_rows($result);
                          while($row = mysqli_fetch_array($result))
                          {
                            $db_carno = $row['CAR_NO'];
                            $db_cargubun = $row['CAR_GUBUN'];
                            $db_dept = $row['DRIVER_DEPT'];
                            $db_class = $row['DRIVER_CLASS'];
                            $db_phone = $row['DRIVER_PHONE'];
                            $db_startdate = $row['START_DATE'];   $db_startdate = substr($db_startdate, 0, 10);
                            $db_enddate = $row['END_DATE'];       $db_enddate = substr($db_enddate, 0, 10);
                            $db_passdate = $row['PASS_DATE'];       $db_passdate = substr($db_passdate, 0, 19);
                            $db_passresult  = $row['PASS_RESULT'];

                            $regcar_YN = "Y";
                            if(strcmp($dt, $db_startdate)>=0 && strcmp($dt, $db_enddate)<=0 ) { // 정기권 기간 만료 차량일 경우
                                $regcar_YN = "Y";
                            }
                            else {
                                $regcar_YN = "N";
                            }
                      ?>


                          <tr>

                          <?php

                            if($regcar_YN=="N") {
                          ?>
                                <th bgcolor = 'orange'>   <?php echo $db_carno ?>                                   </th>
                                <th bgcolor = 'orange'>   <?php echo $db_cargubun ?>                                </th>
                                <th bgcolor = 'orange'>   <?php echo $db_dept ?>                                    </th>
                                <th bgcolor = 'orange'>   <?php echo $db_class ?>                                   </th>
                                <th bgcolor = 'orange'>   <?php echo $db_phone ?>                                   </th>
                                <th bgcolor = 'orange'>   <?php echo $db_startdate ?> ~ <?php echo $db_enddate ?>   </th>
                                <th bgcolor = 'orange'>   <?php echo $db_passdate ?>                                </th>
                                <th bgcolor = 'orange'>   <?php echo $db_passresult ?>                              </th>
                        <?php
                            }
                            else {
                        ?>
                                <th>   <?php echo $db_carno ?>                                   </th>
                                <th>   <?php echo $db_cargubun ?>                                </th>
                                <th>   <?php echo $db_dept ?>                                    </th>
                                <th>   <?php echo $db_class ?>                                   </th>
                                <th>   <?php echo $db_phone ?>                                   </th>
                                <th>   <?php echo $db_startdate ?> ~ <?php echo $db_enddate ?>   </th>
                                <th>   <?php echo $db_passdate ?>                                </th>
                                <th>   <?php echo $db_passresult ?>                              </th>
                        <?php
                            }
                        ?>

                          </tr>

                          <?php
                          }
                        }
                        mysqli_close($conn);
                      ?>
                    </tbody>
        		</table>
            </div>
<!--
            <div>
              <tr>
                <td>
                  <input type="date" name="sdate" id='currentSDate'>
                  ~ <input type="date" name="edate" id='currentEDate' value="2000-01-01"> <button type="submit">방문예약 조회</button>
                </td>
                <td>
                   [레코드 건수: ]
                </td>
              </tr>
            </div>


        <script>
          document.getElementById('currentSDate').valueAsDate = new Date();
          document.getElementById('currentEDate').valueAsDate = new Date();
        </script>
-->
      </form>
	  </div>







  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>
