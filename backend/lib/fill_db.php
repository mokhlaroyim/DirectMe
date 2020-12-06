<?php
session_start();
include_once('../config/config.php');

if (!$_POST) {
    redirect_back();
}

switch ($_POST['table']) {
    case 'shop_owners':
        store_shop_owners($_POST);
        break;
    case 'shops':
        store_shops($_POST);
        break;
    case 'sales':
        store_sales($_POST);
        break;
}

function redirect_back($tag = null)
{
    if ($tag == null) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['activeTag'] = $tag;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

function store_sales($data){
    if (trim($data['title']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Название не указано.',
        ];
        redirect_back('list-sales');
        die;
    }

    if (trim($data['description']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Описание не указано.',
        ];
        redirect_back('list-sales');
        die;
    }

    if (trim($data['discount']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Скидка не указана.',
        ];
        redirect_back('list-sales');
        die;
    }

    if (trim($data['shop_id']) == '' || $data['shop_id'] == null || $data['shop_id'] == -1) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Магазин не указан.',
        ];
        redirect_back('list-sales');
        die;
    }

    if (empty($_FILES)) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Картинка не указана',
        ];
        redirect_back('list-sales');
        die;
    }else{
        $data['icon'] = time() . '_' . basename($_FILES["icon"]["name"]);
    }

    unset($data['table']);

    try {
        $db = getDbInstance();
        $db->insert('sales', $data);

        $id = $db->getInsertId();

        $target_dir = dirname(__DIR__) . '../assets/images/sales/' . $id;
        if (!file_exists($target_dir)) {
            if(!mkdir($target_dir)){
                $_SESSION['response'] = [
                    'status' => 'error',
                    'message'=> 'directory_not_created'
                ];

                redirect_back('list-sales');
                die;
            }
        }

        $target_file = $target_dir . '/' . $data['icon'];
        if(!move_uploaded_file($_FILES["icon"]["tmp_name"], $target_file)){
            $_SESSION['response'] = [
                'status' => 'error',
                'message'=> 'file_not_moved'
            ];

            redirect_back('list-sales');
            die;
        }

        $_SESSION['response'] = [
            'status' => 'success'
        ];
        redirect_back('list-sales');
        die;
    } catch (Exception $error) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => $error,
        ];
        redirect_back('list-sales');
        die;
    }
}

function store_shops($data)
{
    if (trim($data['name']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Название не указано.',
        ];
        redirect_back('list-shops');
        die;
    }

    if (trim($data['description']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Описание не указано.',
        ];
        redirect_back('list-shops');
        die;
    }

    if (trim($data['owner_id']) == '' || $data['owner_id'] == null) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Владелец не указан.',
        ];
        redirect_back('list-shops');
        die;
    }

    if (trim($data['floor']) == '' || $data['floor'] == null) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Этаж не указан',
        ];
        redirect_back('list-shops');
        die;
    }

    if (trim($data['sector']) == '' || $data['sector'] == null) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Сектор не указан',
        ];
        redirect_back('list-shops');
        die;
    }

    if (empty($_FILES) || !isset($_FILES['images'])) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Картинка не указана',
        ];
        redirect_back('list-shops');
        die;
    }else{
        $data['images'] = time() . '_' . basename($_FILES["images"]["name"]);
    }

    unset($data['table']);


    try {
        $db = getDbInstance();
        $db->insert('shops', $data);

        $id = $db->getInsertId();

        $target_dir = dirname(__DIR__) . '../assets/images/' . $id;
        if (!file_exists($target_dir)) {
            mkdir($target_dir);
        }

        $target_file = $target_dir . '/' . $data['images'];

        move_uploaded_file($_FILES["images"]["tmp_name"], $target_file);

        $_SESSION['response'] = [
            'status' => 'success'
        ];
        redirect_back('list-shops');
        die;
    } catch (Exception $error) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => $error,
        ];
        redirect_back('list-shops');
        die;
    }
}

function store_shop_owners($data)
{
    if (trim($data['first_name']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Имя не указано.',
        ];
        redirect_back('list_owners');
        die;
    }

    if (trim($data['last_name']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Фамилия не указана.',
        ];
        redirect_back('list_owners');
        die;
    }

    if (trim($data['phone_number']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Номер телефона не указан.',
        ];
        redirect_back('list_owners');
        die;
    }

    if (trim($data['email']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Email не указан.',
        ];
        redirect_back('list_owners');
        die;
    }

    if (trim($data['password']) == '') {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Пароль не указан.',
        ];
        redirect_back('list_owners');
        die;
    }

    unset($data['table']);
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    $data['is_admin'] = 0;

    $db = getDbInstance();
    $db->insert('shop_owners', $data);

    $_SESSION['response'] = [
        'status' => 'success'
    ];
    redirect_back('list_owners');
    die;
}