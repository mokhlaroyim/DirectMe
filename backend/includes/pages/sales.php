<?php

$db = getDbInstance();
$sales = $db->join('shops', 'shops.id = sales.shop_id')->get('sales', null, 'sales.id, sales.title, sales.description, sales.icon, sales.discount, shops.name');

$db = getDbInstance();
$shops = $db->get('shops');

if($_SESSION['response']){
    var_dump($_SESSION['response']);
}

?>

<?php if (count($sales) > 0): ?>S
    <form id="form" class="mt-3 mb-3 invisible" method="POST" style="height: 0;" action="lib/fill_db.php"
          enctype="multipart/form-data">
        <input type="hidden" value="sales" name="table">
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title" aria-describedby="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
        </div>

        <div class="form-group col-md-4 pl-0">
            <label for="shop_id">Магазин</label>
            <select id="shop_id" class="form-control" name="shop_id">
                <option value="-1" selected>Выберете магазин...</option>
                <?php foreach ($shops as $shop): ?>
                    <option value="<?= $shop['id'] ?>"><?= $shop['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="icon">Добавить иконку</label>
            <input type="file" class="form-control-file" id="icon" name="icon">
        </div>

        <div class="form-group">
            <label for="discount">Скидка</label>
            <input type="number" min="0" max="100" class="form-control" id="name" aria-describedby="discount"
                   name="discount" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Добавить</button>
    </form>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя магазина</th>
            <th scope="col">Название акции</th>
            <th scope="col">Описание акции</th>
            <th scope="col">Изображения</th>
            <th scope="col">Скидка</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sales as $sale): ?>
            <tr>
                <th scope="row"><?= $sale['id'] ?></th>
                <td><?= $sale['name'] ?></td>
                <td><?= $sale['title'] ?></td>
                <td><?= $sale['description'] ?></td>
                <?php if ($sale['icon'] != ''): ?>
                    <td>
                        <img src="assets/images/sales/<?= $sale['id'] ?>/<?= $sale['icon'] ?>" alt="images" height="35" width="35">
                    </td>
                <?php else: ?>
                    <td>
                        Нету иконок.
                    </td>
                <?php endif; ?>
                <td><?= $sale['discount'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="pl-3 pr-3 row justify-content-between">
        <h3 class="font-weight-light text-left">Нет акций.</h3>
        <button type="button" class="btn btn-primary" onclick="setFormVisibility()">Добавить магазин</button>
    </div>

    <form style="height: 0;" class="mt-3 mb-3" method="POST" action="lib/fill_db.php"
          enctype="multipart/form-data">
        <input type="hidden" value="sales" name="table">
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title" aria-describedby="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
        </div>

        <div class="form-group col-md-4 pl-0">
            <label for="shop_id">Магазин</label>
            <select id="shop_id" class="form-control" name="shop_id">
                <option value="-1" selected>Выберете магазин...</option>
                <?php foreach ($shops as $shop): ?>
                    <option value="<?= $shop['id'] ?>"><?= $shop['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="icon">Добавить иконку</label>
            <input type="file" class="form-control-file" id="icon" name="icon">
        </div>

        <div class="form-group">
            <label for="discount">Скидка</label>
            <input type="number" min="0" max="100" class="form-control" id="name" aria-describedby="discount"
                   name="discount" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Добавить</button>
    </form>
<?php endif; ?>

<script>
    function setFormVisibility() {
        if (document.getElementById('form').classList.contains('invisible')) {
            document.getElementById('form').classList.remove('invisible')
            document.getElementById('form').classList.add('visible')
            document.getElementById('form').style.height = "100%"
        } else {
            document.getElementById('form').classList.remove('visible')
            document.getElementById('form').classList.add('invisible')
            document.getElementById('form').style.height = "0"
        }
    }
</script>
