<?
/*
############################# SignMe 1.5 ############################
### |-----------------------------------------------------------| ###
### |      COPYRIGHT 2006 by Lukas Stalder, planetluc.com       | ###
### |      DO NOT REDISTRIBUTE OR RESELL THIS SCRIPT            | ###
### |      ANY WAYS WITHOUT MY EXPLICIT PERMISSION!             | ###
### |      Support: www.planetluc.com/forum/                    | ###
### |      Read the README.txt file for installation            | ###
### |-----------------------------------------------------------| ###
#####################################################################
*/ 


session_start();


// ************************** CONFIG **************************
// ************************************************************


// error reporting
error_reporting(0);

// misc values
$adminname = "raulvdl";
$adminpwd = "fhgrt6474-6dhjs";
$ppp = 10;                             	// posts to display per page
$adminexpire = 5*60;                	// time in seconds until admin has to relogin
$pathtoscript = "";						// eg if you call the script from within a file in a top level folder you have to put "folder_to_signme/". Otherwise leave it blank "".
$wrap = 40;                            	// max. length of a word (to avoid bad entries like "hhhheeeeeeeeelllllllllllloooooooooo" that destroy your design) --  set to 'false if you don't want this option
$fieldlength = 250;						// width in px of the input fields

// maximum word and/or characters per post (can use one or the other, both, or none)
$wordcount = false;                     	// count words in the message to limit the length of a post -- set to 'true' to use this option -- set to 'false' if you don't want this option
$maxwords = 40;                        	// max. length of words (letters with space between = word) for the message to keep people from writing 200+ pages of response
$txtwordcount = "max. words: ($maxwords) :: words remaining: ({countdown})"; // edit text for you language -- place {countdown} where you would like the number countdown to occur

$charactercount = false;                	// count characters (keystrokes) to limit the length of a post -- set to 'true' to use this option -- set to 'false' if you don't want this option
$maxchars = 250;                       	// max. length of characters for the message to keep people from writing 200+ pages of response
$txtcharactercount = "max. characters: ($maxchars) :: characters remaining: ({countdown})"; // edit text for you language -- place {countdown} where you would like the number countdown to occur


// date settings
$dateformat = "%e. %b. %G - %H:%M";	            // %b -> short month, %e -> day, %G -> 4digit year; for all possibilities have a look at http://www.php.net/manual/function.strftime.php
$datelang = "es_ES";					// language for formatted date output, de_DE -> german formatting; see http://www.php.net/manual/function.setlocale.php


//email notification settings
$emailnotify = false;                   // set to 'true' if you want an email notification when a new signature is added -- 'false' if you don't want to use this option
$emailHTML = false;                     // set to 'true' if you want to send multipart HTML/plain-text email -- 'false' if you want to send plain-text email only
$email_to = "admin@mysite.com";     	// change to your email address -- separate multiple email addresses with a comma (,)
$email_from = "noreply@mysite.com";    	// default email address in case the visitor does not include their return email address when signing the guest book
$email_subject = "New signature added to the SignMe guestbook"; // subject of sent email
$guestbook = "http://concienciaexpandida.com.ar/libro/signme.inc.php";     // URL to your site's guestbook location


//CAPTCHA settings (additional settings in 'captcha.php')
$captcha = false;                       	// set to 'true' if you want CAPTCHA keyword/image verification -- 'false' if you don't want to use this option
$captcha_case = false;                 	// set to 'false' if you want the CAPTCHA keyword case sensitive -- 'true' if you don't care
$captcha_symbol = false;              	// set to 'true' if you want to use symbols in the CAPTCHA or if your fonts don't support symbols (symbols included are #, $, %, &, *, =, ?, @) -- 'false' if you don't
$captcha_shapes = false;               	// set to 'true' if you would like shapes in the image to confuse bots -- set to 'false' if you don't want shapes in the image or if you think the keyword is too hard to read


// language settings

// menu item text
$txtsign = "firmar libro";
$txtview = "ver entradas";
$txtadmin = "";
//$txtadmin = "admin";
$txtlogout = "logout";

// error text
$txtbadname = "nombre perdido";
$txtbademail = "email invalido";
$txtbadmsg = "mensaje perdido";
$txtmsgfiltermatch = "el mensaje contiene palabras prohibidas";
$txtmisscaptcha = "missing keyword";
$txtbadcaptcha = "keyword entered does not match the image, please try again";
$txtwordcounterror = "you have exceeded the maximum word count<br/>(limited to $maxwords words)";
$txtcharcounterror = "you have exceeded the maximum character count<br/>(limited to $maxchars characters)";
$txterrors = "errores ocurridos:";

// signup form text 
$txtedit = "editar";
$txtdelete = "borrar";
$txtreply = "responder";
$txtblockip = "bloquear ip";
$txtname = "Nombre";
$txtemail = "Email";
$txtwebsite = "Website";
$txtmessage = "Mensaje";
$txtcaptcha = "Keyword";
$txtcaptchacase = "(keyword is case-sensitive)";
$txtmandatory = "* necesario";
$txtsubmitbutton = "Firmar";

// admin form text
$txtlogincap = "Admin Login";
$txtlogin = "Login";
$txtpassword = "Password";
$txtloginbutton = "Login";


// badwords list, seperated by comma
$badwords = "ass,motherfucker,asshole,fuck,fucker,bitch,slut,nazi,nigger,arsch,wixer,cock,shit,dick,penis,a$$,piss,pija,concha,tetas,teta,culo,pijas,mierda,cojer,pene,poronga,culona,yegua,puta,puto,putita,chupamela,perra";

// message spam filter (entry is not saved on match!)
// seperated by comma, use lowercase!
$msgfilter = "http://,[url],[/url]";


// CSS Styles
?>
<style type="text/css">
<!--
.signme { text-align: center;} /* main signme div container */
.signme .txt, .signme td, .signme .txt a { font-size:11px; }
.signme .signtable, .signme .logintable, .signme .signaturetable {margin-left: auto; margin-right: auto; }
.signme .signtable td { text-align:left; }
.signme .small, .signme .small a { font-size: 9px; }
.signme .count { font-size: 9px; text-align: left;}
.signme .input, .signme .field { width:<?=$fieldlength?>px; border:1px solid #cccccc; }
.signme .input:focus, .signme .field:focus { background-color:#f8f8f8; }
.signme .submit { width:<?=$fieldlength?>px; background-color:#ccc; color:#333; font-weight:bold; border:1px solid #888;}
-->
</style>
<?


// ********************************************************************************************************************************************************************
// ** DO NOT MAKE CHANGES BELOW HERE UNLESS YOU KNOW WHAT YOU'RE DOING! ***********************************************************************************************
// ********************************************************************************************************************************************************************


// xxs preventing
foreach ($_GET as $key => $val){
	$_GET[$key] = strip_tags($val);
	$_REQUEST[$key] = strip_tags($val);
}


$ptsfr = dirname(__FILE__)."/";
$dat = $ptsfr."data.dat";
$template = $ptsfr."template.inc.php";
$log = $ptsfr."log.dat.php";
setlocale(LC_TIME, $datelang);

//CAPTCHA session settings to pass to 'captcha.php'
$_SESSION['captcha_case'] = $captcha_case;
$_SESSION['captcha_symbol'] = $captcha_symbol;
$_SESSION['captcha_shapes'] = $captcha_shapes;
$_SESSION['captcha_width'] = $fieldlength;

$me = $_SERVER['PHP_SELF'];
$empty = false;
$now = time();
$version = "1.55";

if (!isset($_GET['hash']) || $_GET['hash']=="") {
   srand($now);
   for ($i=0; $i<16 ; $i++) $secret.=chr(rand(60, 127));
   $secret = md5($secret);
   $hash = md5($_SERVER['HTTP_USER_AGENT'].$now.$secret);
}else $hash = $_GET['hash'];
$getvars = "?hash=$hash";

if (isset($_REQUEST['do']))      $do = $_REQUEST['do'];
if (isset($_REQUEST['id']))      $id = $_REQUEST['id'];
if (isset($_REQUEST['action']))  $action = $_REQUEST['action'];
if (isset($_REQUEST['name']))    $name = $_REQUEST['name'];
if (isset($_REQUEST['pwd']))     $pwd = $_REQUEST['pwd'];
if (isset($_REQUEST['email']))   $email = $_REQUEST['email'];
if (isset($_REQUEST['www']))     $www = $_REQUEST['www'];
if (isset($_REQUEST['msg']))     $msg = $_REQUEST['msg'];
if (isset($_REQUEST['time']))    $time = $_REQUEST['time'];
if (isset($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];

if (isset($_SESSION['submitCmd']))
   $submitCmd = $_SESSION['submitCmd']; 
else {
   $submitCmd = substr($hash, 0, 10);
   $_SESSION['submitCmd'] = $submitCmd;
}

// ************************** functions ***********************
// ************************************************************

class mdasort {
    var $data;	
    var $sortkeys;
    
    function _sortcmp($a, $b, $i=0) {
        $r = strnatcmp($a[$this->sortkeys[$i][0]],$b[$this->sortkeys[$i][0]]);
        if ($this->sortkeys[$i][1] == "DESC") $r = $r * -1;
        if($r==0) {
            $i++;
            if ($this->sortkeys[$i]) $r = $this->_sortcmp($a, $b, $i);
        }
        return $r;
    }
    
    function msort() {
        if(count($this->sortkeys)) {
            usort($this->data,array($this,"_sortcmp"));
        }
    }
}

function getkey($index, $stuff){
   foreach ($stuff->data as $key => $item){
      if ($item['id']==$index){
         $ret = $key;
         break;	
      }
   }
   return $ret;
}

function validemail($addr){
   return eregi("^[a-z0-9]+([_.-][a-z0-9]+)*@([a-z0-9]+([.-][a-z0-9]+)*)+\\.[a-z]{2,4}$", $addr);
}

function clearoldadmins() {
   global $log, $now, $adminexpire;
   include($log);
   if (count($admins)>0){
      $i=0;
      $fp = fopen($log, "w");
      fputs($fp, "<?\n");
      foreach ($admins as $line){
         if ($now-$line['time']<$adminexpire)
            fputs($fp, "\$admins[$i]['time']=".$line[time]."; \$admins[$i]['hash']='".$line['hash']."';\n");			
         $i++;
      }
      fputs($fp, "?>");
      fclose($fp);
   }
}

function saveposts($stuff){
   global $dat;
   $fp = fopen($dat, "w");
   foreach ($stuff->data as $post){
      $line = $post['id']."|".$post['time']."|".$post['name']."|".$post['email']."|".$post['www']."|".$post['post']."\n";
      fputs($fp, $line);
   }
   fclose($fp);
}

function isloggedin() {
   global $log, $now, $adminexpire;
   include($log);
   $logged = false;
   if (count($admins)>0){
      foreach ($admins as $line){
         if ($line['hash'] == md5($_GET['hash'])) $logged = true;
      }
   }
   return $logged;
}

function showmenu() {
	global $txtsign, $txtview, $txtadmin, $txtlogout, $me, $getvars, $submitCmd;
	if (!isloggedin()) $login = "<a href='$me$getvars&do=admin'>$txtadmin</a>";
	else $login = "<a href='$me'>$txtlogout</a>";
	echo "<div class='txt'><a href='$me$getvars&do=$submitCmd'>$txtsign</a> :: <a href='$me$getvars&do=view'>$txtview</a> :: $login</div><br />";
}

function emailencoder ($str){
   for ($i=0; $i< strlen($str); $i++){
      $n = rand(0,10);
      if ($n>5) $foo.="&#".ord($str[$i]).";";
      else $foo.="&#x".sprintf("%X", ord($str[$i])).";";
   }
   return $foo;	
}

function getTemplate($tpl, $html){
	$match="/<\!\-\-$tpl\-\->(.*?)<\!\-\-$tpl\-\->/s";
	preg_match($match, $html, $tmp);
	return $tmp[1];		
}

if (!function_exists('str_ireplace')){
    function str_ireplace ($search, $replace, $subject, $count = null){
	
        if (is_string($search) && is_array($replace)) {
            trigger_error('Array to string conversion', E_USER_NOTICE);
            $replace = (string) $replace;
        }

        if (!is_array($search)) {
            $search = array ($search);
        }
    
        if (!is_array($replace)){
            $replace_string = $replace;

            $replace = array ();
            for ($i = 0, $c = count($search); $i < $c; $i++){
                $replace[$i] = $replace_string;
            }
        }

        $length_replace = count($replace);
        $length_search = count($search);
        if ($length_replace < $length_search){
            for ($i = $length_replace; $i < $length_search; $i++){
                $replace[$i] = '';
            }
        }

        $was_array = false;
        if (!is_array($subject)) {
            $was_array = true;
            $subject = array ($subject);
        }

        // Loop through each subject
        $count = 0;
        foreach ($subject as $subject_key => $subject_value){
		
            foreach ($search as $search_key => $search_value){
                $segments = explode(strtolower($search_value), strtolower($subject_value));

                $count += count($segments) - 1;
                $pos = 0;

                foreach ($segments as $segment_key => $segment_value){
                    $segments[$segment_key] = substr($subject_value, $pos, strlen($segment_value));
                    $pos += strlen($segment_value) + strlen($search_value);
                }
                
                $subject_value = implode($replace[$search_key], $segments);
            }

            $result[$subject_key] = $subject_value;
        }

        if ($was_array === true) {
            return $result[0];
        }
        return $result;
    }
}

function paging(
   $pages,
   $pagevar	= "page",
   $ppv		= 10, 
   $first	= "<a href='{url}'>&laquo;&laquo;&laquo;</a>&nbsp;",
   $firsts	= "&laquo;&laquo;&laquo&nbsp;",
   $prev	= "<a href='{url}'>&laquo;&laquo;</a>&nbsp;&nbsp;",
   $prevs	= "&laquo;&laquo;&nbsp;&nbsp;",
   $num		= "<a href='{url}'>{page}</a>",
   $nums	= "{page}",
   $sep		= "&nbsp;|&nbsp;",
   $more	= "[<a href='{url}'>...</a>]",
   $next	= "&nbsp;&nbsp;<a href='{url}'>&raquo;&raquo;</a>",
   $nexts	= "&nbsp;&nbsp;&raquo;&raquo;",
   $last	= "&nbsp;<a href='{url}'>&raquo;&raquo;&raquo;</a>",
   $lasts	= "&nbsp;&raquo;&raquo;&raquo;"){

   // get URI parameters
   $getvars=$_SERVER['PHP_SELF']."?";
   foreach ($_GET as $key => $val){
      if ($key!=$pagevar){
         if (isset($val) && $val!=""){
            $getvars.="$key=$val&";
         }else{
            $getvars.="$key&";
         }
      }
   }

   $page = (is_numeric($_GET[$pagevar])) ? $_GET[$pagevar] : 1;
   $page = ($page>$pages) ? $pages : $page;
   $prevpage = ($page>1) ? $page-1 : 1;
   $nextpage = ($page < $pages) ? $page+1 : $pages;
   $paging = "";

   if ($pages>1){
      // first
      $paging .= ($page>1) ? str_replace("{url}", "$getvars$pagevar=1", $first) : $firsts;
      // prev
      $paging .= ($page>1) ? str_replace("{url}", "$getvars$pagevar=$prevpage", $prev) : $prevs;

      // pages		
      $ppvrange = ceil($page/$ppv);
      $start = ($ppvrange-1)*$ppv;
      $end = ($ppvrange-1)*$ppv+$ppv;
      $end = ($end>$pages) ? $pages : $end;
      $paging .= ($start>1) ? str_replace("{url}", "$getvars$pagevar=".($start-1), $more).$sep : "";
      for ($i=1; $i<=$pages; $i++){
         if ($i>$start && $i<= $end){
            $paging .= ($page==$i) ? str_replace("{page}", $i, $nums).(($i<$end) ? $sep : "") : str_replace(array("{url}", "{page}"), array("$getvars$pagevar=$i", $i), $num).(($i<$end) ? $sep : "");
         }
      }
      $paging .= ($end<$pages) ? $sep.str_replace("{url}", "$getvars$pagevar=".($end+1), $more) : "" ;

      // next
      $paging .= ($page<$pages) ? str_replace("{url}", "$getvars$pagevar=$nextpage", $next) : $nexts;
      // last
      $paging .= ($page<$pages) ? str_replace("{url}", "$getvars$pagevar=$pages", $last) : $lasts;
   }

   return $paging;
}



// ************************** MAIN ****************************
// ************************************************************

// init
$foo = file($dat);
$stuff = new mdasort;
$stuff->sortkeys = array(array('time','DESC'));

if (count($foo) == 0){
   $empty = true;
   $nextindex = 1;
}else{
   $i=0;
   foreach ($foo as $line){
      $line = explode("|", rtrim($line));
      $stuff->data[$i] = array("id" => $line[0], "time" => $line[1], "name" => $line[2], "email" => $line[3], "www" => $line[4], "post" => $line[5]);
      $i++;
   }
   $stuff->sortkeys = array(array('id','DESC'));
   $stuff->msort();
   $foo = current($stuff->data);
   $nextindex = $foo['id']+1;
   $stuff->sortkeys = array(array('time','DESC'));
   $stuff->msort();
   $numposts = count($stuff->data);
}
echo "\n\n<!-- start signme $version -->\n\n";
echo "<div class='signme' align='center'>";
clearoldadmins();
showmenu();



// admin stuff
if ($do == "admin") {

   if ($action == "login"){
   if ($name == $adminname && $pwd == $adminpwd){
         include($log);

         $fp=fopen($log, "w");
         fputs($fp, "<?\n");
         $i=0;
         if (count($admins)>0){
            foreach ($admins as $line){
               fputs($fp, "\$admins[$i]['time']=".$line[time]."; \$admins[$i]['hash']='".$line['hash']."';\n");			
               $i++;
            }
         }
         fputs($fp, "\$admins[$i]['time']=".$now."; \$admins[$i]['hash']='".md5($hash)."';\n?>");			
         fclose($fp);

         echo "<meta http-equiv='refresh' content='0;URL=$me$getvars' />";
      }
   }
   if ($action == "delete" && isloggedin()){
      $todel = getkey($id, $stuff);
      unset($stuff->data[$todel]);
      $stuff->msort();
      saveposts($stuff);
      $do = "view";

   }else{
   
		// show admin login form
		echo "<script language='JavaScript' type='text/javascript'>window.onload = function() {document.formSMlogin.name.focus();}</script>\n";
		echo "<form action='$me$getvars' method='post' name='formSMlogin' class='txt'>\n";
		echo "<table border='0' cellpadding='0' cellspacing='2' class='logintable'>\n";
		echo "<tr>\n";
		echo "<td colspan='2'><strong>$txtlogincap</strong><br /><br /></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>$txtlogin&nbsp;</td>\n";
		echo "<td>\n";
		echo "<input name='name' type='text' id='name' size='20' class='input'>\n";
		echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>$txtpassword&nbsp;</td>\n";
		echo "<td>\n";
		echo "<input name='pwd' type='password' id='pwd' size='20' class='input'>\n";
		echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>\n";
		echo "<input type='submit' name='Submit' value='$txtloginbutton' class='submit'>\n";
		echo "<input name='do' type='hidden' id='do' value='admin'>\n";
		echo "<input name='action' type='hidden' id='action' value='login'>\n";
		echo "</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "</form>\n";
		
   }
}


// sign post
if ($do == $submitCmd){
   
   if ($action == "save"){

      // check form fields
      $error = false;
      $saveit = false;
      if ($name == "") $error.="<br>&raquo; $txtbadname";
      if ($email != ""){ if (!validemail($email)) $error.="<br>&raquo;  $txtbademail"; }
      if ($msg == "") $error.="<br>&raquo;  $txtbadmsg";

      if (!isloggedin()){

         //check the CAPTCHA
         if ($captcha === true){
            if ($keyword == ""){
               $error.="<br>&raquo;  $txtmisscaptcha";
               unset($_SESSION['captcha_hash']);
            } else {
               if ($captcha_case === true){
                  $keyword = strtolower($keyword);
               }
               $keyword_hash = md5($keyword);
               if ($keyword_hash != $_SESSION['captcha_hash']) $error.="<br>&raquo;  $txtbadcaptcha";
               $keyword = "";
               $keyword_hash = "";
               unset($_SESSION['captcha_hash']);
            }
         }

         if ($msgfilter != ""){
            $needles = explode(",", $msgfilter);
            foreach ($needles as $needle){
               if (strpos(strtolower($msg), $needle) !== false){
                  $error.="<br>&raquo;  $txtmsgfiltermatch -( <strong>$needle</strong> )-";
                  break;
               }
            }
         }
         if (($wordcount === true) && (!isloggedin())){
            $words = explode(" ", $msg);
            $word_total = count($words);
            if ($word_total > $maxwords){
               $error.="<br>&raquo; $txtwordcounterror";
            }
         }
         if (($charactercount === true) && (!isloggedin())){
            $character_total = strlen($msg);
            if ($character_total > $maxchars){
               $error.="<br>&raquo; $txtcharcounterror";
            }
         }
      }

      if ($error === false){

         if ($id == "new"){
            $index = $numposts;
            $id = $nextindex;
            $time = $now;
            $saveit = true;
         }else if (isloggedin() && is_numeric($id)){
            $index = getkey($id, $stuff);
            $saveit = true;
         }

         if ($saveit){
            $stuff->data[$index]['id'] = $id;
            $stuff->data[$index]['time'] = $time;
            $stuff->data[$index]['name'] = htmlentities(strip_tags($name), ENT_QUOTES);
            $stuff->data[$index]['email'] = strip_tags($email);
            if ($www!="http://")	$stuff->data[$index]['www'] = strip_tags($www);
            else $stuff->data[$index]['www'] = "";
            
			if (isloggedin()){
               $stuff->data[$index]['post'] = str_replace(array("\r", "\n"), array("", "<br>"), $msg);
            }else{
               $stuff->data[$index]['post'] = str_replace(array("\r", "\n"), array("", "<br>"), htmlentities(strip_tags($msg), ENT_QUOTES));
            }
            
			saveposts($stuff);
            $stuff->msort();
            $empty = false;
         }


         //email notification function
         if (($emailnotify === true) && (!isloggedin()) && ($email_subject != "") && ($email_to != "")){
            if ($email != ""){
               $email_from = strip_tags($email);
            }
            $email_header = "From: $email_from\n";
            $email_header.= "X-SignMe: www.planetluc.com\n";
            $email_header.= "MIME-Version: 1.0\r\n";
            
            $match = array("{name}", "{time}", "{guestbook}", "{post}");
            $replace_text = array(stripslashes(strip_tags($name)), strftime($dateformat, $time), $guestbook, str_replace("\r", "", stripslashes(strip_tags($msg))));
            $replace_HTML = array(stripslashes(strip_tags($name)), strftime($dateformat, $time), $guestbook, str_replace(array("\r", "\n"), array("", "<br>"), stripslashes(strip_tags($msg))));
            
            if ($emailHTML === true){
               $mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
               $email_header.= "Content-Type: multipart/alternative;\n";
               $email_header.= " boundary=\"{$mime_boundary}\"\r\n";
               
               $templates = implode("", file($template));
               $tpl_plaintext = getTemplate("EMAIL_PLAINTEXT", $templates);
               $tpl_HTML = getTemplate("EMAIL_HTML", $templates);
               
               $email_body = "This is a multi-part message in MIME format.\n\n";
               $email_body.= "--{$mime_boundary}\n";
               $email_body.= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
               $email_body.= "Content-Transfer-Encoding: 7bit\n";
               $email_body.= str_replace($match, $replace_text, $tpl_plaintext)."\n\n";
               $email_body.= "--{$mime_boundary}\n";
               $email_body.= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
               $email_body.= "Content-Transfer-Encoding: 7bit\n";
               $email_body.= str_replace($match, $replace_HTML, $tpl_HTML)."\n\n";
               $email_body.= "--{$mime_boundary}--";              
               
            }else{
               $email_header.= "Content-Type: text/plain; charset=ISO-8859-1";
               $email_header.= "Content-Transfer-Encoding: 7bit\n";
               
               $templates = implode("", file($template));
               $tpl_plaintext = getTemplate("EMAIL_PLAINTEXT", $templates);
               
               $email_body = str_replace($match, $replace_text, $tpl_plaintext);
            }
			
         	mail($email_to, $email_subject, $email_body, $email_header);
         }


         $submitCmd = "";
         unset($_SESSION['submitCmd']);
         echo "<meta http-equiv='refresh' content='0;URL=$me$getvars' />";
		 die();

      }else{
         $errortxt = "<div class='txt' style='color:#cc0000;'><br/><b>$txterrors</b>$error</div><br/>";
         $name = htmlentities(stripslashes($name), ENT_QUOTES);
         $msg = htmlentities(stripslashes($msg), ENT_QUOTES);
      }
	  
	  
	// end 'on save'  
	  

	}elseif ($action == "edit" && isloggedin()){
		$post = $stuff->data[getkey($id, $stuff)];
		$name = stripslashes(html_entity_decode($post['name'], ENT_NOQUOTES));
		$email = $post['email'];
		$www = $post['www'];
		$msg = stripslashes(str_replace("<br>", "\n", html_entity_decode($post['post'], ENT_QUOTES)));
		$time = $post['time'];
		$errortxt = "";
	}else{
		$name = "";
		$email = "";
		$www = "";
		$msg = "";
		$time = "notset";
		$id = "new";
		$errortxt = "";
	}

	echo "$errortxt";
	
	// start outputting the sign form
	
	echo "<form name='formSMsign' method='post' action='$me$getvars'>\n";
	echo "<script language='JavaScript' type='text/javascript'>\n";


	// JS character counter
	if (($charactercount === true) && (is_numeric($maxchars) !== false) && (!isloggedin())){
		
		$txtcharactercount = str_replace("{countdown}", "<span id=\"charcount\"></span>", $txtcharactercount);
		$characterdiv = "<div class=\"count\">".$txtcharactercount."</div>";
		$characterjava = "countChar(document.formSMsign.msg);";
	
		echo "function countChar(field) {\n";
		echo "	if (field.value.length > $maxchars){ // if too long...trim it!\n";
		echo "		field.value = field.value.substring(0, $maxchars);\n";
		echo "	} else { // otherwise, update 'charcount' counter\n";
		echo "		document.getElementById('charcount').innerHTML = $maxchars - field.value.length;\n";
		echo "	}\n";
		echo "}\n";
		
	} else {
	  
	   $txtcharactercount = "";
	   $characterdiv = "";
	   $characterjava = "";
	
	}
	
	// JS word counter
	if (($wordcount === true) && (is_numeric($maxwords) !== false) && (!isloggedin())){
	
		$txtwordcount = str_replace("{countdown}", "<span id=\"wordcount\"></span>", $txtwordcount);
		$worddiv = "<div class=\"count\">".$txtwordcount."</div>";
		$wordjava = "countWord(document.formSMsign.msg);";
	
		echo "function countWord(field) {\n";
		echo "	var formwords = field.value;\n";
		echo "	if (formwords == ''){\n";
		echo "		formwords.length = 0;\n";
		echo "	} else {\n";
		echo "		formwords = formwords.split(' ');\n";
		echo "	}\n";
		echo "	if (formwords.length > $maxwords){ // if too long...trim it!\n";
		echo "		formwords = formwords.slice(0,$maxwords);\n";
		echo "		formwords = formwords.join(' ');\n";
		echo "		field.value = formwords;\n";
		echo "	} else { // otherwise, update 'wordcount' counter\n";
		echo "		document.getElementById('wordcount').innerHTML = $maxwords - formwords.length;\n";
		echo "	}\n";
		echo "}\n";
	
	} else {
		
		$txtwordcount = "";
		$worddiv = "";
		$wordjava = "";

	} 


	echo "window.onload = function(){document.formSMsign.name.focus();$wordjava $characterjava}</script>\n";
	echo "<table border='0' cellpadding='2' cellspacing='0' class='signtable'>\n";
	echo "<tr>\n";
	echo "<td>$txtname*&nbsp;</td>\n";
	echo "<td>\n";
	echo "<input name='name' type='text' id='name' value='$name' size='20' maxlength='40' class='input'>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>$txtemail&nbsp;</td>\n";
	echo "<td>\n";
	echo "<input name='email' type='text' id='email' size='20' value='$email' class='input'>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>$txtwebsite&nbsp;</td>\n";
	echo "<td>\n";
	echo "<input name='www' type='text' id='www' size='20' value='".(($www != "") ? $www : "http://")."' class='input'>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>$txtmessage*&nbsp;</td>\n";
	echo "<td>\n";
	echo "<textarea name='msg' cols='30' rows='4' id='msg' class='field' ". (($charactercount === true || $wordcount === true) ? "onkeydowm='$wordjava$characterjava' onkeyup='$wordjava$characterjava'" : "") .">$msg</textarea>\n";
	
	// word/character counters
	if (($charactercount === true) || ($wordcount === true)){
		echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td></td>\n";
		echo "<td>\n";
		echo "$worddiv\n";
		echo "$characterdiv\n";
	}
	
	echo "</td>\n";
	echo "</tr>\n";

	
	// CAPTCHA stuff
	if (($captcha === true) && (!isloggedin())){
		echo "<tr>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td><img src='".$pathtoscript."captcha.php'></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>$txtcaptcha*</td>\n";
		echo "<td>\n";
		echo "<input name='keyword' type='text' id='keyword' size='20' value='' class='input'>\n";
		echo "</td>\n";
		echo "</tr>\n";
		if ($captcha_case === false){
			echo "<tr>\n";
			echo "<td style='padding: 0px; margin: 0px;'>&nbsp;</td>\n";
			echo "<td class='small' style='text-align: center; padding: 0px; margin: 0px;'>$txtcaptchacase</td>\n";
			echo "</tr>\n";
		}
	}

	echo "<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>$txtmandatory</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>\n";
	echo "<input type='submit' name='Submit' value='$txtsubmitbutton' class='submit'>\n";
	echo "<input name='do' type='hidden' id='do' value='$submitCmd'>\n";
	echo "<input name='action' type='hidden' id='action' value='save'>\n";
	echo "<input name='time' type='hidden' id='time' value='$time'>\n";
	echo "<input name='id' type='hidden' id='id' value='$id'>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
	
	// END show sign form
}



// display posts
if ($do == "view" || !isset($do)){
   if (!$empty){
      $templates = implode("", file($template));
		$tpl_sig = getTemplate("SIGNATURES", $templates);
      $i = 1;
      $from = (is_numeric($_GET['page'])) ? (($_GET['page']-1)*$ppp)+1 : 1;
      foreach($stuff->data as $post){
         if ($post['id'] != 0 && $i>=$from && $i< ($from+$ppp) ){
            if ($badwords != ""){
               $badwords = explode(",", $badwords);
               $post['post'] = str_ireplace($badwords, "****", $post['post']);
            }
            if ($wrap!==false) $post['post'] = wordwrap($post['post'], $wrap, " ", 1);
            $post['name'] = stripslashes($post['name']);
            $match = array("{name}", "{time}", "{website}", "{post}", "{edit}", "{delete}");
            if (isloggedin())
               $replace = array( ($post['email']!="") ? "<a href='mailto:".emailencoder($post['email'])."'>".$post['name']."</a>" : $post['name'], strftime($dateformat, $post['time']), ($post['www']!="") ? "<a href='".$post['www']."' target='_blank'>Website</a>" : "", stripslashes($post['post']), "<a href='$me$getvars&do=$submitCmd&action=edit&id=".$post['id']."'>$txtedit</a>", "<a href='$me$getvars&do=admin&action=delete&id=".$post['id']."&page=".$_GET['page']."'>$txtdelete</a>" );
            else
               $replace = array( ($post['email']!="") ? "<a href='mailto:".emailencoder($post['email'])."'>".$post['name']."</a>" : $post['name'], strftime($dateformat, $post['time']), ($post['www']!="") ? "<a href='".$post['www']."' target='_blank'>Website</a>" : "", stripslashes($post['post']), "", "" );
            $html .= str_replace($match, $replace, $tpl_sig);
         }
         $i++;
      }
      echo $html;
      $numpages = (fmod($numposts,$ppp)>0) ? floor($numposts/$ppp)+1 : ($numposts/$ppp);
      echo "<div class='txt'>";
      echo paging($numpages);
      echo "</div><br>";
   }
}


// closing div tags
// Please don't remove the 'powered by...' link
echo "<div class='small'><br /><a href='http://intuitivo.com.ar' target='_blank'>desarrollo web</a></div>";
echo "</div>";
?>
