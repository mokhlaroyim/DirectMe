<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Get DB instance. function is defined in config.php
$db = getDbInstance();
$user = $db->where('id', $_SESSION['user_id'])->getOne('shop_owners');

if ($user == null) {
    session_destroy();

    if (isset($_COOKIE['series_id']) && isset($_COOKIE['remember_token'])) {
        clearAuthCookie();
    }
    die;
}

include_once('includes/header.php');
?>

<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light pl-5">
    <?php if ($user['is_admin'] == '1'): ?>
        <a class="navbar-brand" href="#">Панель Админа: <?= $user['first_name'] . ' ' . $user['last_name'] ?></a>
    <?php else: ?>
        <a class="navbar-brand" href="#">Панель Владельца
            Магазина: <?= $user['first_name'] . ' ' . $user['last_name'] ?></a>
    <?php endif; ?>

    <ul class="nav w-100 justify-content-end">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                Настройки
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Профиль</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Выйти</a>
            </div>
        </li>
    </ul>
</nav>

<div class="row custom_mt pl-5 pr-5">
    <div class="col-3">
        <div class="list-group" id="list-tab" role="tablist">
            <?php if ($user['is_admin'] == '1'): ?>
                <a class="list-group-item list-group-item-action active" id="list-customers-list" data-toggle="list"
                   href="#list-customers" role="tab" aria-controls="customers">Покупатели</a>
                <a class="list-group-item list-group-item-action" id="list-shops-list" data-toggle="list"
                   href="#list-shops" role="tab" aria-controls="shops">Магазины</a>
                <a class="list-group-item list-group-item-action" id="list-owners-list" data-toggle="list"
                   href="#list-owners" role="tab" aria-controls="owners">Владельцы магазинов</a>
                <a class="list-group-item list-group-item-action" id="list-sales-list" data-toggle="list"
                   href="#list-sales" role="tab" aria-controls="sales">Акции</a>
            <?php else: ?>
                <a class="list-group-item list-group-item-action" id="list-my-shops-list" data-toggle="list"
                   href="#list-my-shops" role="tab" aria-controls="my-shops">Мои магазины</a>
                <a class="list-group-item list-group-item-action" id="list-my-sales-list" data-toggle="list"
                   href="#list-my-sales" role="tab" aria-controls="my-sales">Мои акции</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-9">
        <div class="tab-content" id="nav-tabContent">
            <?php if ($user['is_admin'] == '1'): ?>
                <div class="tab-pane fade show active" id="list-customers" role="tabpanel"
                     aria-labelledby="list-customers-list">
                    <?php include('includes/pages/customers.php'); ?>
                </div>
                <div class="tab-pane fade" id="list-shops" role="tabpanel" aria-labelledby="list-shops-list">
                    <?php include('includes/pages/shops.php'); ?>
                </div>
                <div class="tab-pane fade" id="list-owners" role="tabpanel" aria-labelledby="list-owners-list">
                    <?php include('includes/pages/shop_owners.php'); ?>
                </div>
                <div class="tab-pane fade" id="list-sales" role="tabpanel" aria-labelledby="list-sales-list">
                    <?php include('includes/pages/sales.php'); ?>
                </div>
            <?php else: ?>
                <div class="tab-pane fade" id="list-my-shops" role="tabpanel" aria-labelledby="list-my-shops-list">
                    <?php include('includes/pages/shops.php'); ?>
                </div>
                <div class="tab-pane fade" id="list-my-sales" role="tabpanel" aria-labelledby="list-my-sales-list">
                    <?php include('includes/pages/sales.php'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
