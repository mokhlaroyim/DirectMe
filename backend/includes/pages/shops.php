<?php

$db = getDbInstance();
$shops = $db->join('shop_owners', 'shops.owner_id = shop_owners.id', 'INNER')->get('shops', null, 'shops.id, shops.name, shops.description, shops.images, shops.floor, shops.sector, shop_owners.first_name, shop_owners.last_name');

$db = getDbInstance();
$owners = $db->where('is_admin', 0)->get('shop_owners');

include_once('includes/data.php');

global $floor_data;
?>

<?php if (count($shops) > 0): ?>
    <div class="row justify-content-end">
        <button type="button" class="btn btn-primary" onclick="setFormVisibility()">Добавить магазин</button>
    </div>

    <form id="form" style="height: 0;" class="mt-3 mb-3 invisible" method="POST" action="lib/fill_db.php"
          enctype="multipart/form-data">
        <input type="hidden" value="shops" name="table">
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" aria-describedby="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="images">Добавить изображение</label>
            <input type="file" class="form-control-file" id="images" name="images">
        </div>

        <div class="form-group col-md-4 pl-0">
            <label for="owner_id">Владелец</label>
            <select id="owner_id" class="form-control" name="owner_id">
                <option value="-1" selected>Выберете владельца...</option>
                <?php foreach ($owners as $owner): ?>
                    <option value="<?= $owner['id'] ?>"><?= $owner['first_name'] . ' ' . $owner['last_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-4 pl-0">
            <label for="floor">Этаж</label>
            <select id="floor" class="form-control" name="floor">
                <option value="-1" selected>Выберете этаж...</option>
                <?php foreach ($floor_data as $key => $floor): ?>
                    <option value="<?= $key ?>"><?= $key ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-4 pl-0">
            <label for="sector">Сектор</label>
            <select id="sector" class="form-control" name="sector">
                <option value="-1" selected>Выберете сектор...</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Добавить</button>
    </form>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Название</th>
            <th scope="col">Описание</th>
            <th scope="col">Изображения</th>
            <th scope="col">Имя владельца</th>
            <th scope="col">Этаж</th>
            <th scope="col">Сектор</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($shops as $shop): ?>
            <tr>
                <th scope="row"><?= $shop['id'] ?></th>
                <td><?= $shop['name'] ?></td>
                <td><?= $shop['description'] ?></td>
                <?php if ($shop['images'] != ''): ?>
                    <td>
                        <img src="assets/images/<?= $shop['id'] ?>/<?= $shop['images'] ?>" alt="images" height="35" width="35">
                    </td>
                <?php else: ?>
                    <td>
                        Нету изображений.
                    </td>
                <?php endif; ?>

                <td><?= $shop['first_name'] . ' ' . $shop['last_name'] ?></td>
                <td><?= $shop['floor'] ?></td>
                <td><?= $shop['sector'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="pl-3 pr-3 row justify-content-between">
        <h3 class="font-weight-light text-left">Нет магазинов.</h3>
        <button type="button" class="btn btn-primary">Добавить магазин</button>
    </div>

    <form class="mt-3" method="POST" action="lib/fill_db.php" enctype="multipart/form-data">
        <input type="hidden" value="shops" name="table">
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" aria-describedby="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="images">Добавить изображение</label>
            <input type="file" class="form-control-file" id="images" name="images">
        </div>

        <div class="form-group col-md-4 pl-0">
            <label for="owner_id">Владелец</label>
            <select id="owner_id" class="form-control" name="owner_id">
                <option value="-1" selected>Выберете владельца...</option>
                <?php foreach ($owners as $owner): ?>
                    <option value="<?= $owner['id'] ?>"><?= $owner['first_name'] . ' ' . $owner['last_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-4 pl-0">
            <label for="floor">Этаж</label>
            <select id="floor" class="form-control" name="floor">
                <option value="-1" selected>Выберете этаж...</option>
                <?php foreach ($floor_data as $key => $floor): ?>
                    <option value="<?= $key ?>"><?= $key ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-4 pl-0">
            <label for="sector">Сектор</label>
            <select id="sector" class="form-control" name="sector">
                <option value="-1" selected>Выберете сектор...</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Добавить</button>
    </form>
<?php endif; ?>

<script>
    var floorSelect = document.getElementById('floor')
    var sectorSelect = document.getElementById('sector')

    var floors = <?php echo json_encode($floor_data) ?>;

    floorSelect.addEventListener('change', function () {
        for (var i = 0; i < floors[floorSelect.value]; i++) {
            var option = document.createElement('option')
            option.value = (i + 1).toString()
            option.text = (i + 1).toString()

            sectorSelect.appendChild(option)
        }
    })

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
