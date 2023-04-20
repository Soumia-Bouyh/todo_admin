<?php

switch($vars['action']){
    case "list":{
        $items = $db->query('SELECT * FROM items where user_id = ?',user_get_logged_user()['user_id'] )->fetchAll();
        
        include("view/header.php");
        include("view/list.php");
        include("view/footer.php");
        exit;
    }break;

    case "do_add":{
        $db->query("INSERT INTO items (title, user_id ) VALUES (?, ?)",[$vars['title'], user_get_logged_user()['user_id']]);
        header("location: index.php");
        exit;     
    }break;
    
    case "delete":{
        $db->query("DELETE FROM items WHERE item_id = ?",$vars['item_id']);
        header("location: index.php");
        exit;        
    }break;

    case "admin_delete":{
        $db->query("DELETE FROM items WHERE item_id = ?",$vars['item_id']);
        $items = $db->query("SELECT * FROM items where user_id in (SELECT user_id FROM users WHERE is_admin= 'No')" )->fetchAll();
        $users = $db->query("SELECT * FROM users WHERE is_admin= 'No'" )->fetchAll();
        // include("view/header.php");
        include("index+admin_setup.php");
        // include("view/footer.php");
        exit;       
    }break;

    case "admin_block":{
        $db->query("DELETE FROM users WHERE user_id = ?",$vars['user_id']);
        $items = $db->query("SELECT * FROM items where user_id in (SELECT user_id FROM users WHERE is_admin= 'No')" )->fetchAll();
        $users = $db->query("SELECT * FROM users WHERE is_admin= 'No'" )->fetchAll();
        // include("view/header.php");
        include("index+admin_setup.php");
        // include("view/footer.php");
        exit;       
    }break;
    
    case "do_edit":{
        // Call JavaScript function to enable edit
        echo '<script>enableEdit();</script>';
        $db->query("UPDATE items SET title =? WHERE item_id=? ",[$_POST['new_title'], $vars['item_id']]);
        header("location: index.php");
        exit;
    }break;
    
    case "next":{
        include("view/header.php");
        include("view/nextpage.php");
        include("view/footer.php");
        exit;
    }break;
    
    case "help":{
        //some code here to show help 
        exit;
    }break;


}

?>