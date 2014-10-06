<?php
if( !defined('IN_SKYOJSYSTEM') )
{
    exit('Access denied');
}

function passwordHash($resoure)
{
    $re = md5("ncid".md5($resoure));
    return $re;
}
function getTimestamp()
{
    date_default_timezone_set( "Asia/Taipei" );
    return date('Y-m-d G:i:s');
}
function register($email,$nickname,$password,$repeat)
{
    global $_E;
    global $_config;
    $pattern  = '/^[._@a-zA-Z0-9]{3,20}$/';
    
    $_E['template']['reg'] = array();
    $acctable = $_config['db']['tablepre'].'_account';
    $timestamp = getTimestamp();
    $sqlres;
    
    if( !preg_match($pattern,$email) || !preg_match($pattern,$password) || $password!= $repeat ||
        $nickname != mysql_real_escape_string($nickname))
    {
        //use language!
        $_E['template']['reg'] = '格式錯誤';
        return false;
    }
    
    $nickname = mysql_real_escape_string($nickname);
    $password = passwordHash($password);

    $sqlres = mysql_query(  "SELECT * FROM  `$acctable`".
                            "WHERE  `email` =  '$email'");
    if(mysql_fetch_array($sqlres))
    {
        $_E['template']['reg'] = '帳號已被註冊';
        return false;
    }
    if(!mysql_query("INSERT INTO `".$_config['db']['dbname']."`.`$acctable` ".
                    "(`uid`, `email`, `passhash`, `nickname`, `timestamp`) ".
                    "VALUES (NULL, '$email', '$password', '$nickname', '$timestamp')"))
    {
        $_E['template']['reg'] = 'SQL error';
        return false;
    }
    return true;
}

function login($email,$password)
{
    global $_E;
    global $_config;
    $pattern  = '/^[._@a-zA-Z0-9]{3,20}$/';
    
    $_E['template']['login'] = array();
    $acctable = $_config['db']['tablepre'].'_account';
    $sqlres;
    $userdata = null;
    
    if( !preg_match($pattern,$email) || !preg_match($pattern,$password) )
    {
        $_E['template']['login'] = '帳密錯誤';
        return false;
    }
    $password = passwordHash($password);
    
    $sqlres=mysql_query("SELECT * FROM  `$acctable`".
                        "WHERE  `email` =  '$email'");
    if(! ($userdata = mysql_fetch_array($sqlres)) )
    {
        $_E['template']['login'] = '無此帳號';
        return false;
    }
    if( $userdata['passhash'] != $password )
    {
        $_E['template']['login'] = '密碼錯誤';
        return false;
    }
    return $userdata;
}