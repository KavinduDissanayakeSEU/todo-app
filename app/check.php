<?php
if(isset($_POST['id'])){
    require '../db.con.php';

    $id = $_POST['id'];

    if(empty($id)){
        echo 'error';
    }else{
        $todo = $conn->prepare("SELECT id, checked FROM todo WHERE id=?");
        $todo->execute([$id]);

        $to_do = $todo->fetch();
        $uId = $to_do['id'];
        $checked =$to_do['checked'];

        $uChecked = $checked ? 0 : 1;

        $res = $conn->query("UPDATE todo SET checked=$uChecked WHERE id=$uId");

        if($res){
            echo $checked;
        }else{
            echo "error";
        }
        $conn = null;
        exit();
    }
}else{
    header("Location: ../index.php?mess=error");
}
