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



The SignMe script consists of following files(-) / folders(*):
		
		* fonts
		- signme.inc.php  (mainfile)
		- captcha.php
		- data.dat
		- log.dat.php
		- template.inc.php
		- README.txt
		
		
		

******** LICENSE/CREDITS *********
**********************************

This script is free. But that doesn't mean that you 
may redistribute or even resell it in any ways
except you do have a written permission from me (Lukas Stalder). 
Also you may not remove the 'powered by...' notice at 
the script's bottom (it ain't that big, is it?).

>> Mike from www.sidtheduck.com added the great CAPTCHA functionality
>> and the word/character counters
>> and the email notification on signing the gb
>> Thank you Mike - you're the man!
		
		


********* INSTALLATION ***********
**********************************

1.	Change the variables at the beginning of the signme.inc.php file to your needs.

2.	Upload the whole distribution onto your server where you want to use the guestbook script.

3. Chmod the 2 files data.dat and log.dat.php to 777 (changing the read/write permissions of files).

4. Include the signme.inc.php file into any .php site	by adding <? include("path_to_signme/signme.inc.php");?> 
	to your code (where 'path_to_signme' is to be changed to your needs). 
	Additionally add <? session_start(); ?> at the very top of this page (before <html> and <doctype> and stuff!)
	Now point your browser to the file where you included the script and you're done.
	
	That's it!
	
	
	
	
		
************ SUPPORT *************
**********************************

For support requests please use the BOARDS on
http://www.planetluc.com/forum/ (post in the appropriate 
forums please!)
