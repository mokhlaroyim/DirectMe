<?php

$db = getDbInstance();
$customers = $db->get('customers');

?>

<?php if (count($customers) > 0): ?>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Номер телефона</th>
            <th scope="col">СМС код</th>
            <th scope="col">Подверждено</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <th scope="row"><?= $customer['id'] ?></th>
                <td><?= $customer['phone_number'] ?></td>
                <td><?= $customer['sms_code'] ?></td>
                <?php if ($customer['is_verified'] == 1): ?>
                    <td>Да</td>
                <?php else: ?>
                    <td>Нет</td>
                <?php endif; ?>
                <td>Посмотреть</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <h3 class="font-weight-light text-left">Нет покупателей.</h3>
<?php endif; ?>
