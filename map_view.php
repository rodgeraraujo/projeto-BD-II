    <div id="map"></div>

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyA-AB-9XZd-iQby-bNLYPFyb0pR2Qw3orw"></script>
    <script>
        var infowindow;
        var map;
        var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
        var green_icon =  'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
        var locations = <?php get_confirmed_locations() ?>;

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -14.9047496, lng: -41.4151437},
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

        var markers = {};


        var getMarkerUniqueId= function(lat, lng) {
            return lat + '_' + lng;
        };


        var getLatLng = function(lat, lng) {
            return new google.maps.LatLng(lat, lng);
        };

        var addMarker = google.maps.event.addListener(map, 'click', function(e) {
            var lat = e.latLng.lat(); // lat of clicked point
            var lng = e.latLng.lng(); // lng of clicked point

            var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object.
            var marker = new google.maps.Marker({
                position: getLatLng(lat, lng),
                map: map,
                animation: google.maps.Animation.DROP,
                id: 'marker_' + markerId,
                html: "<div id='info_"+markerId+"'>\n" +
                "       <table class=\"map1\">\n" +
                "           <tr>\n" +
                "               <td><label>Título:</label></td>\n" +
                "               <td><input type='text' id='manual_title' placeholder='Título'></td></tr>\n" +
                "               <td><label>Tema:</label></td>\n" +
                "               <td><input type='text' id='manual_theme' placeholder='Tema'></td></tr>\n" +
                "               <td><label>Data início:</label></td>\n" +
                "               <td><input type='date' id='manual_date_begin' placeholder='Data início'></td></tr>\n" +
                "               <td><label>Data fim:</label></td>\n" +
                "               <td><input type='date' id='manual_date_end' placeholder='Data fim'></td></tr>\n" +
                "            <tr><td></td><td><input type='button' value='Salvar' onclick='saveData("+lat+","+lng+")'/></td></tr>\n" +
                "        </table>\n" +
                "    </div>"
            });
            markers[markerId] = marker; // cache marker in markers object
            bindMarkerEvents(marker); // bind right click event to marker
            bindMarkerinfo(marker); // bind infowindow with click event to marker
        });


        var bindMarkerinfo = function(marker) {
            google.maps.event.addListener(marker, "click", function (point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                infowindow = new google.maps.InfoWindow();
                infowindow.setContent(marker.html);
                infowindow.open(map, marker);
                // removeMarker(marker, markerId); // remove it
            });
        };


        var bindMarkerEvents = function(marker) {
            google.maps.event.addListener(marker, "rightclick", function (point) {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                removeMarker(marker, markerId); // remove it
            });
        };



        var removeMarker = function(marker, markerId) {
            marker.setMap(null); // set markers setMap to null to remove it from map
            delete markers[markerId]; // delete marker instance from markers object
        };

         // Code for function to print on map and save on database here
         
    </script>


