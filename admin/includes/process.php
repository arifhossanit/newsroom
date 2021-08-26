<?php include_once("config.php"); 
    session_start();
    // db_config->real_escape_string()
    function filter($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
    
        return $data;
    }
?>
<!-- admin login in dashboard -->
<?php
if (isset($_POST["adminlogin"]) && $_POST["adminlogin"] =="Sign In") {
    extract($_POST);
    $email=filter($mail);
    $adminpass=md5($pass);
    $sql="SELECT admin_mail, admin_pass FROM myadmin WHERE admin_mail='$email' AND admin_pass='$adminpass'";
    $data=$db_config->query($sql);
    if ($data->num_rows > 0) {
        $_SESSION["mail"] = "admin";
        header("Location: ../dashboard.php");
        exit();
    }else {
        header("Location: ../index.php");
        exit();
    }
}
?>
<!-- catagory added in database -->
<?php
if (isset($_POST["cat_add"])) {
    extract($_POST);
    $id=filter($cat_no);
    $name=filter($cat_name);
    $detail=filter($cat_detail);
    if (!empty($_POST["cat_name"])) {
        $sql="INSERT INTO mycategory (id,cat_name,cat_detail) VALUES ('$id','$name','$detail')";
        $data=$db_config->query($sql);
    }
    
    if ($db_config->affected_rows) {
        header("Location: ../add_category.php?alert=success");
        exit();
    }else {
        header("Location: ../add_category.php?alert=fail");
        exit();
    }
}
?>
<!-- catagory update in database -->
<?php
    if (isset($_POST["cat_edit"])) {
        extract($_POST);
        if (!empty($_POST["cat_name"])) {
            $sql="UPDATE mycategory SET id='$cat_no', cat_name= '$cat_name', cat_detail='$cat_detail' WHERE id='$cat_no'";
            $data=$db_config->query($sql);
        }
        if ($db_config->affected_rows) {
            header("Location: ../update_category.php?alert=success&id=$cat_no");
            exit();
        }else {
            header("Location: ../update_category.php?alert=fail&id=$cat_no");
            exit();
        }
        
    }
?>
<!-- Delete category from database -->
<?php
    if (!empty($_GET["action"])  && !empty($_GET["id"]) && $_GET["action"]=="cat_del") {
        $id=$_GET["id"];
        $sql="DELETE FROM mycategory WHERE id='$id'";
        $data=$db_config->query($sql);
        if ($db_config->affected_rows) {
            header("Location: ../manage_category.php?alert=success");
            exit();
        }else {
            header("Location: ../manage_category.php?alert=fail");
            exit();
        }
        
    }
?>
<!-- Added reporter in databse -->
<?php
    if (isset($_POST['rsubmit'])) {
        extract($_POST);
        if (!empty($_POST['rname']) && !empty($_POST['rmail']) && !empty($_POST['rmobile'])) {
            $sql="INSERT INTO myreporter (id,reporter_name,reporter_mail,reporter_mobile) VALUES ('$rid','$rname','$rmail','$rmobile')";
            $data=$db_config->query($sql);
        }
        if ($db_config->affected_rows) {
            header("Location: ../add_reporter.php?alert=success");
            exit();
        }else {
            header("Location: ../add_reporter.php?alert=fail");
            exit();
        }
    }
?>
<!-- catagory update in database -->
<?php
    if (isset($_POST['ersubmit'])) {
        extract($_POST);
        if (!empty($_POST['rname']) && !empty($_POST['rmail']) && !empty($_POST['rmobile'])) {
            $sql="UPDATE myreporter SET id='$rid',reporter_name='$rname',reporter_mail='$rmail',reporter_mobile='$rmobile' WHERE id='$rid'";
            $data=$db_config->query($sql);
        }
        if ($db_config->affected_rows) {
            header("Location: ../update_reporter.php?alert=success&rid=$rid");
            exit();
        }else {
            header("Location: ../update_reporter.php?alert=fail&rid=$rid");
            exit();
        }
    }
?>
<!-- Delete reporter from database -->
<?php
    if (!empty($_GET["action"]) && $_GET["action"]=="r_del" && !empty($_GET["id"])) {
        $id=$_GET["id"];
        $sql="DELETE FROM myreporter WHERE id='$id'";
        $data=$db_config->query($sql);
        if ($db_config->affected_rows) {
            header("Location: ../manage_reporters.php?alert=success");
            exit();
        }else {
            header("Location: ../manage_reporters.php?alert=fail");
            exit();
        }
        
    }
?>
<!-- add post in database -->

<?php
    if (isset($_POST["post_submit"])) {
        extract($_POST);

        if (!empty($post_title) && !empty($post_detail) && !empty($_FILES["post_img"])) {
            $errors= array();
            $file_name = $_FILES['post_img']['name'];
            $file_size =$_FILES['post_img']['size'];
            $file_tmp =$_FILES['post_img']['tmp_name'];
            $file_type=$_FILES['post_img']['type'];
            $files=explode('.', $file_name);
            $file_ex=end($files);
            $file_ext=strtolower($file_ex);
            
            $extensions= array("jpeg","jpg","png", "docx", "pdf");
            
            if(in_array($file_ext,$extensions)=== false){
                header("Location: ../add_posts.php?alert=type");
                exit();
            }elseif($file_size >= 2097152){
                header("Location: ../add_posts.php?alert=size");
                exit();
            }else {
                move_uploaded_file($file_tmp,"../../post_images/".$file_name);
                $sql="INSERT INTO mypost (post_title,cat_id,post_details,post_pic,reporter_id) VALUES ('$post_title','$post_cat','$post_detail','$file_name','$post_reporter')";
                $data=$db_config->query($sql);
            }
        }
        if ($db_config->affected_rows) {
            header("Location: ../add_posts.php?alert=success");
            exit();
        }else {
            header("Location: ../add_posts.php?alert=fail");
            exit();
        }
    }
?>
<!-- admin logout from dashboard -->
<?php
    // for user log-out
    if (isset($_GET["logout"]) && $_GET["logout"] == "yes") {
        session_destroy();
        header("Location:../index.php");
    }
?>