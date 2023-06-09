<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title><?= $title ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?= $styles ?>
</head>

<body>
    <form class="file-panel" method="post" action="/api/photo-gallery/add" enctype="multipart/form-data">
        <input type="file" name="file[]" id="file" multiple accept="image/*" />
        <input type="submit" value="Upload" />
    </form>

    <div class="collection">
        <? if (isset($images)) : ?>
            <? foreach ($images as $image) { ?>
                <div class="collection-item">
                    <form class="photo-form" action="/api/photo-gallery/delete" method="post">
                        <div class="photo-container">
                            <img class="photo" src="/api/photo-gallery/file?id=<?= $image['id'] ?>" alt="<?= $image['name'] ?>">
                        </div>
                        <input type="hidden" name="id" value="<?= $image['id'] ?>">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                    <p class="photo-name"><?= $image['name'] ?></p>
                </div>
            <? } ?>
        <? else : ?>
            Empty list
        <? endif; ?>
    </div>
</body>

</html>