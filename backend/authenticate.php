<?php
require_once 'config/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $remember = filter_input(INPUT_POST, 'remember');

    // Get DB instance.
    $db = getDbInstance();

    $db->where('email', $email);
    $row = $db->getOne('shop_owners');

    if ($db->count >= 1) {
        $db_password = $row['password'];
        $user_id = $row['id'];

        if (password_verify($password, $db_password)) {
            $_SESSION['user_logged_in'] = TRUE;
            $_SESSION['user_id'] = $row['id'];

            if ($remember) {
                $series_id = randomString(16);
                $remember_token = getSecureRandomToken(20);
                $encryted_remember_token = password_hash($remember_token, PASSWORD_DEFAULT);

                $expiry_time = date('Y-m-d H:i:s', strtotime(' + 30 days'));
                $expires = strtotime($expiry_time);

                setcookie('series_id', $series_id, $expires, '/');
                setcookie('remember_token', $remember_token, $expires, '/');

                $db = getDbInstance();
                $db->where('id', $user_id);

                $update_remember = array(
                    'series_id' => $series_id,
                    'remember_token' => $encryted_remember_token,
                    'expires' => $expiry_time
                );
                $db->update('shop_owners', $update_remember);
            }
            // Authentication successfull redirect user
            header('Location: index.php');
        } else {
            $_SESSION['login_failure'] = 'Неправильное email или пароль';
            header('Location: login.php');
            exit;
        }
        exit;
    } else {
        $_SESSION['user_logged_in'] = TRUE;
        $db->insert("shop_owners", array(
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT)
        ));

        $row = $db->where('email', $email)->getOne('shop_owners');
        $_SESSION['user_id'] = $row['id'];

        header('Location: index.php');
    }
} else {
    die('Method Not allowed');
}
