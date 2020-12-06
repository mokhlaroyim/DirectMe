<?php
session_start();
require_once 'config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));

// If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE) {
    header('Location: index.php');
}

// If user has previously selected "remember me option": 
if (isset($_COOKIE['series_id']) && isset($_COOKIE['remember_token'])) {
    // Get user credentials from cookies.
    $series_id = filter_var($_COOKIE['series_id']);
    $remember_token = filter_var($_COOKIE['remember_token']);
    $db = getDbInstance();
    // Get user By series ID:
    $db->where('series_id', $series_id);
    $row = $db->getOne('shop_owners');

    if ($db->count >= 1) {
        // User found. verify remember token
        if (password_verify($remember_token, $row['remember_token'])) {
            // Verify if expiry time is modified.
            $expires = strtotime($row['expires']);

            if (strtotime(date()) > $expires) {
                // Remember Cookie has expired.
                clearAuthCookie();
                header('Location: login.php');
                exit;
            }

            $_SESSION['user_logged_in'] = TRUE;
            header('Location: index.php');
            exit;
        } else {
            clearAuthCookie();
            header('Location: login.php');
            exit;
        }
    } else {
        clearAuthCookie();
        header('Location: login.php');
        exit;
    }
}
?>
<?php include BASE_PATH . '/includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="card col-md-6 p-0">
            <h5 class="card-header">Пожалуйста войдите</h5>
            <div class="card-body">
            <form  method="POST" action="authenticate.php">
                <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input type="email" class="form-control" id="email" name="email" required='required'>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required='required'>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name='remember' value="1">
                    <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
                </div>
                <?php if (isset($_SESSION['login_failure'])): ?>
                    <div class="alert alert-danger alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php
                        echo $_SESSION['login_failure'];
                        unset($_SESSION['login_failure']);
                        ?>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>     
    </div>
</div>

<?php include BASE_PATH . '/includes/footer.php'; ?>
