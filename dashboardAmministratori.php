<?php
echo "ciaoffsffbdfbfb";
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="styles/dashboard.css" rel="stylesheet" />
    <script src="script/divSelector.js"></script>
</head>

<body>
    <h1>Ciao</h1>
    <div class="itemsMargin" id="dashboardSidebar">
        <button onclick="showDiv(1)">Button 1</button>
        <button onclick="showDiv(2)">Button 2</button>
        <button onclick="showDiv(3)">Button 3</button>
    </div>

    <div class="itemsMargin" id="dashboardHeader">

    </div>



    <div class="itemsMargin" id="dashboardMainContent" style="height:inherit;">
        <div id="div1" class="content-div gridTemplate parentHeight gridCenter">
            <div class="item">
                <h1 style="color: blue;">dddd</h1>
            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
        </div>

        <div id="div2" class="content-div gridTemplate parentHeight gridCenter">
            <div class="item">
                <h1 style="color: blue;">gggg</h1>
            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
        </div>

        <div id="div3" class="content-div gridTemplate parentHeight gridCenter">
            <div class="item">
                <h1 style="color: blue;">vbvbbbbb</h1>
            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
            <div class="item">

            </div>
        </div>
    </div>
</body>

</html>