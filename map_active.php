
<?php
    $title = "Admin map";
    include_once 'includes/header_logged.php';
    include_once 'locations_model.php';
?>

<script>
    var map;
    var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
    var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
    var marker;
    var infowindow;

    var locations = <?php get_all_locations() ?>;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 18
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                infoWindow.setPosition(pos);
                infoWindow.setContent('You location.');
                infoWindow.open(map);
                map.setCenter(pos);
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }


        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }
            
            var location = {lat: -6.8907043, lng: -38.5753674};
            infowindow = new google.maps.InfoWindow();
            map = new google.maps.Map(document.getElementById('map'), {
                center: location,
                zoom:18
            });


        var i ; var confirmed = 0;
        for (i = 0; i < locations.length; i++) {
            if (locations[i][8] === '<?php echo $user['id'] ?>') {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon :   locations[i][7] === '1' ?  red_icon  : purple_icon,
                    html: document.getElementById('form')
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        confirmed =  locations[i][7] === '1' ?  'checked'  :  0;
                        $("#confirmed").prop(confirmed,locations[i][7]);
                        $("#id").val(locations[i][0]);
                        $("#title").val(locations[i][3]);
                        $("#theme").val(locations[i][4]);
                        $("#date_begin").val(locations[i][5]);
                        $("#date_end").val(locations[i][6]);
                        $("#form").show();
                        infowindow.setContent(marker.html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        }
    }


    function saveData() {
        var confirmed = document.getElementById('confirmed').checked ? 1 : 0;
        var id = document.getElementById('id').value;
        var url = 'locations_model.php?confirm_location&id=' + id + '&confirmed=' + confirmed ;
        downloadUrl(url, function(data, responseCode) {
            if (responseCode === 200  && data.length > 1) {
                infowindow.close();
                window.location.reload(true);
            }else{
                infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
            }
        });
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                callback(request.responseText, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }
</script>

<div id="map"></div>

<div style="display: none" id="form">
    <table class=\"map1\">
        <input name="id" disabled type='hidden' id='id'/>
           <tr>
               <br>
               <td><label>Título:</label></td>
               <td><input disabled type='text' id='title' placeholder='Título'></td></tr>
               <td><label>Tema:</label></td>
               <td><input disabled type='text' id='theme' placeholder='Tema'></td></tr>
               <td><label>Data início:</label></td>
               <td><input disabled type='text' id='date_begin' placeholder='Data início'></td></tr>
               <td><label>Data fim:</label></td>
               <td><input disabled type='text' id='date_end' placeholder='Data fim'></td></tr>
        </table>
        <tr>
            <td>
                <br><b>Evento ativo?: </b>
                <input id='confirmed' type='checkbox' name='confirmed'><br><br>               
            </td>
        </tr>

        <tr><td><input type='button' value='Salvar' onclick='saveData()'/></td></tr>
    </table>
</div>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyA-AB-9XZd-iQby-bNLYPFyb0pR2Qw3orw&callback=initMap">
</script>