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
                <input name="mode" placeholder="Choose one" list="modes" autocomplete="off" required/>
                <datalist id="modes">
                    <option value="osu!">
                    <option value="osu!taiko">
                    <option value="osu!catch">
                    <option value="osu!mania">
                </datalist>
            </div>

            <div class="question question--grouped">
                <span class="question__title">Discord tag:</span>
                <input name="discord" placeholder="username#0000" pattern=".+#\d{4}" autocomplete="off" required/>
            </div>

            <?php for ($i = 0; $i < count($questions); $i++): ?>
                <div class="question">
                    <span class="question__title">
                        <?= $questions[$i][0] ?>
                        <?php if (!$questions[$i][2]): ?>
                            <span class="question-optional">(optional)</span>
                        <?php endif; ?>
                    </span>
                    <div class="textarea-wrapper">
                        <textarea
                            name="q<?= $i ?>"
                            placeholder="Write your response here"
                            maxlength="<?= $questions[$i][1] ?>"
                            oninput="updateCounter(this.name, this.value.length)"
                            <?= $questions[$i][2] ? 'required' : '' ?>
                            style="height: <?= min($questions[$i][1] / 50, 20) ?>em;"
                        ></textarea>
                        <div class="counter">
                            <span id="q<?= $i ?>-counter">0</span> / <?= $questions[$i][1] ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>

            <input type="submit" class="button" value="Verify osu! account and send application"/>
        </form>
    </div>
</body>
</html>
