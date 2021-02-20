<?php
    if ( !isset($_POST['username']) || !isset($_POST['userpass']) ) {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('아이디 또는 비밀번호가 틀렸습니다!');";
        echo "window.location.replace('login.php');</script>";
        exit;
    }
    $username = $_POST['username'];
    $userpass = $_POST['userpass'];

		//$conn=mysqli_connect("localhost", "admin", "jawootek", "jwt_sanps");
    include "dbinfo.inc";
		if (!$conn) {
			echo "<script>alert('인터넷 접속이 원활하지 않습니다. 잠시후 재시도 바랍니다!');";// echo mysqli_connect_error();
			echo("<script>location.href='login.php';</script>");
			exit;
		}

		$sql = "SELECT * FROM tb_id WHERE (id = '$username') AND (GUBUN='총괄관리자' OR GUBUN='관리자' OR GUBUN='운영자') ";
		$result=mysqli_query($conn, $sql);
		$num_match=mysqli_num_rows($result);

		if(!$num_match) {
      mysqli_close($conn);
			echo("
				<script> window.alert('아이디 또는 비밀번호를 다시 확인해주세요!')
				window.location.replace('login.php');
				</script>
			");
		} else {
			$row = mysqli_fetch_array($result);
			$db_pass = $row['PASSWORD'];
      $db_pass2 = $row['MENU10']; //임시 비암호화 암호

			mysqli_close($conn);

			//if(!password_verify($userpass, $db_pass)) {
      if($userpass != $db_pass && $userpass != $db_pass2) {
				header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('아이디 또는 비밀번호를 다시 확인해주세요!!');";
        echo "window.location.replace('login.php');</script>";
        exit;
			} else {


        //////////////////////////////////////////////////////////////
        include "dbinfo.inc";
        $sql2 = "SELECT * FROM tb_config WHERE NAME = 'GuestCarReg' ";
    		$result2=mysqli_query($conn, $sql2);
        $num_match2=mysqli_num_rows($result2);
        if($num_match2) {
          $row2 = mysqli_fetch_array($result2);
          $GuestCarReg = $row2['Content']; //DB필드명 대소문자 구분함
        }
        else
        {
          $GuestCarReg="N";
        }
        mysqli_close($conn);
        //////////////////////////////////////////////////////////////

				session_start();
				$_SESSION['username'] = $username;
		    $_SESSION['userpass'] = $userpass;
        $_SESSION['GuestCarReg'] = $GuestCarReg;

        //할인권 라디오버튼 초기값
        setcookie('cookie_SelectDC', '1', time()+(86400*1000), '/');

				echo("<script>location.href='index.php';</script>");
			}
		}


		//echo $_SESSION['username']."<br>"; echo $_SESSION['userpass']."<br>";

?>
<!-- <meta http-equiv="refresh" content="0;url=index.php" /> -->
