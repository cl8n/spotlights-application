<?php

require_once __DIR__ . '/../include.php';

?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <form method="post" action="/application.php">
        Game mode: <input name="mode" list="modes" required/>
        <datalist id="modes">
            <option value="osu!">
            <option value="osu!taiko">
            <option value="osu!catch">
            <option value="osu!mania">
        </datalist>
        <br/>
        Discord tag: <input name="discord" pattern=".+#\d{4}" required/>
        <br/>

        <?php for ($i = 0; $i < sizeof($config['application']); $i++): ?>
            <?= $config['application'][$i] ?>
            <br/>
            <textarea name="q<?= $i ?>" cols="50" rows="10" required></textarea>
            <br/>
        <?php endfor; ?>

        <input type="submit" value="Verify osu! account and send application"/>
    </form>
</body>
</html>
