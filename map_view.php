    <div id="map"></div>

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?language=en&libraries=geometry,places&key=AIzaSyA-AB-9XZd-iQby-bNLYPFyb0pR2Qw3orw"></script>
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

        var gmarkers = [];

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

        var i ; var confirmed = 0;
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon :   locations[i][7] === '1' ?  red_icon  : purple_icon,
                html:  "<div>\n" +
                "       <table class=\"map1\">\n" +
                "           <tr>\n" +
                "               <td><label>Título:</label></td>\n" +
                "               <td><input disabled type='text' id='manual_title' placeholder='" + locations[i][3] +"'></td></tr>\n" +
                "               <td><label>Tema:</label></td>\n" +
                "               <td><input disabled type='text' id='manual_theme' placeholder='" + locations[i][4] +"'></td></tr>\n" +
                "               <td><label>Data início:</label></td>\n" +
                "               <td><input disabled type='text' id='manual_date_begin' placeholder='" + formatDate(locations[i][5], 'pt-br') +"'></td></tr>\n" +
                "               <td><label>Data fim:</label></td>\n" +
                "               <td><input disabled type='text' id='manual_date_end' placeholder='" + formatDate(locations[i][6], 'pt-br') +"'></td></tr>\n" +
                "               <td><label>ID:</label></td>\n" +
                "               <td><input disabled class='id-marker' type='text' id='id' placeholder='#000" + locations[i][0] +"'></td></tr>\n" +
                "        </table>\n" +
                "    </div>"
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow = new google.maps.InfoWindow();
                    confirmed =  locations[i][7] === '1' ?  'checked'  :  0;
                    $("#confirmed").prop(confirmed,locations[i][7]);
                    $("#id").val(locations[i][0]);
                    $("#title").val(locations[i][3]);
                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            gmarkers.push(marker);
        }
            var address = "";

            function saveData(lat,lng) {
                var userId = <?php echo $user['id'] ?>;
                var title = document.getElementById('manual_title').value;
                var theme = document.getElementById('manual_theme').value;
                var date_begin = document.getElementById('manual_date_begin').value;
                var date_end = document.getElementById('manual_date_end').value;

                
                var url = 'locations_model.php?add_location&title=' + title + '&theme=' + theme+ '&date_begin=' + date_begin + '&date_end=' + date_end + '&lat=' + lat + '&lng=' + lng + '&userId=' + userId;

                downloadUrl(url, function(data, responseCode) {
                    if (responseCode === 200  && data.length > 1) {
                        var markerId = getMarkerUniqueId(lat,lng); // get marker id by using clicked point's coordinate
                        var manual_marker = markers[markerId]; // find marker
                        manual_marker.setIcon(purple_icon);
                        infowindow.close();
                        infowindow.setContent("<div style=' color: purple; font-size: 25px;'> Insert with success!!</div>");
                        infowindow.open(map, manual_marker);
                        window.open("index.php","_self");

                    }else{
                        console.log(responseCode);
                        console.log(data);
                        infowindow.setContent("<div style='color: red; font-size: 25px;'>Inserting Errors</div>");
                    }
                });
            }

            function formatDate(data, formato) {
                if (formato == 'pt-br') {
                    return (data.substr(0, 10).split('-').reverse().join('/'));
                } else {
                    return (data.substr(0, 10).split('/').reverse().join('-'));
                }
            }
            
            function GetAddress(lat, lng) {
                var latlng = new google.maps.LatLng(lat, lng);
                var geocoder = geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            address = results[0].formatted_address;
                        }
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
        
        //    FILTROS DE BUSCA - INICIO
        //Busca por nome do tema
        function showEventsTheme(){
            for (var i = gmarkers.length - 1; i >= 0; i--) {
                gmarkers[i].setMap(null);
            }
            var i ; var confirmed = 0;
            for (i = 0; i < locations.length; i++) {
                if (locations[i][4] === document.getElementById('theme_filter').value) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        icon : green_icon,
                        visible: true,
                        html:  "<div>\n" +
                        "       <table class=\"map1\">\n" +
                        "           <tr>\n" +
                        "               <td><label>Título:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_title' placeholder='" + locations[i][3] +"'></td></tr>\n" +
                        "               <td><label>Tema:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_theme' placeholder='" + locations[i][4] +"'></td></tr>\n" +
                        "               <td><label>Data início:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_date_begin' placeholder='" + formatDate(locations[i][5], 'pt-br') +"'></td></tr>\n" +
                        "               <td><label>Data fim:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_date_end' placeholder='" + formatDate(locations[i][6], 'pt-br') +"'></td></tr>\n" +
                        "               <td><label>ID:</label></td>\n" +
                        "               <td><input disabled class='id-marker' type='text' id='id' placeholder='#000" + locations[i][0] +"'></td></tr>\n" +
                        "        </table>\n" +
                        "    </div>",
                    });

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow = new google.maps.InfoWindow();
                            confirmed =  locations[i][7] === '1' ?  'checked'  :  0;
                            $("#confirmed").prop(confirmed,locations[i][7]);
                            $("#id").val(locations[i][0]);
                            $("#title").val(locations[i][3]);
                            $("#form").show();
                            infowindow.setContent(marker.html);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                    gmarkers.push(marker);
                }
            }
        }

        function showEventsRadius(){
            for (var i = gmarkers.length - 1; i >= 0; i--) {
                gmarkers[i].setMap(null);
            }
                
            navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };


            var radius_km = Number(document.getElementById('radius_filter').value) * 1000;
    
            var posicao = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
                var ciculo = new google.maps.Circle({
                map: map,
                center:  pos,
                radius: radius_km,
                strokeColor: "#818c99",
                fillColor:"#ffffff",
                fillOpacity: 0.35,
            });

            for (var i = locations.length - 1; i >= 0; i--) {
                var marker_lat_lng = new google.maps.LatLng(locations[i][1],locations[i][2]);
                var distance_from_location = google.maps.geometry.spherical.computeDistanceBetween(marker_lat_lng, posicao);

                if (google.maps.geometry.spherical.computeDistanceBetween(marker_lat_lng, posicao) <= radius_km){
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        draggable: true,
                        icon : green_icon,
                        visible: true,
                        html:  "<div>\n" +
                        "       <table class=\"map1\">\n" +
                        "           <tr>\n" +
                        "               <td><label>Título:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_title' placeholder='" + locations[i][3] +"'></td></tr>\n" +
                        "               <td><label>Tema:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_theme' placeholder='" + locations[i][4] +"'></td></tr>\n" +
                        "               <td><label>Data início:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_date_begin' placeholder='" + formatDate(locations[i][5], 'pt-br') +"'></td></tr>\n" +
                        "               <td><label>Data fim:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_date_end' placeholder='" + formatDate(locations[i][6], 'pt-br') +"'></td></tr>\n" +
                        "               <td><label>ID:</label></td>\n" +
                        "               <td><input disabled class='id-marker' type='text' id='id' placeholder='#000" + locations[i][0] +"'></td></tr>\n" +
                        "        </table>\n" +
                        "    </div>",
                    });

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow = new google.maps.InfoWindow();
                            confirmed =  locations[i][7] === '1' ?  'checked'  :  0;
                            $("#confirmed").prop(confirmed,locations[i][7]);
                            $("#id").val(locations[i][0]);
                            $("#title").val(locations[i][3]);
                            $("#form").show();
                            infowindow.setContent(marker.html);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                    gmarkers.push(marker); 
                }
            }
        });

        }

        function showEventsDate(){
            for (var i = gmarkers.length - 1; i >= 0; i--) {
                gmarkers[i].setMap(null);
            }

            var i ; var confirmed = 0;
            for (i = 0; i < locations.length; i++) {
                var from = Date.parse(locations[i][5]);
                var to = Date.parse(locations[i][6]);
                var check = Date.parse(document.getElementById('date_filter').value);

                if((check <= to && check >= from)){
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        draggable: true,
                        icon : green_icon,
                        visible: true,
                        html:  "<div>\n" +
                        "       <table class=\"map1\">\n" +
                        "           <tr>\n" +
                        "               <td><label>Título:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_title' placeholder='" + locations[i][3] +"'></td></tr>\n" +
                        "               <td><label>Tema:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_theme' placeholder='" + locations[i][4] +"'></td></tr>\n" +
                        "               <td><label>Data início:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_date_begin' placeholder='" + formatDate(locations[i][5], 'pt-br') +"'></td></tr>\n" +
                        "               <td><label>Data fim:</label></td>\n" +
                        "               <td><input disabled type='text' id='manual_date_end' placeholder='" + formatDate(locations[i][6], 'pt-br') +"'></td></tr>\n" +
                        "               <td><label>ID:</label></td>\n" +
                        "               <td><input disabled class='id-marker' type='text' id='id' placeholder='#000" + locations[i][0] +"'></td></tr>\n" +
                        "        </table>\n" +
                        "    </div>",
                    });

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow = new google.maps.InfoWindow();
                            confirmed =  locations[i][7] === '1' ?  'checked'  :  0;
                            $("#confirmed").prop(confirmed,locations[i][7]);
                            $("#id").val(locations[i][0]);
                            $("#title").val(locations[i][3]);
                            $("#form").show();
                            infowindow.setContent(marker.html);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                    gmarkers.push(marker);
                }
            }
        }

        // FILTROS DE BUSCA - FIM
    </script>


