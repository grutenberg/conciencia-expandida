<?
session_start();

/*
####################### SignMe CAPTCHA ########################
###############################################################

This is the code for the CAPTCHA keyword / image
verification portion of the SignMe script.

There are some settings that you can alter to change
the variables of the CAPTCHA system located under the
'CAPTCHA settings' in the 'signme.inc.php' file

To add fonts for the CAPTCHA image, save the .ttf font
files into the folder 'fonts'.  The CAPTCHA will
automatically search through and pick at random for
each letter.  If you only want 1 font to match your site,
add that font to the folder and delete the rest.

###############################################################
###############################################################
*/


error_reporting(0);


// ************************** CONFIG **************************
// ************************************************************


//CAPTCHA variables
$min_text = 4;                         // set a range for random generation of keword length
$max_text = 6;                         // -- set $min_text and $max_text equal for a fixed keyword length
$min_lines = 3;                        // set a range for random generation of background lines
$max_lines = 8;                        // -- set $min_lines and $max_lines equal for a fixed number of background lines - (set both to '0' to remove the lines from the image)
$min_fg_ellipse = 3;                   // set a range for random generation of foreground ellipses
$max_fg_ellipse = 5;                   // -- set $min_fg_ellipse and $max_fg_ellipse equal for a fixed number of foreground ellipses - (set both to '0' to removed foreground ellipses from the image)
$min_bg_ellipse = 4;                   // set a range for random generation of background ellipses
$max_bg_ellipse = 7;                   // -- set $min_bg_ellipse and $max_bg_ellipse equal for a fixed number of foreground ellipses - (set both to '0' to removed background ellipses from the image)


// ********************************************************************************************************************************************************************
// ** DO NOT MAKE CHANGES BELOW HERE UNLESS YOU KNOW WHAT YOU'RE DOING! ***********************************************************************************************
// ********************************************************************************************************************************************************************


//clear out the variables
$captchastr = "";
$captcha_hash = "";
unset($_SESSION['captcha_hash']);

$strlength = rand($min_text,$max_text);

for($i=1;$i<=$strlength;$i++){
   if ($_SESSION['captcha_symbol'] === true){
      $textornumber = rand(1,4);
   }else{
      $textornumber = rand(1,3);
   }
   if($textornumber == 1){
      $captchastr .= chr(rand(49,57));
   }
   if($textornumber == 2){
      $captchastr .= chr(rand(65,78));
   }
   if($textornumber == 3){
      $captchastr .= chr(rand(80,90));
   }
   if($textornumber == 4){
      $symbol_array = array(35, 36, 37, 38, 42, 61, 63, 64);
      $symbol_count = count($symbol_array)-1;
      $symbol = rand(1,$symbol_count);
      $captchastr .= chr($symbol_array[$symbol]);
   }
}
$randcolR = rand(50,230);
$randcolG = rand(50,230);
$randcolB = rand(50,230);

//initialize image $captcha and size per the $captchawidth and $captchaheight
$captcha = imageCreate($_SESSION['captcha_width'], 50);

$backcolor = imageColorAllocate($captcha, $randcolR, $randcolG, $randcolB);
$txtcolor = imageColorAllocate($captcha, ($randcolR - 25), ($randcolG - 25), ($randcolB - 25));

// padding between letters
$padding =   floor($_SESSION['captcha_width'] / ($strlength + 1.5));

//add the letters, numbers, and symbols to the image
for($i=1;$i<=$strlength;$i++){

   $clockorcounter = rand(1,2);
   if ($clockorcounter == 1){
      $rotangle = rand(0,45);
   }
   if ($clockorcounter == 2){
      $rotangle = rand(315,360);
   }

   //find different fonts, count them, then select a random font to use
   $fontfiles = array();
   $dir = dirname(__FILE__);
   $font_dir = $dir."/fonts/";
   $font_handle = @opendir($font_dir) or die("Unable to open $font_dir");
      //Loop through files
      while (false !== ($fontfile = readdir($font_handle))) {
         if($fontfile == "." || $fontfile == "..")
            continue;
            $fontfiles[] = $fontfile;
      }
      closedir($font_handle);
   $font_count = count($fontfiles);
   $font_rand = (rand(1, $font_count)-1);
   $font = "fonts/".$fontfiles[$font_rand];
 

   // $i *  $padding spaces the characters 30 pixels apart
   imagettftext($captcha, rand(16,26), $rotangle,($i * $padding), 30, $txtcolor, $font, substr($captchastr,($i-1),1));
}

//make some gobblety-gook for the background of the image using lines and ellipses
if ($_SESSION['captcha_shapes'] === true){
  $image_rand = rand($min_lines,$max_lines);
  for($i=1; $i<=$image_rand;$i++){
     imageline($captcha, rand(1,250), rand(1,50), rand(1,250), rand(1,50), $txtcolor);
  }
  $ellipsetxt = rand($min_fg_ellipse,$max_fg_ellipse);
  for($i=1; $i<=$ellipsetxt;$i++){
     imageellipse($captcha, rand(1,250), rand(1,50), rand(50,100), rand(12,25), $txtcolor);
  }
  $ellipseback = rand($min_bg_ellipse,$max_bg_ellipse);
  for($i=1; $i<=$ellipseback;$i++){
     imageellipse($captcha, rand(1,250), rand(1,50), rand(50,100), rand(12,25), $backcolor);
  }
}
//Send the headers (at last possible time)
header('Content-type: image/png');
header('X-Captcha: by sidtheduck');

//Output the image as a PNG
imagePNG($captcha);

//Delete the image from memory
imageDestroy($captcha);

//get CAPTCHA hash for $_SESSION['captcha_hash'] verify
$captcha_case = $_SESSION['captcha_case'];
if ($captcha_case === true){
   $captchastr = strtolower($captchastr);
}
$captcha_hash = md5($captchastr);
$_SESSION['captcha_hash'] = $captcha_hash;

//remove any evidence of the saved captcha word variables after hashing
$captchastr = "";
$captcha_hash = "";

?>
