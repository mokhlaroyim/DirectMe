<?php
session_start();
include_once('../config/config.php');

if (!$_POST) {
    redirect_back();
}

switch ($_POST['table']) {
    case 'shop_owners':
        remove_owner($_POST);
        break;
    case 'shops':
        remove_store($_POST);
        break;
    case 'sales':
        remove_sale($_POST);
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

function remove_store($data)
{
    $db = getDbInstance();
    try {
        if(!$db->where('id', $data['shop_id'])->delete('shops', 1)){
            $_SESSION['response'] = [
                'status' => 'error',
                'message' => 'Магазин не удален.',
            ];
        }
    } catch (Exception $error) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => $error,
        ];
        redirect_back("list-shops");
        die;
    }
    $_SESSION['response'] = [
        'status' => 'success',
    ];
    redirect_back("list-shops");
    die;
}

function remove_owner($data)
{
    $db = getDbInstance();
    try {
        if(!$db->where('id', $data['owner_id'])->delete('shop_owners', 1)){
            $_SESSION['response'] = [
                'status' => 'error',
                'message' => 'Владелец не удален.',
            ];
        }
    } catch (Exception $error) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => $error,
        ];
        redirect_back("list-owners");
        die;
    }
    $_SESSION['response'] = [
        'status' => 'success',
    ];
    redirect_back("list-owners");
    die;
}

function remove_sale($data)
{
    $db = getDbInstance();
    try {
        if(!$db->where('id', $data['sale_id'])->delete('sales', 1)){
            $_SESSION['response'] = [
                'status' => 'error',
                'message' => 'Акция не удалена.',
            ];
        }
    } catch (Exception $error) {
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => $error,
        ];
        redirect_back("list-sales");
        die;
    }
    $_SESSION['response'] = [
        'status' => 'success',
    ];
    redirect_back("list-sales");
    die;
}