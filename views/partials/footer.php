<!--
<footer class="foot-content">
    <div class="logs_txt_display">
        <?=
        $lines = file($_ENV['ROOT_PATH'] . 'info' . DIRECTORY_SEPARATOR . 'logs.txt', FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line) {
            //echo $line . '<br>';
        }
        ?>
    </div>
    <div class="visits_txt_display">
        <?=
        $lines = file($_ENV['ROOT_PATH'] . 'info' . DIRECTORY_SEPARATOR . 'visits.txt', FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line) {
            //echo $line . '<br>';
        }
        ?>
    </div>
</footer>
-->