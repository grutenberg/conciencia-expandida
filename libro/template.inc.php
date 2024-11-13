<!--
###################### SignMe Templates #######################
###############################################################

In the signature template block, SIGNATURES, below
you can use following replacement tags inside:

{name}            name of signer
{time}            date and time of signature
{website}         website of signer
{edit}            edit link if you're in admin mode
{delete}          delete link if you're in admin mode
{post}            message posted by signer to your website


In the email template blocks, EMAIL_PLAINTEXT & EMAIL_HTML,
below you can use following replacement tags inside:

{name}            name of signer
{time}            date and time of signature
{guestbook}       URL link to your guestbook (same as $guestbook variable in 'signme.inc.php')

###############################################################
###############################################################
-->

<!--SIGNATURES-->
<table width="450" border="0" cellspacing="0" cellpadding="1" style="margin-bottom:8px;" class="signaturetable">
	<tr  bgcolor="#eeeeee">
		<td style="border-bottom:1px dotted #bbbbbb;" align="left">{name} escrito el {time} {website}</td>
	   <td align="right" style="border-bottom:1px dotted #bbbbbb;">{edit} {delete} </td>
	</tr>
	<tr>
		<td colspan="2" align="left">{post}</td>
	</tr>
</table>
<!--SIGNATURES-->


<!--EMAIL_PLAINTEXT-->
A new signature has been added to the SignMe guestbook on mysite.com
{guestbook}

On {time} - {name} wrote:
--------------------------------------------------------------------------------
{post}
<!--EMAIL_PLAINTEXT-->


<!--EMAIL_HTML-->
<p>
   A new signature has been added to the SignMe guestbook on mysite.com
   <br />
   <a href="{guestbook}">Guestbook</a>
</p>
<p>
   On {time} - <b>{name}</b> wrote:
   <hr />
   {post}
</p>
<!--EMAIL_HTML-->