function initMap() {
    var etml = {lat: 46.5236838, lng: 6.6157683}; 
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 17,
        center: etml
    });

    var marker = new google.maps.Marker({
        position: etml,
        map: map,
        title: 'ETML' 
    });
}
