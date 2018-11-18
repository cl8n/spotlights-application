<?php

require_once __DIR__ . '/../include.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Spotlights Team Application Form</title>
        <link rel="icon" type="image/png" href="https://s.ppy.sh/favicon-32x32.png" />
    </head>
    <body>
        <style>

            body {
                background-image: url(https://osu.ppy.sh/images/backgrounds/page-dark.png);
                background-color: grey;
                background-repeat: repeat;                    
            }
                        
            #content{
                text-overflow: clip;
                position: relative;
                margin: auto;
                text-align: center;
                background-color: #fff;
                max-width: 550px;
                min-height: 1100px;
                align-content: center;
                border-radius: 16px;
                color: #262626;
            }
            
            #textarea {
                resize: vertical;
                padding: 10px 20px;
                overflow: hidden;
                line-height: 1.25;
                color: #262626;
                outline: none;
                border: none;
                margin: 0px;
                word-wrap: break-word;
                background: transparent none repeat scroll 0% 0% !important;
                transition: none 0s ease 0s;
                font-size: 13px;
            }
                        
            .button {
                text-align: center;
                text-shadow: 0 1px 3px rgba(0,0,0,.75);
                color: #fff;
                vertical-align: middle;
                background-image: url("https://osu.ppy.sh/images/backgrounds/button.svg");
                background-color: #4ad;
                background-size: 200px;
                background-position: 50% 50%
                min-width: 300px;
                padding: 15px 25px;
                margin-left: 5px;
                margin-bottom: 10px;
                font-size: 15px;
                box-shadow: 0 10px #29b,0 7px 10px rgba(0,0,0,.8);
                border-radius: 4px;
                border: none;
                position: relative;
            }
            
            .button:hover {
                background-color: #2aa;
                box-shadow: 0 10px #2aa,0 7px 10px rgba(34, 170, 170, 1);
            }
            
            .button:active {
                background-color: #2aa;
                box-shadow: 0 10px #2aa,0 7px 10px rgba(34, 170, 170, 1);
                transform: translateY(2px);
            }
            
            #mode {
                width: 150px;
            }
            
            #discord {
                width: 150px;
                margin-left: 4px;
            }
            
        </style>


        <div id="content">
            <br/>
            <form method="post" action="/application.php">
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

                <?php for ($i = 0; $i < sizeof($config['application']); $i++): ?>
                    <?= $config['application'][$i] ?>
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
