//Situe la carte de l'ETML grâce à la lat et lng, gère le zoom et ce sur quoi centrer
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
