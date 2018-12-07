<!DOCTYPE html>
<html>
    <head>
        <title>Spotlights Team Application Form</title>
        <link rel="icon" type="image/png" href="https://s.ppy.sh/favicon-32x32.png" />
        <link rel="stylesheet" type="text/css" href="/style.css" />
    </head>
    <body>
        <div id="content">
            <br/>
            <form method="post" action="/submit">
                Game mode: <input name="mode" id="mode" placeholder="Choose one" list="modes" required/>
                    <datalist id="modes">
                        <option value="osu!">
                        <option value="osu!taiko">
                        <option value="osu!catch">
                        <option value="osu!mania">
                    </datalist>
                <br/>
                <br/>
                    Discord tag: <input name="discord" id="discord" placeholder="placeholder#0000" pattern=".+#\d{4}" required/>
                <br/>
                <br/>

                <?php for ($i = 0; $i < count($questions); $i++): ?>
                    <?= $questions[$i] ?>
                        <br/>
                        <br/>
                            <textarea name="q<?= $i ?>" id="textarea" placeholder="Enter text here..." cols="50" rows="10" maxlength="1250" required></textarea>
                        <br/>
                        <br/>
                    <?php endfor; ?>
                <div>
                    <input type="submit" class="button" value="Verify osu! account and send application"/>
                </div>
                <br/>
            </form>
        </div>
    </body>
</html>
