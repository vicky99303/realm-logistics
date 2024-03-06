<!DOCTYPE html>
<html>
<head>
    <title>Testing the samples</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <!-- Custom CSS -->
    <link href="<?php echo e(asset('adminpanel/')); ?>/dist/css/style.min.css" rel="stylesheet">
</head>
<body>
<section id="main-content">
    <div class="container-full fixed">
        <div class="side-bar">
            <br/><br/>
            <p><b>Tracker</b></p>
            <br/>
        </div>
        <div class="map-section">
            <div id="map" style="height: 500px">
            </div>
        </div>
    </div>
    <div id="footer">


    </div>
</section>
<script src="<?php echo e(asset('adminpanel/')); ?>/assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    var asset_path = "<?php echo e(asset('adminpanel')); ?>";
    $(function (){
        start_track();
    });
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
    function start_track(imei) {
        removeMarkers();

        function getMarkers() {
            var riderId = '<?php echo e($userid); ?>';
            var JourneyId = '<?php echo e($journeyId); ?>';
            $.ajax({
                type: "POST",
                data: {
                    "rider": riderId,
                    "journey": JourneyId
                },

                url: "<?php echo e(route('MapData')); ?>",
                success: function (data) {
                    update_map_single(data);
                }

            });
        }

        refreshIntervalId = setInterval(getMarkers, 10000);
    }


    update_map_single = function (data) {
        var mydata = JSON.parse(JSON.stringify(data));
        for (var i = 0; i < mydata.data.length; i++) {
            var lati = mydata.data[i].latitude;
            var longi = (mydata.data[i].longitude);
            // var imei = mydata.data[i].imei;
            var ic = mydata.data[i].status;
            // var sp = (ic == 1) ? mydata.data[i].speed : 0;
            path_coords.push(new google.maps.LatLng(lati, longi));
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
            // console.log(lati + " " + longi);
            var contentString = '<div id="content">' +
                // '<p><b>IMEI :</b> ' + imei + '</p>' +
                '<p><b>Latitude :</b> ' + lati + '</p>' +
                '<p><b>Longitude :</b> ' + longi + '</p>' +
                // '<p><b>Speed :</b> ' + sp + 'kmph</p>' +
                // '<p><b>DateTime :</b> ' + mydata.data[i].e_date + '</p>' +
                // '<p><b>Status :</b> ' + st + '</p>' +
                '</div>';
            var latLng = new google.maps.LatLng(lati, longi);
            var id = i;
            if (gm[id] && gm[id].setPosition) {
                gm[id].setPosition(latLng);
                bounds.extend(latLng);
                map.setCenter(latLng);
                gm[id].setIcon(asset_path+'/img/car_ic_' + ic_name + '.png');
                gm[id].info.setContent(contentString);
                // gm[id].rotate(google.maps.geometry.spherical.computeHeading(lt = (path_coords[path_coords.length - 1]), marker.getPosition()));
                // rotation: google.maps.geometry.spherical.computeHeading(prevPosn, marker.getPosition())
                lineCoordinatesPath = new google.maps.Polyline({
                    path: path_coords,
                    geodesic: true,
                    strokeColor: '#2E10FF'
                });

                lineCoordinatesPath.setMap(map);

            } else {
                bounds.extend(latLng);
                var marker = create_marker(latLng, contentString, 'imei');
                gm[id] = marker;
            }

        }
        if (firstData) {
            map.setCenter(latLng);
            map.setZoom(15);
            firstData = false;
        }

    };


    function create_marker(latLng, contentString, imei) {
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            title: imei,
            //icon: 'car_icon.png'
            icon: asset_path+'/img/car_ic_' + ic_name + '.png',
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

    function removeMarkers() {
        for (i = 0; i < gmarkers.length; i++) {
            gmarkers[i].setMap(null);
        }
    }

</script>

<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVNRflyd4NNob9I7F8LreLwyXt2qPwVyA&callback=initMap&libraries=geometry"></script>
</body>
</html>
<?php /**PATH D:\laragon\www\realmlogostics\resources\views/tracker.blade.php ENDPATH**/ ?>