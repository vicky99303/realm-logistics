var map;
var bounds;
var gmarkers = [];
var gm = [];
var firstData = true;
var refreshIntervalId;
var infoWindow;
var au = document.getElementById("myAudio");
var path_coords = [];
var lineCoordinatesPath;
/*------------------------------Initialise google map----------------*/

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 24.4208, lng: 54.6556 },
        zoom: 15,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_CENTER
        },
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_CENTER
        },
        scaleControl: true,
        streetViewControl: true,
        streetViewControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP
        },
    });
    bounds = new google.maps.LatLngBounds();
}

/*--------------------------Update map for multiple vehicles----------------*/

update_map = function(data) {
    var mydata = JSON.parse(data);
    console.log(mydata);
    for (var i = 0; i < mydata.data.length; i++) {
        var lati = mydata.data[i].latitude;
        var longi = (mydata.data[i].longitude);
        var imei = mydata.data[i].imei;
        var dt = mydata.data[i];
        var ic = mydata.data[i].status;
        var sp = (ic == 1) ? mydata.data[i].speed : 0;
        var alarm = mydata.data[i].alarm_id;
        if (alarm != 0 || sp > 120) {
            trigger_alarm(alarm, lati, longi, imei);
        } else {
            if (!au.paused) {
                au.pause();
            }
        }
        if (ic == 1) {
            ic_name = "green";
            st = "Online";
        } else if (ic == 2) {
            ic_name = "yellow";
            st = "Static";
        } else if (ic == 0) {
            ic_name = "red";
            st = "Offline";
        }
        var contentString = '<div id="content">' +
            '<p><b>IMEI :</b> ' + imei + '</p>' +
            '<p><b>Latitude :</b> ' + lati + '</p>' +
            '<p><b>Longitude :</b> ' + longi + '</p>' +
            '<p><b>Speed :</b> ' + sp + 'kmph</p>' +
            '<p><b>DateTime :</b> ' + mydata.data[i].e_date + '</p>' +
            '<p><b>Status :</b> ' + st + '</p>' +
            '<p><a href="http://104.131.94.246/tracker/single_track.php?imei=' + imei + '" class="btn btn-primary btn-xs">Track</a></p>' +
            '</div>';

        console.log(lati + " " + longi);
        var latLng = new google.maps.LatLng(lati, longi);
        var id = i;
        if (gm[id] && gm[id].setPosition) {
            gm[id].setPosition(latLng);
            bounds.extend(latLng);
            map.setZoom(12);
            gm[id].setIcon('img/car_ic_' + ic_name + '.png');
            gm[id].info.setContent(contentString);

        } else {
            bounds.extend(latLng);
            map.fitBounds(bounds);
            var marker = create_marker(latLng, contentString, imei);
            gm[id] = marker;
        }

    }
    if (firstData) {
        map.setCenter(latLng);
        map.setZoom(12);
        firstData = false;
    }

};

/*------------------------------Tracking for single vehicle----------------*/

function start_track(imei) {
    removeMarkers();

    function getMarkers() {
        $.ajax({
            type: "POST",
            data: "imei=" + imei,
            url: "utilities/tracking.php",
            success: function(data) {
                update_map_single(data);
            }

        });
    }
    refreshIntervalId = setInterval(getMarkers, 10000);
}

/*--------------------------Update map for single vehicle----------------*/

update_map_single = function(data) {
    var mydata = JSON.parse(data);
    for (var i = 0; i < mydata.data.length; i++) {
        var lati = mydata.data[i].latitude;
        var longi = (mydata.data[i].longitude);
        var imei = mydata.data[i].imei;
        var ic = mydata.data[i].status;
        var sp = (ic == 1) ? mydata.data[i].speed : 0;
        path_coords.push(new google.maps.LatLng(lati, longi));
        if (ic == 1) {
            ic_name = "green";
            st = "Online";
        } else if (ic == 2) {
            ic_name = "yellow";
            st = "Start";
        } else if (ic == 0) {
            ic_name = "red";
            st = "Offline";
        }
        // console.log(lati + " " + longi);
        var contentString = '<div id="content">' +
            // '<p><b>IMEI :</b> ' + imei + '</p>' +
            '<p><b>Latitude :</b> ' + lati + '</p>' +
            '<p><b>Longitude :</b> ' + longi + '</p>' +
            // '<p><b>Speed :</b> ' + sp + 'kmph</p>' +
            // '<p><b>DateTime :</b> ' + mydata.data[i].e_date + '</p>' +
            '<p><b>Status :</b> ' + st + '</p>' +
            '</div>';
        var latLng = new google.maps.LatLng(lati, longi);
        var id = i;
        if (gm[id] && gm[id].setPosition) {
            gm[id].setPosition(latLng);
            bounds.extend(latLng);
            map.setCenter(latLng);
            gm[id].setIcon('img/car_ic_' + ic_name + '.png');
            gm[id].info.setContent(contentString);
            //gm[id].rotate(google.maps.geometry.spherical.computeHeading(lt = (path_coords[path_coords.length - 1]), marker.getPosition()));
            //rotation: google.maps.geometry.spherical.computeHeading(prevPosn, marker.getPosition())
            lineCoordinatesPath = new google.maps.Polyline({
                path: path_coords,
                geodesic: true,
                strokeColor: '#2E10FF'
            });

            lineCoordinatesPath.setMap(map);

        } else {
            bounds.extend(latLng);
            var marker = create_marker(latLng, contentString, imei);
            gm[id] = marker;
        }

    }
    if (firstData) {
        map.setCenter(latLng);
        map.setZoom(15);
        firstData = false;
    }

};


/*----------------------------Create Marker----------------*/


function create_marker(latLng, contentString, imei) {
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: imei,
        //icon: 'car_icon.png'
        icon: 'img/car_ic_' + ic_name + '.png',
    });
    marker.imei = imei;
    marker.info = new google.maps.InfoWindow({
        content: contentString
    });
    google.maps.event.addListener(marker, 'click', function() {
        marker.info.open(map, marker);
    });
    return marker;
}


/*-----------------------------Clear Interval----------------*/

$(document).ready(function() {
    $('#stop_track').click(function() {
        clearInterval(refreshIntervalId);
    });
});

/*-----------------------------Clear map----------------*/

function removeMarkers() {
    for (i = 0; i < gmarkers.length; i++) {
        gmarkers[i].setMap(null);
    }
}

/*--------------------Trigger alarm--------------*/

function trigger_alarm(al_id, la, lo, imei) {
    if (au.paused) {
        au.play();
    }
    console.log(al_id + ',' + la + ',' + lo + ',' + imei);
}
