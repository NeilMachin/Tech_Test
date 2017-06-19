<HTML>

<HEAD>
<TITLE>login</TITLE>
<style>
.error {color: red ; font-weight: bold}
</style>
</HEAD>

<BODY>

<?php

/*
 *  Get current values and errors errors when redisplaying after failed validation
 */
if(!isset($_SESSION['validEmployee'])) $_SESSION['validEmployee'] = '';
if(!isset($_SESSION['validPassword'])) $_SESSION['validPassword'] = '';
if(!isset($_SESSION['errorEmployee'])) $_SESSION['errorEmployee'] = '';
if(!isset($_SESSION['errorPassword'])) $_SESSION['errorPassword'] = '';
if(!isset($_SESSION['errorNotFound'])) $_SESSION['errorNotFound'] = '';

/*
 *  Display the form
 */
echo "<h1>Login</h1>\n";
echo "<form action='oin_login_action.php' method='POST'>\n";
echo "<table border=0 cellpadding=2 cellspacing=2>\n";
echo " <tr>\n";
echo "  <td>Employee ID:</td>\n";
echo "  <td><input type='text' name='employee_id' value='{$_SESSION['validEmployee']}'></td>\n";
echo "  <td class='error'>{$_SESSION['errorEmployee']}</td>\n";
echo " <tr>\n";
echo " <tr>\n";
echo "  <td>Password:</td>\n";
echo "  <td><input type='text' name='pass' value='{$_SESSION['validPassword']}'></td>\n";
echo "  <td class='error'>{$_SESSION['errorPassword']}</td>\n";
echo " </tr>\n";
echo " <tr>\n";
echo "  <td colspan=2 align='center'><input type='submit' value='Logon'></td>\n";
echo "  <td>&nbsp;</td>\n";
echo " <tr>\n";
echo "</table>\n";
echo "</form>\n";
echo "<br>\n";
echo "<span class='error'>{$_SESSION['errorNotFound']}</span>";

?>

</BODY>
</HTML>