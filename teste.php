<!DOCTYPE html>
<html>
    <head>
        <title>Place searches</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <style>
            
            #map {
                height: 85%;
                margin-left: 50px;
                border: 1px solid #ddd;
            }
            
            html, body {
                margin-left: 10px;
                margin-top:-10px;
                /* height: 100%;
                padding: 0; */
                background: #f4f4f4;
                color: #5a5656;
                font: 100%/1.5em 'Open Sans', sans-serif;
            }

            .map {
                position: absolute;
                width: 700px;
                height: 100px;
            }

            .criareventos{
                position: relative;
                margin-left: 800px;
            }
            
            input[type="submit"] {
                background-color: #0095C7;
                border: none;
                border-radius: 3px;
                color: #f4f4f4;
                cursor: pointer;
                font-family: inherit;
                height: 50px;
                text-transform: uppercase;
                width: 300px;
                -webkit-appearance:none;
            }
        </style>
        <script>
        var map;
        var infowindow;

        function initMap() {
            var pyrmont = {lat: -6.888761, lng: -38.559558};

            map = new google.maps.Map(document.getElementById('map'), {
            center: pyrmont,
            zoom: 15
            });

            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            service.nearbySearch({
            location: pyrmont,
            radius: 500,
            type: ['store']
            }, callback);
        }

        function callback(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
                createMarker(results[i]);
            }
            }
        }

        function createMarker(place) {
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location
            });

            google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(place.name);
            infowindow.open(map, this);
            });
        }
        </script>
        </head>
    <body>
        <h1><p class="p">Eventos próximos a mim</p></h1><br>
        <div class="map" id="map"></div>
        <form action="#">
            <p><input class="criareventos" type="submit" value="Criar eventos"></p>   <br> 
            <p><input class="criareventos" type="submit" value="Buscar Eventos"></p>    
        </form>
    
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCR5PFyvraK8Cqbu-vQu7UAR-NkcABHNuw&libraries=places&callback=initMap" async defer></script>
    </body>
</html>