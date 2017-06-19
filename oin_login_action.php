<?php

session_start();

$_SESSION['validEmployee'] = '';
$_SESSION['validPassword'] = '';
$_SESSION['errorEmployee'] = '';
$_SESSION['errorPassword'] = '';
$_SESSION['errorNotFound'] = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('connect_db.php');
    require('oin_login_tools.php');

    $flagValid = true;
 
    /*
     *  Check that all required inputs have a value
     */
    if(empty($_POST['employee_id'])) {
        $flagValid = false;
        $_SESSION['errorEmployee'] = 'Employee ID must be entered';
    } else {
        $_SESSION['validEmployee'] = $_POST['employee_id'];
    }

    if(empty($_POST['pass'])) {
        $flagValid = false;
        $_SESSION['errorPassword'] = 'Password ID must be entered';
    } else {
        $_SESSION['validPassword'] = $_POST['pass'];
    }

    /*
     *  If all inputs OK then validate the password entered
     */
    if($flagValid) {
        list($check, $data) = validate($dbc, $_POST['employee_id'], $_POST['pass']);
        if(!$check) {
            $flagValid = false;
            $_SESSION['errorNotFound'] = 'Employee ID and password do not match';
        }
    }

    /*
     *  If all validation passed then load the employee details update screen, else return to the logon screen
     */
    if($flagValid) {
        $_SESSION['employee_id']    = $data['EMP_ID'];
        header('Location: oin_employee_update.php');
        #load('oin_employee_update.php');
    }

    mysqli_close($dbc);
}

include('oin_login.php');

