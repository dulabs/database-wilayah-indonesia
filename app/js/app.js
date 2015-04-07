var indonesia = indonesia || {};

indonesia.peta = function(div, address, latitude, longitude) {
    var visible = (function() {
        var status = false;

        return function(visible) {
            if (visible !== undefined) {
                status = visible;
            }

            return status;
        };
    }());

    var listener = function(map, marker, infowindow) {
        infowindow.open(map, marker);

        google.maps.event.addListener(marker, 'click', function() {
            if (visible()) {
                infowindow.close();
                visible(false);
            } else {
                infowindow.open(map, marker);
                visible(true);
            }
        });

        google.maps.event.addListener(infowindow, 'closeclick', function() {
            visible(false);
        });
    };

    var infowindow = function(map, marker, address) {
        var option = {
            content: address,
            maxWidth: 200
        };
        var infowindow = new google.maps.InfoWindow(option);

        listener(map, marker, infowindow);

        return infowindow;
    };

    var circle = function (map, coordinate, radius) {
        var option = {
            map: map,
            center: coordinate,
            radius: radius,
            clickable: false,
            fillColor: 'red',
            fillOpacity: 0.15,
            strokeColor: 'red',
            strokeOpacity: 0.3,
            strokeWeight: 2
        };

        return new google.maps.Circle(option);
    };

    var marker = function(map, coordinate) {
        var option = {
            clickable: true,
            map: map,
            position: coordinate
        };

        return new google.maps.Marker(option);
    };

    var init = function(div, address, latitude, longitude) {
        var geocoder = new google.maps.Geocoder();
        var coordinate = new google.maps.LatLng(latitude, longitude);
        var option = {
            center: coordinate,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 17
        };
        var map = new google.maps.Map(div, option);

        circle(map, coordinate, 150);

        geocoder.geocode({
            location: coordinate
        }, function(result, status) {
            if (result[0] && status === google.maps.GeocoderStatus.OK) {
                infowindow(map, marker(map, coordinate), address);
            }
        });
    };

    init(div, address, latitude, longitude);
};
