<?php
function check_login($con){
    if(isset($_SESSION['mo_no'])){
        $id = $_SESSION['mo_no'];
        $query = "select * from users where mo_no = '$id' limit 1";

        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
    
    // redirect to login
    //    header("Location: index.php");
    //    die;
    
}
?>