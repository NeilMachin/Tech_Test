<?php

function load($page = 'oin_login.php')
{
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    header("Location: $url");
    exit();
}


function validate($dbc, $employee_id = '', $pwd = '')
{
    $errors = array();
    $error = "";
    if (empty($employee_id)) {
        $errors[] = 'Enter your employee_id.';
    } else {
        $enteredId = mysqli_real_escape_string($dbc, trim($employee_id));
    }

    if (empty($pwd)) {
        $errors[] = 'Enter your password.';
    } else {
        $enteredPassword = mysqli_real_escape_string($dbc, trim($pwd));
    }

    if (empty($errors)) {
        $q = "SELECT EMP_ID
              FROM   OIN_EMPLOYEE
              WHERE      EMP_ID = '$enteredId'
                     AND EMP_PASSWORD = '$enteredPassword'";   /*  SHA1('$p')";  */

        $r = mysqli_query($dbc, $q); 
        $rows=mysqli_num_rows($r);

        if (mysqli_num_rows($r) == 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            return array(true, $row);
        }  else {
            $errors[] = 'Employee ID and password not found.';
        }
    }

    return array(false, $errors);
}
