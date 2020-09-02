<!DOCTYPE html>
<html class='use-all-space'>

<head>
    <meta http-equiv='X-UA-Compatible' content='IE=Edge' />
    <meta charset='UTF-8'>
    <title>Demo app</title>
    <meta name='viewport' content='width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no' />
    <link rel='stylesheet' type='text/css'
        href='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.38.0/maps/maps.css' />
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.38.0/maps/maps-web.min.js"></script>
    <style>
        #map {
            width: 800px;
            height: 600px;
        }
    </style>
</head>

<body>
    <div id='map' class='map'></div>
    <script>
        var map = tt.map({
            key: 'zCzh7nGD2fxwoAHG7bd6QyO8HHEv8VBU',
            container: 'map',
            style: 'tomtom://vector/1/basic-main',
            center: [-0.12634, 51.50276],
            zoom: 13
        });



    </script>
</body>

</html>