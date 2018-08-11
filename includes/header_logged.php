<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="edit-Type" edit="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bem-vindo <?php echo $user['name'] ?></title>

    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/form.css"> -->
    <link rel="stylesheet" media="screen" href="http://jsfiddle.net/css/embed/embed-light.css" />
    <link rel="stylesheet" media="screen" href="//fonts.googleapis.com/css?family=Inconsolata" />
    <style>html, body {height: 100%;margin: 0;padding: 0;}#map {height: 100%;width: 70%;margin-left: 30%;border: 1px solid #ddd;}</style>
</head>
<body>
    <div id="wrapper">
        <header>
            <h1><a href="#">Perfil</a></h1>
            <h1><a href="logout.php">Logout</a></h1>
            <h1><a href="events.php">Meus eventos</a></h1>
            <h1><a href="#about">Sobre</a></h1>
            <h1><a href="index.php">Início</a></h1>
            <!--<h1><a href="#" target="_blank">Meus eventos</a></h1>-->
            <div id="actions">
                <ul class="normalRes">
                    <li class=&quot;active&quot;>
                        <a data-trigger-type="result" href="index.php">GeoLocaliza</a>
                    </li>
                </ul>
                <div class="hl"></div>
            </div>
        </header>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
