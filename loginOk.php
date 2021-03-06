<?php
header("Content-Type:text/html;charset=UTF-8");
?>
<?php
require_once "settingDB.php";
require_once "dbConnect.php";//userid, userpw db에 존재하면 로그인 성공

if(!isset($_POST['userId'])||!isset($_POST['userPw'])){
    echo "<script>
            alert('접속 오류');
            location.href='login.php';
            </script>
        ";
        exit;
}


// 특수문자 필터링

$userId = htmlspecialchars($_POST['userId'],ENT_QUOTES);
$userPw = htmlspecialchars($_POST['userPw'],ENT_QUOTES);

    
    //아이디 비밀번호 공백 처리
    if($userId==""||$userId==null){
        echo "<script>
            alert('아이디를 입력해주세요.');
            history.go(-1);
            </script>
        ";
        exit;
    }
    
    if($userPw==""||$userPw==null){
        echo "<script>
            alert('비밀번호 입력해주세요.');
            history.go(-1);
            </script>
        ";
        exit;
    }
    
    $query="select * from $tableName where userId='$userId' and userPw='$userPw'";

    $result=$conn->query($query);
    
    //결과의 레코드 갯수 //서버에 데이터가 0보다 있으면 로그인 성공이고, 0개랑 같으면 0개니까 회원이 아니다
    if($result->num_rows==0){
        echo "<script>
            alert('로그인 실패');
            location.href='login.php';
            </script>
        ";
        exit;
    }
    
    @session_start();   
    $_SESSION["sessionId"] = $userId; //로그인 성공시 세션을 설정
    
    echo "<script>
            alert('로그인에 성공하였습니다. index.php 페이지로 이동합니다.');
            location.href='index.php';
            </script>";
    
    $conn->close(); //db 연결 해제


?>