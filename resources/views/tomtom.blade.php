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

    <button id="geocoding">cliccami</button>
    <div id='map' class='map'></div>
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>