<!-- custom-window.html -->
<?php


include_once("./inc/head.php"); ?>
<title>Rendez-vous | Kinesiologue Paris | Stéphanie Mousset</title>
<link rel="stylesheet" href="./assets/css/index_style.css" />
<style>
    header {
        height: 100px;
    }

    iframe {
        width: 100%;
        height: 100vh;
        border: none !important;
        margin: auto;
        background-color: #74a9af;
    }
</style>
</head>

<body>
    <?php
    include_once("./inc/header.php"); ?>

    <main id="main" role="main">
        <section id="intro" itemscope itemtype="https://schema.org/Procedure">
            <div class="corps glassEffect">
                <div class="fontColor">
                    <iframe id="contentFrame" src=""></iframe>
                </div>
            </div>
        </section>
    </main>

    <?php
    include_once("./inc/footer.php"); ?>