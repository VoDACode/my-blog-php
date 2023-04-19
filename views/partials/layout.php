<?

use core\View;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title><? echo $title ?></title>
    <? echo $styles ?>

    <? echo $preload_scripts ?>
</head>

<body>

    <? View::renderPartial('partials.header') ?>

    <div class="container">
        <? include $render; ?>
    </div>

    <? View::renderPartial('partials.footer') ?>

    <? echo $after_load_scripts ?>
</body>

</html>