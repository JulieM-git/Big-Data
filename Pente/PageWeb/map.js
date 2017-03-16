function initCarte() {
  // Dimension Map
  var hauteur = document.documentElement.clientHeight;
  var mapDiv = document.getElementById('map');
  mapDiv.style.height = hauteur +'px'; // applique la hauteur de la page
  
  var map = L.map('map').setView([45.7531152, 4.827906], 17);
  // create the tile layer with correct attribution
  var tuileUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';

  var attrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';

    var osm = L.tileLayer(tuileUrl, {
        minZoom: 8,
        maxZoom: 17,
        attribution: attrib
    });

    osm.addTo(map);

}
