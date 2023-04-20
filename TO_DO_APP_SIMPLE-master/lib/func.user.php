<?php
function is_valid_email($email) {
    /*
     * Function to check if an email is valid using regular expressions.
     */
    $pattern = '/^[\w\.-]+@[\w\.-]+\.\w+$/';
    // ^ : asserts position at the beginning of the string
    // [\w\.-]+ : matches one or more word characters (alphanumeric or underscore), dots, or hyphens
    // @ : matches the "@" symbol
    // [\w\.-]+ : matches one or more word characters (alphanumeric or underscore), dots, or hyphens
    // \. : matches a literal dot
    // \w+ : matches one or more word characters (alphanumeric or underscore)
    // $ : asserts position at the end of the string

    // Using preg_match function to match the pattern against the email
    if (preg_match($pattern, $email)) {

        return true;
		
    } else {

        return false;
    }
}

function user_get_logged_user(){
    global $db,$appuser;
    
    $appuser=0;
    if (isset($_COOKIE['app_email']) and strlen($_COOKIE['app_email'])>0){		
		$items = $db->query("SELECT * FROM users WHERE LOWER(email) = ? and pass= ?",$_COOKIE['app_email'], $_COOKIE['app_pass'])->fetchAll();
		if (count($items)>0){
			$appuser=$items[0];	
		}
	}
    return $appuser;
    
}
    
function user_process_login($vars){
    global $db;

	$ret['status']=0;
	$ret['error']='';
	
	$vars['email']=trim(strtolower($vars['email']));
	
    if (strlen($ret['error'])==0 and strlen($vars['email'])==0) {
        $ret['error']="You need to provide an email.";
        return $ret;
    }

    if (strlen($ret['error'])==0 and strlen($vars['pass'])==0) {
        $ret['error']="The password should be filled.";
        return $ret;
    }

    if (strlen($ret['error'])>0)return  $ret;
    
    //search for it in the database ?
	$items = $db->query("SELECT * FROM users WHERE LOWER(email) = ? and pass= ?",$vars['email'], md5($vars['pass']))->fetchAll();
	if (count($items)==0){
	        $ret['error']=LANG_INCORRECT_EMAIL_PASSWORD;
	        return $ret;
	}
	//For the sake of simplicity, log the user directly by setting their cookies..
	setcookie("app_email", $vars['email'], time()+(3600*24),"/");
	setcookie("app_pass", md5($vars['pass']), time()+(3600*24),"/");
	
	$ret['status']=1;
	$ret['error']='';
	return $ret;
}

function user_process_signup($vars){
	global $db;
	
	$ret['status']=0;
	$ret['error']='';
	
	$vars['email']=trim(strtolower($vars['email']));
	
    if (strlen($ret['error'])==0 and strlen($vars['email'])==0) {
        $ret['error']=LANG_YOU_NEED_TO_PROVIDE_EMAIL;
        return $ret;
    }
	if (strlen($ret['error'])==0 and is_valid_email($vars['email']) == false) {
        $ret['error']="Invalid email try again.";
        return $ret;
    }
    if (strlen($ret['error'])==0 and strlen($vars['name'])==0) {
        $ret['error']="You need to type in your name.";
        return $ret;
    }

    if (strlen($ret['error'])==0 and strlen($vars['pass'])==0) {
        $ret['error']="The password should be filled.";
        return $ret;
    }

    if (strlen($ret['error'])>0)return  $ret;
    //search for it in the database ?
	$items = $db->query("SELECT * FROM users WHERE LOWER(email) = ?",$vars['email'])->fetchAll();
	if (count($items)>0){
	        $ret['error']="There is already an account with this email address";
	        return $ret;
	}
	//Else, there is no users in the db with the same email
	if($vars['is_admin'] == NULL){$vars['is_admin'] = "No";}
    $db->query("INSERT INTO users (name, email, pass, is_admin) VALUES ( ?, ?, ?, ? )", $vars['name'], $vars['email'], md5($vars['pass']),  $vars['is_admin']);
				
	//log the user directly by setting their cookies..
	setcookie("app_email", $vars['email'], time()+(3600*24),"/");
	setcookie("app_pass", md5($vars['pass']), time()+(3600*24),"/");
	
	$ret['status']=1;
	$ret['error']='';
	return $ret;
}

function user_process_change_email($vars, $current_user){
	global $db;
	
	$ret['status']=0;
	$ret['error']='';
	
	$vars['email']=trim(strtolower($vars['email']));
	
    if (strlen($ret['error'])==0 and strlen($vars['email'])==0) {
        $ret['error']=LANG_YOU_NEED_TO_PROVIDE_EMAIL;
        return $ret;
    }
	if (strlen($ret['error'])==0 and is_valid_email($vars['email']) == false) {
        $ret['error']="Invalid email try again.";
        return $ret;
    }

    if (strlen($ret['error'])>0)return  $ret;
    //search for it in the database ?
	$items = $db->query("SELECT * FROM users WHERE LOWER(email) = ?",$vars['email'])->fetchAll();
	if (count($items)>0){
	        $ret['error']="There is already an account with this email address";
	        return $ret;
	}
	//Else, there is no users in the db with the same email
    $db->query("UPDATE users SET email =? WHERE user_id=? ",[$vars['email'], $current_user['user_id']]);
				
	// //log the user directly by setting their cookies..
	// setcookie("app_email", $vars['email'], time()+(3600*24),"/");
	// setcookie("app_pass", md5($vars['pass']), time()+(3600*24),"/");
	
	$ret['status']=1;
	$ret['error']='';
	return $ret;
}

function user_process_change_password($vars, $current_user){
	global $db;
	
	$ret['status']=0;
	$ret['error']='';
	
	$vars['email']=trim(strtolower($vars['email']));

    if (strlen($ret['error'])==0 and strlen($vars['pass'])==0) {
        $ret['error']="The password should be filled.";
        return $ret;
    }

    if (strlen($ret['error'])>0)return  $ret;
    //search for it in the database ?
	// $items = $db->query("SELECT * FROM users WHERE LOWER(email) = ?",$vars['email'])->fetchAll();
	// if (count($items)>0){
	//         $ret['error']="There is already an account with this email address";
	//         return $ret;
	// }
	//Else, there is no users in the db with the same email
    // $db->query("INSERT INTO users (name, email, pass) VALUES ( ?, ?, ? )", $vars['name'], $vars['email'], md5($vars['pass']));
	$db->query("UPDATE users SET pass =? WHERE LOWER(email) = ? ",[md5($vars['pass']), $current_user['email']]);      
			
	//log the user directly by setting their cookies..
	// setcookie("app_email", $vars['email'], time()+(3600*24),"/");
	// setcookie("app_pass", md5($vars['pass']), time()+(3600*24),"/");
	
	$ret['status']=1;
	$ret['error']='';
	return $ret;
}

function get_total_users(){
    global $db,$appuser;
    
    $appuser=0;
    if (isset($_COOKIE['app_email']) and strlen($_COOKIE['app_email'])>0){		
		$users = $db->query("SELECT user_id FROM users WHERE is_admin= 'No'")->fetchAll();
		if (count($users)>0){
			$appuser=$users;	
		}
	}
    return $appuser;
}

function is_admin($current_user){
return $current_user['is_admin'];

}
?>