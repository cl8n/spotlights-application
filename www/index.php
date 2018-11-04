<?php

require_once __DIR__ . '/../constants.php';

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

        <?php foreach (FIELDS_QUESTIONS as $field => $question): ?>
            <?= $question ?>
            <br/>
            <textarea name="<?= $field ?>" cols="50" rows="10" required></textarea>
            <br/>
        <?php endforeach; ?>

        <input type="submit" value="Verify osu! account and send application"/>
    </form>
</body>
</html>
