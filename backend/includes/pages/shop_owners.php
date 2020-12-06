<?php

$db = getDbInstance();
$owners = $db->where('is_admin', 0)->get('shop_owners');

?>

<?php if (count($owners) > 0): ?>
    <div class="pl-3 pr-3 mb-3 row justify-content-between">
        <h3 class="font-weight-light text-left">Количество владельцев: <?= count($owners) ?></h3>
        <button type="button" class="btn btn-primary" onclick="setFormOwnersVisibility()">Добавить владельца</button>
    </div>

    <form id="form_owners" class="mt-3 mb-3 invisible" action="lib/fill_db.php" method="POST" style="height: 0">
        <input type="hidden" value="shop_owners" name="table">
        <div class="form-group">
            <label for="first_name">Имя</label>
            <input type="text" class="form-control" id="first_name" aria-describedby="first_name" name="first_name">
        </div>
        <div class="form-group">
            <label for="last_name">Фамилия</label>
            <input type="text" class="form-control" id="last_name" aria-describedby="last_name" name="last_name">
        </div>

        <div class="form-group">
            <label for="phone_number">Номер телефона</label>
            <input type="text" class="form-control" id="phone_number"
                   aria-describedby="phone_number" name="phone_number">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="email" name="email">
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" id="password" aria-describedby="password" name="password">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Добавить</button>
    </form>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Полное имя</th>
            <th scope="col">Номер телефона</th>
            <th scope="col">Email</th>
            <th scope="col">Магазины</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($owners as $owner): ?>
            <tr>
                <th scope="row"><?= $owner['id'] ?></th>
                <td><?= $owner['first_name'] . ' ' . $owner['last_name'] ?></td>
                <td><?= $owner['phone_number'] ?></td>
                <td><?= $owner['email'] ?></td>
                <td>Посмотреть</td>
                <td>
                    <form action="lib/remove_db.php" method="POST">
                        <input type="hidden" value="<?= $owner['id'] ?>" name="owner_id">
                        <input type="hidden" value="shop_owners" name="table">
                        <button type="submit" class="btn btn-danger">X</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <h3 class="font-weight-light text-left">Нет владельцев.</h3>

    <form class="mt-3" action="lib/fill_db.php" method="POST">
        <input type="hidden" value="shop_owners" name="table">
        <div class="form-group">
            <label for="first_name">Имя</label>
            <input type="text" class="form-control" id="first_name" aria-describedby="first_name" name="first_name">
        </div>
        <div class="form-group">
            <label for="last_name">Фамилия</label>
            <input type="text" class="form-control" id="last_name" aria-describedby="last_name" name="last_name">
        </div>

        <div class="form-group">
            <label for="phone_number">Номер телефона</label>
            <input type="text" class="form-control" id="phone_number"
                   aria-describedby="phone_number" name="phone_number">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="email" name="email">
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" id="password" aria-describedby="password" name="password">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Добавить</button>
    </form>
<?php endif; ?>


<script>
    function setFormOwnersVisibility() {
        if(document.getElementById('form_owners').classList.contains('invisible')){
            document.getElementById('form_owners').classList.remove('invisible')
            document.getElementById('form_owners').classList.add('visible')
            document.getElementById('form_owners').style.height = "100%"
        }else{
            document.getElementById('form_owners').classList.remove('visible')
            document.getElementById('form_owners').classList.add('invisible')
            document.getElementById('form_owners').style.height = "0"
        }
    }
</script>