<?php

switch($vars['action']){

    case "signup":{
        include("view/header.php");
        include("view/users/signup.php");
        include("view/footer.php");
        exit;
    }break;

    case "do_signup":{
        $ret=user_process_signup($vars);

         if ($ret['status']==1){
            header("location: index.php?action=list"); 
         }else{
            header("location: index.php?action=signup&error_message=".urlencode($ret['error']));
         }
         exit;
    }break;

    case "login":{
        include("view/header.php");
        include("view/users/login.php");
        include("view/footer.php");
        exit;

    }break;    

    case "do_login":{
        print_r($vars);
         $ret=user_process_login($vars);
        print_r($ret); 
         if ($ret['status']==1){
            header("location: index.php?action=list"); 
         }else{
            header("location: index.php?action=login&error_message=".urlencode($ret['error']));
         }
         exit;
    }break;   

    case "chng_email":{
        include("view/header.php");
        include("view/users/chng_email.php");
        include("view/footer.php");
        exit;

    }break; 

    case "do_chng_email":{
        // $db->query("UPDATE users SET email =? WHERE user_id=? ",[$_POST['new_email'], $vars['user_id']]);      
	    // header("location: index.php?action=login"); 
        $ret=user_process_change_email($vars, user_get_logged_user());

        if ($ret['status']==1){
           header("location: index.php?action=list"); 
        }else{
           header("location: index.php?action=chng_email&error_message=".urlencode($ret['error']));
        }
        exit;
    }break; 
    
    case "chng_pw":{
        include("view/header.php");
        include("view/users/chng_pw.php");
        include("view/footer.php");
        exit;

    }break; 

    case "do_chng_pw":{

        $ret=user_process_change_password($vars, user_get_logged_user());

         if ($ret['status']==1){
            header("location: index.php?action=list"); 
         }else{
            header("location: index.php?action=chng_pw&error_message=".urlencode($ret['error']));
         }
         exit;
    }break; 

    case "show_stat":{
        $items = $db->query("SELECT * FROM items where user_id in (SELECT user_id FROM users WHERE is_admin= 'No')" )->fetchAll();
        $users = $db->query("SELECT * FROM users WHERE is_admin= 'No'" )->fetchAll();
        // include("view/header.php");
        include("index+admin_setup.php");
        // include("view/footer.php");
        exit;
    }break;  

    case "logout":{
        setcookie("app_email", "" , -1,"/");
	    setcookie("app_pass", "", -1,"/");        
	    header("location: index.php?action=login"); 
	    exit;
    }break;    

}
?>