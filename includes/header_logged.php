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
    <style>html, body {height: 100%;margin: 0;padding: 0;}#map {height: 100%;width: 78%;margin-left: 22%;border: 1px solid #ddd;}</style>
</head>
<body>
    <div id="wrapper">
        <header>
            <!-- <h1><a href="profile.php">Perfil</a></h1> -->
            <h1><a href="logout.php">Logout</a></h1>
            <h1><a href="events.php">Meus eventos</a></h1>
            <!-- <h1><a href="#about">Sobre</a></h1>-->
            <h1><a href="index.php">Início</a></h1>
            <!--<h1><a href="#" target="_blank">Meus eventos</a></h1>-->
            <div id="actions">
                <ul class="normalRes">
                    <li class=&quot;active&quot;>
                        <a data-trigger-type="result" href="index.php">GeoLocaliza</a>
                    </li>

                    <!--Filter -- begin-->
                    <div class="filter">
                        <div class="wrapper" style="margin: 20px; align: center;position: absolute;border: 1px; height: 100%; width: 30%">
                            <br><br><br><br>
                            <?php echo $messageMap ?>
                            
                            <br><br>
                            <label>Busca eventos por tema:</label><br>
                            <input id="theme_filter" type="text">
                            <button onClick="showEventsTheme()" type="submit">Buscar</button>

                            <br><br><br>
                            <label>Buscar eventos no raio:</label><br>
                            <select id="radius_filter">
                                <option value=1>1km</option>
                                <option value=2>2km</option>
                                <option value=10>10km</option>
                                <option value=50>50km</option>
                            </select>
                            <button onClick="showEventsRadius()">Buscar</button>

                            <br><br><br>
                            <label>Buscar eventos por data:</label><br>
                            <input id="date_filter" type="date">
                            <button onClick="showEventsDate()" type="submit">Buscar</button>    
                        </div>
                    </div>
                    <!--Filter -- begin-->
                </ul>
                <div class="hl"></div>
            </div>
        </header>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
