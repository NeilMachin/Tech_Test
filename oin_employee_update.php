<?php
session_start();
if(!isset($_SESSION['employee_id'])){header('Location: oin_login.php');}
?>

<HTML>

<HEAD>
<TITLE>Employee Details Update</TITLE>
<style>
.error {
    color: red;
    font-weight: bold;
}
</style>
</HEAD>

<BODY>


<?php
require('connect_db.php');

$errorAdmin       = "";
$errorForename    = "";
$errorSurname     = "";
$errorSalary      = "";
$errorPassword    = "";
$errorActive      = "";
$errorEmail       = "";
$errorDOB         = "";

$validAdmin       = "";
$validForename    = "";
$validSurname     = "";
$validSalary      = "";
$validPassword    = "";
$validActive      = "";
$validEmail       = "";
$validSalary      = "";
$validDOB         = "";
$validHobby       = "";


/*
 *  If calling method is POST then validate all fields. If no errors found then update the employee record
 */
if($_SERVER['REQUEST_METHOD']=="POST") {
    $validDeptName = $_POST['dep_name'];
    $validAdmin = $_POST['emp_admin'];
    
    if(empty($_POST['emp_forename'])) {$errorForename = "Entry required";}  else {$validForename = $_POST['emp_forename'];}

    if(empty($_POST['emp_surname'])) {$errorSurname = "Entry required";}  else {$validSurname = $_POST['emp_surname'];}

    if(empty($_POST['emp_salary'])) {$errorSalary = "Entry required";}
    elseif(!is_numeric($_POST['emp_salary'])) {$errorSalary = "Must be numeric";}
    else {$validSalary = $_POST['emp_salary'];}

    if(empty($_POST['emp_password'])) {$errorPassword = "Entry required";}  
    elseif(strlen($_POST['emp_password'])<8) {$errorPassword = "Password must be at least 8 characters";}  
    else {$validPassword = $_POST['emp_password'];}

    if(empty($_POST['emp_email'])) {$errorEmail = "Entry required";}
    elseif(!filter_var($_POST['emp_email'], FILTER_VALIDATE_EMAIL)) {$errorEmail = "Enter a valid email address";}
    else {$validEmail = $_POST['emp_email'];}
    
if (!preg_match("/^(((((1[26]|2[048])00)|[12]\d([2468][048]|[13579][26]|0[48]))-((((0[13578]|1[02])-(0[1-9]|[12]\d|3[01]))|((0[469]|11)-(0[1-9]|[12]\d|30)))|(02-(0[1-9]|[12]\d))))|((([12]\d([02468][1235679]|[13579][01345789]))|((1[1345789]|2[1235679])00))-((((0[13578]|1[02])-(0[1-9]|[12]\d|3[01]))|((0[469]|11)-(0[1-9]|[12]\d|30)))|(02-(0[1-9]|1\d|2[0-8])))))$/", $_POST['emp_dob'])) {$errorDOB = "Enter valid date in yyyy-mm-dd format";} else {$validDOB = $_POST['emp_dob'];}

    $validActive = $_POST['emp_active'];
    $validHobby = $_POST['emp_hobby'];

    $checkErrors = $errorForename . $errorSurname . $errorSalary . $errorPassword;
    if(strlen($checkErrors)==0) {
        $sql = "update OIN_EMPLOYEE 
                set EMP_FORENAME = '$validForename', 
                    EMP_SURNAME = '$validSurname',
                    EMP_SALARY = '$validSalary',
                    EMP_PASSWORD = '$validPassword',
                    EMP_EMAIL = '$validEmail',
                    EMP_DOB = '$validDOB',
                    EMP_HOBBY = '$validHobby'
                where EMP_ID = {$_SESSION['employee_id']}";
        if ($dbc->query($sql) === TRUE) {
            // echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $dbc->error;
        }
    }

/*
 *  Else calling method was GET, pull current details from database for this employee
 */
} else { //  Request method is GET
    $sql = "select 
                EMP_ADMIN, EMP_FORENAME, EMP_SURNAME, EMP_SALARY, 
                EMP_DOB, EMP_ACTIVE, EMP_EMAIL, EMP_PASSWORD, EMP_HOBBY,
                DEP_NAME
            from 
                OIN_EMPLOYEE, OIN_DEPARTMENT
            where
                    EMP_ID = {$_SESSION['employee_id']}
                and EMP_DEP_ID = DEP_ID";
    if ($result = $dbc->query($sql)) {
        $row = $result->fetch_object();
        $validDeptName  = $row->DEP_NAME;
        $validAdmin     = $row->EMP_ADMIN;
        $validForename  = $row->EMP_FORENAME;
        $validSurname   = $row->EMP_SURNAME;
        $validSalary    = $row->EMP_SALARY;
        $validDOB       = $row->EMP_DOB;
        $validActive    = $row->EMP_ACTIVE;
        $validEmail     = $row->EMP_EMAIL;
        $validPassword  = $row->EMP_PASSWORD;
        $validHobby     = $row->EMP_HOBBY;
    }
}

/*
 *  Display the employee ID, and logoff option
 */
echo "<table border=0 width='60%'>\n";
echo " <tr>\n";
echo "  <td>Logged on as employee {$_SESSION['employee_id']}, $validForename $validSurname</td>\n";
echo "  <td width='50%'>&nbsp;</td>\n";
echo "  <td><a href='oin_logoff.php'>Log off</a></td>\n";
echo " </tr>\n";
echo "</table>\n";
echo "<br>";
echo "<br>";
echo "<br>";

?>


<!-- -->
<!--  Display form populated with current values from the DB, or just entered data, and show any validation errors  -->
<!-- -->
<form action='oin_employee_update.php' method="POST">
<table border=0 CELLPADDING=2 CELLSPACING=2>
  <tr>
    <td>Department</td>
    <td><input type="text" name="dep_name" value="<?php echo "$validDeptName"; ?>" readonly></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Admin</td>
    <td><input type="text" name="emp_admin" value="<?php echo "$validAdmin"; ?>" readonly></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Forename</td>
    <td><input type="text" name="emp_forename" value="<?php echo "$validForename"; ?>"></td>
    <td class="error"><?php echo "$errorForename"; ?></td>
  </tr>
  <tr>
    <td>Surname</td>
    <td><input type="text" name="emp_surname" value="<?php echo "$validSurname"; ?>"></td>
    <td class="error"><?php echo "$errorSurname"; ?></td>
  </tr>
  <tr>
    <td>Salary</td>
    <td><input type="text" name="emp_salary" value="<?php echo "$validSalary"; ?>"></td>
    <td class="error"><?php echo "$errorSalary"; ?></td>
  </tr>
  <tr>
    <td>Date of Birth</td>
    <td><input type="text" name="emp_dob" value="<?php echo "$validDOB"; ?>">
    <td class="error"><?php echo "$errorDOB"; ?></td>
  </tr>
  <tr>
    <td>Active</td>
    <td><input type="text" name="emp_active" value="<?php echo "$validActive"; ?>" readonly></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="emp_email" value="<?php echo "$validEmail"; ?>"></td>
    <td class="error"><?php echo "$errorEmail"; ?></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" name="emp_password" VALUE="<?php echo "$validPassword"; ?>"></td>
    <td class="error"><?php echo "$errorPassword"; ?></td>
  </tr>
  <tr>
    <td>Hobby</td>
    <td><textarea rows="4" columns="80" name="emp_hobby"><?php echo "$validHobby"; ?></textarea></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=3 align='center'><input type="submit"></td>
  </tr>
</table>
</form>

<?php
?>

</BODY>
</HTML>