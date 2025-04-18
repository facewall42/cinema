<!-- custom-window.html -->
<?php
require_once __DIR__ . '/includes/config.php';

include_once("./templates/head.php"); ?>
<title>Rendez-vous | Kinesiologue Paris | Stéphanie Mousset</title>
<link rel="canonical" href="https://kinesiologue-paris-vincennes.fr" />
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
    include_once("./templates/header.php"); ?>

    <main id="main" role="main">
        <section id="intro" itemscope itemtype="https://schema.org/Procedure">
            <div class="corps glassEffect">
                <div class="fontColor">
                    <iframe id="contentFrame" src="about:blank"></iframe>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const iframe = document.getElementById('contentFrame');
            iframe.src = 'https://meet.brevo.com/stephanie-mousset';
        });
    </script>

    <?php
    include_once("./templates/footer.php"); ?>