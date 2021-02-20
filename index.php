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
        <form action="index.php" method="get">
            <div>
                <input type="text" name="carno" placeholder="차량번호 4자리 입력" onfocus="this.placeholder = ''" onblur="if(this.placeholder=='')this.placeholder='차량번호 4자리 입력';"> <button type="submit">차량번호조회</button>
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
                          $car_array = array();
                          $idx = 0;
                          // $now_array= array(array(1,2,3),
                          //   array(4,5,6),array(4,5,6),array(4,5,6),array(4,5,6),
                          // );
                          // $now_array= $now_array.array(array(1,2,3),
                          // );
                          // echo count($now_array);
                          // exit;
// $family_name = [
//     'dad' => 'Bob',
//     'mom' => 'Jessy',
//     'son' => 'James',
//     'daughter' => 'Emily'
// ];
// $family_name['puppy'] = 'KongE';
// echo $family_name['puppy'];
// exit;

                          $colorNormal = 'skyblue';
                          $colorWarning = 'orange';
                          $colorForbidden = 'red';


                          $regcar_YN = "N";
                          $dt = date("Y-m-d").' 00:00:00'; //오늘날짜


                          //$sql = "select * from tb_now where CAR_NO like '%$carno%' ORDER BY CAR_NO, PASS_DATE DESC ";
                          $sql = "SELECT * FROM (SELECT * FROM tb_now WHERE CAR_NO LIKE '%$carno%' ORDER BY CAR_NO, PASS_DATE DESC) AS tmpTable GROUP BY tmpTable.car_no";
                          $result=mysqli_query($conn, $sql);
                          $total_rows = mysqli_num_rows($result);
                          //$now_array[$idx] = $row['CAR_NO']; //차량번호 임시저장
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

                            array_push($car_array,[
                              "carno" => $db_carno,
                              "gubun" => $db_cargubun,
                              "dong" => $db_dept,
                              "ho" => $db_class,
                              "phone" => $db_phone,
                              "sdate" => $db_startdate,
                              "edate" => $db_enddate,
                              "passdate" => $db_passdate,
                              "result" => $db_passresult,
                              "regcar" => $regcar_YN,
                              ]);
                            } // while

                            $sql = "SELECT * FROM tb_reg WHERE CAR_NO LIKE '%$carno%'";
                            $result=mysqli_query($conn, $sql);
                            $total_rows = mysqli_num_rows($result);
                            $find_regcar="";
                            while($row = mysqli_fetch_array($result))
                            {
                                $find_regcar = "N";
                                for($i = 0; ($i < count($car_array)) && ($find_regcar == "N") ; $i++)
                                {
                                    if( strcmp($row['CAR_NO'], $car_array[$i]["carno"]) == 0)
                                    {
                                         $find_regcar = "Y";
                                         //break; // 전체 루프를 빠져나감
                                    }
                                }
                                if($find_regcar == "N")
                                {
                                    $regcar_YN = "N";
                                    $startdate = substr($row['START_DATE'], 0, 10);
                                    $enddate = substr($row['END_DATE'], 0, 10);
                                    if(strcmp($dt, $startdate)>=0 && strcmp($dt, $enddate)<=0 ) // 정기권 기간 만료 차량일 경우
                                    {
                                        if(strcmp($row['CAR_GUBUN'], "출입제한")<0) //출입제한 차량 아닐경우
                                        {
                                            $regcar_YN = "Y";
                                        }
                                    }

                                    array_push($car_array,[
                                      "carno" => $row['CAR_NO'],
                                      "gubun" => $row['CAR_GUBUN'],
                                      "dong" => $row['DRIVER_DEPT'],
                                      "ho" => $row['DRIVER_CLASS'],
                                      "phone" => $row['DRIVER_PHONE'],
                                      "sdate" => $startdate,
                                      "edate" => $enddate,
                                      "passdate" => "",
                                      "result" => "",
                                      "regcar" => $regcar_YN,
                                    ]);
                                }
                            } // while

                            for($i = 0; $i < count($car_array); $i++)
                            {
                      ?>


                            <tr>

                            <?php
                              if($car_array[$i]["regcar"]=="N") {
                            ?>
                                <th bgcolor = <?php echo $colorWarning ?>>   <?php echo $car_array[$i]["carno"] ?>                                    </th>
                                <th bgcolor = <?php echo $colorWarning ?>>   <?php echo $car_array[$i]["gubun"] ?>                                    </th>
                                <th bgcolor = <?php echo $colorWarning ?>>   <?php echo $car_array[$i]["dong"] ?>                                     </th>
                                <th bgcolor = <?php echo $colorWarning ?>>   <?php echo $car_array[$i]["ho"] ?>                                       </th>
                                <th bgcolor = <?php echo $colorWarning ?>>   <?php echo $car_array[$i]["phone"] ?>                                    </th>
                                <th bgcolor = <?php echo $colorWarning ?>>   <?php echo $car_array[$i]["sdate"] ?> ~ <?php echo $car_array[$i]["edate"] ?>   </th>
                                <th bgcolor = <?php echo $colorWarning ?>>   <?php echo $car_array[$i]["passdate"] ?>                                 </th>
                                <th bgcolor = <?php echo $colorWarning ?>>   <?php echo $car_array[$i]["result"] ?>                                   </th>
                            <?php
                              }
                              else {
                            ?>
                                <th bgcolor = <?php echo $colorNormal ?>>   <?php echo $car_array[$i]["carno"] ?>                                   </th>
                                <th bgcolor = <?php echo $colorNormal ?>>   <?php echo $car_array[$i]["gubun"] ?>                                   </th>
                                <th bgcolor = <?php echo $colorNormal ?>>   <?php echo $car_array[$i]["dong"] ?>                                    </th>
                                <th bgcolor = <?php echo $colorNormal ?>>   <?php echo $car_array[$i]["ho"] ?>                                      </th>
                                <th bgcolor = <?php echo $colorNormal ?>>   <?php echo $car_array[$i]["phone"] ?>                                   </th>
                                <th bgcolor = <?php echo $colorNormal ?>>   <?php echo $car_array[$i]["sdate"] ?> ~ <?php echo $car_array[$i]["edate"] ?>   </th>
                                <th bgcolor = <?php echo $colorNormal ?>>   <?php echo $car_array[$i]["passdate"] ?>                                </th>
                                <th bgcolor = <?php echo $colorNormal ?>>   <?php echo $car_array[$i]["result"] ?>                                  </th>
                            <?php
                              }
                            ?>

                            </tr>
                    <?php
                          } //for
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
