<!DOCTYPE html>
<html>
<head>
    <title>osu! Spotlights Team Application</title>
    <link rel="icon" type="image/png" href="https://s.ppy.sh/favicon-32x32.png" />
    <link rel="stylesheet" type="text/css" href="/style.css" />
    <script>
        function updateCounter(name, length) {
            document.getElementById(name + "-counter").innerHTML = length;
        }
    </script>
</head>
<body>
    <div id="content">
        <h1>osu! Spotlights Team Application</h1>

        <form method="post" action="/submit">
            <div class="question">
                <span class="question__title">Game mode:</span>
                <input name="mode" placeholder="Choose one" list="modes" required/>
                <datalist id="modes">
                    <option value="osu!">
                    <option value="osu!taiko">
                    <option value="osu!catch">
                    <option value="osu!mania">
                </datalist>
            </div>

            <div class="question question--grouped">
                <span class="question__title">Discord tag:</span>
                <input name="discord" placeholder="username#0000" pattern=".+#\d{4}" required/>
            </div>

            <?php for ($i = 0; $i < count($questions); $i++): ?>
                <div class="question">
                    <span class="question__title"><?= $questions[$i] ?></span>
                    <div class="textarea-wrapper">
                        <textarea name="q<?= $i ?>" placeholder="Write your response here" maxlength="1250" oninput="updateCounter(this.name, this.value.length)" required></textarea>
                        <div class="counter"><span id="q<?= $i ?>-counter">0</span> / 1250</div>
                    </div>
                </div>
            <?php endfor; ?>

            <input type="submit" class="button" value="Verify osu! account and send application"/>
        </form>
    </div>
</body>
</html>
