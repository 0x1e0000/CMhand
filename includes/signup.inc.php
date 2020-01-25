<?php
if (isset($_POST['signup-submit'])) {
    //Connect to database
    require 'dbh.inc.php';

    //Declar values from input fields.
    $firstname = strtolower($_POST['firstname']);
    $lastname = strtolower($_POST['lastname']);
    $username = strtolower($_POST['username']);
    $email = strtolower($_POST['email']);
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];
    $gender = $_POST['gender'];

    //check an empty fields
    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($country) || ctype_space($firstname) || ctype_space($lastname) || ctype_space($username) || ctype_space($email)) {
        header('Location: ../signup.php?error=emptyFields&firstname=' . $firstname . '&lastname=' . $lastname . '&username=' . $username . '&country=' . $country . '&phone=' . $phone . '&email=' . $email . '&gender=' . $gender);
        exit();
    } //chack validation Email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../signup.php?error=invalidEmail&firstname=' . $firstname . '&lastname=' . $lastname . '&username=' . $username . '&country=' . $country . '&phone=' . $phone . '&gender=' . $gender);
        exit();
    } //check invalid firstname
    elseif (strlen($firstname) < 2 || strlen($firstname) > 50) {
        header('Location: ../signup.php?error=invalidFirstNameStr&email=' . $email . '&lastname=' . $lastname . '&username=' . $username . '&country=' . $country . '&phone=' . $phone . '&gender=' . $gender);
        exit();
    } //check invalid firstname
    elseif (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
        header('Location: ../signup.php?error=invalidFirstName&email=' . $email . '&lastname=' . $lastname . '&username=' . $username . '&country=' . $country . '&phone=' . $phone . '&gender=' . $gender);
        exit();
    } //check invalid lastname
    elseif (strlen($lastname) < 2 || strlen($lastname) > 50) {
        header('Location: ../signup.php?error=invalidLastNameStr&email=' . $email . '&firstname=' . $firstname . '&username=' . $username . '&country=' . $country . '&phone=' . $phone . '&gender=' . $gender);
        exit();
    }
    elseif (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
        header('Location: ../signup.php?error=invalidLastName&email=' . $email . '&firstname=' . $firstname . '&username=' . $username . '&country=' . $country . '&phone=' . $phone . '&gender=' . $gender);
        exit();
    }
    elseif (strlen($username) < 6 || strlen($username) > 50) {
        header('Location: ../signup.php?error=invalidUsernameStr&email=' . $email . '&firstname=' . $firstname . '&lastname=' . $lastname . '&country=' . $country . '&phone=' . $phone . '&gender=' . $gender);
        exit();
    } //check invalid username
    elseif (!preg_match("/^[a-zA-Z0-9._-]*$/", $username)) {
        header('Location: ../signup.php?error=invalidUsername&email=' . $email . '&firstname=' . $firstname . '&lastname=' . $lastname . '&country=' . $country . '&phone=' . $phone . '&gender=' . $gender);
        exit();
    }
    elseif (strlen($phone) < 10 || strlen($phone) > 20) {
      header('Location: ../signup.php?error=invalidPhoneStr&email=' . $email . '&username=' . $username . '&firstname=' . $firstname . '&lastname=' . $lastname . '&phone=' . $phone . '&country=' . $country . '&gender=' . $gender);
      exit();
    } //check invalid phone number
    elseif (!preg_match("/^[0-9]*$/", $phone)) {
        header('Location: ../signup.php?error=invalidPhone&email=' . $email . '&firstname=' . $firstname . '&lastname=' . $lastname . '&username=' . $username . '&country=' . $country . '&gender=' . $gender);
        exit();
    }
    elseif (strlen($password) < 8) {
      header('Location: ../signup.php?error=CheckPwdStr&email=' . $email . '&username=' . $username . '&firstname=' . $firstname . '&lastname=' . $lastname . '&phone=' . $phone . '&country=' . $country . '&gender=' . $gender);
      exit();
    } //check password equality
    elseif ($password !== $passwordRepeat) {
      header('Location: ../signup.php?error=CheckPwd&email=' . $email . '&username=' . $username . '&firstname=' . $firstname . '&lastname=' . $lastname . '&phone=' . $phone . '&country=' . $country . '&gender=' . $gender);
      exit();
    } elseif (!isset($_POST['gender'])) {
        header('Location: ../signup.php?error=genderNotSelected&email=' . $email . '&firstname=' . $firstname . '&lastname=' . $lastname . '&username=' . $username . '&phone=' . $phone . '&country=' . $country . '&gender=' . $gender);
        exit();
    } else {
        //setup info for inserting to database
        //check existing username and email in database
        $query = 'SELECT username_Users, email_Users FROM users WHERE username_Users = ? OR email_Users = ?;';
        $stmt = mysqli_stmt_init($connect);
        //Check sql Errors
        if (!mysqli_stmt_prepare($stmt, $query)) {
            header('Location: ../signup.php?error=sqlError&email=' . $email . '&firstname=' . $firstname . '&lastname=' . $lastname . '&username=' . $username . '&phone=' . $phone . '&country=' . $country . '&gender=' . $gender);
            exit();
        } else {
            //if $query is work
            mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            //selected rows
            if ($resultCheck > 0) {
                header('Location: ../signup.php?error=usernameOrEmailTaken&email=' . $email . '&firstname=' . $firstname . '&lastname=' . $lastname . '&username=' . $username . '&phone=' . $phone . '&country=' . $country . '&gender=' . $gender);
                exit();
            } else {
                //no row selected
                $query = 'INSERT INTO users (firstname_Users, lastname_Users, username_Users, email_Users, country_Users, phone_Users, password_Users, gender_Users, joinDate_Users) Values (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_DATE);';
                $stmt = mysqli_stmt_init($connect);
                //Check sql Errors
                if (!mysqli_stmt_prepare($stmt, $query)) {
                    header('Location: ../signup.php?error=sqlError&email=' . $email . '&firstname=' . $firstname . '&lastname=' . $lastname . '&username=' . $username . '&phone=' . $phone . '&country=' . $country . '&gender=' . $gender);
                    exit();
                } else {
                    //if $query is work
                    //hash the PASSWORD
                    $pswhashed = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, 'ssssssss', $firstname, $lastname, $username, $email, $country, $phone, $pswhashed, $gender);
                    mysqli_stmt_execute($stmt);
                    header('Location: ../signup.php?signup=success');
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
} else {
    header('Location: ../signup.php');
    exit();
}
