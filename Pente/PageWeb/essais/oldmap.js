function initCarte() {
  // Dimension Map
  var hauteur = document.documentElement.clientHeight;
  var mapDiv = document.getElementById('map');
  mapDiv.style.height = hauteur +'px'; // applique la hauteur de la page

    $(document).ready(function() {
      $.ajax({
        type: "GET",
        url: "coord.csv",
        dataType: "text",
        success: function(data){displayData(data)}
      });
    });

    //now the function that is called after the file was loaded
    function csvToArray(csvString){
      // The array we're going to build
      var csvArray   = [];
      // Break it into rows to start
      var csvRows    = csvString.split(/\n/);
      // Take off the first line to get the headers, then split that into an array
      var csvHeaders = csvRows.shift().split(',');

      // Loop through remaining rows
      for(var rowIndex = 0; rowIndex < csvRows.length-1; ++rowIndex){
        var rowArray  = csvRows[rowIndex].split(',');

        // Create a new row object to store our data.
        var rowObject = csvArray[rowIndex] = {};

        // Then iterate through the remaining properties and use the headers as keys
        for(var propIndex = 0; propIndex < rowArray.length; ++propIndex){
          // Grab the value from the row array we're looping through...
          var propValue =   rowArray[propIndex].replace(/^","$/g,'');
          // ...also grab the relevant header (the RegExp in both of these removes quotes)
          var propLabel = csvHeaders[propIndex].replace(/^","$/g,'');;

          rowObject[propLabel] = propValue;
        }
      }

      return csvArray;
    }

    function displayData(Text){
      data = csvToArray(Text);

      data_array= [0,0,0]; //create it before filling
       for (i = 0; i < data.length-1; i++) {
         data_array[i] = [parseFloat(data[i].lat), parseFloat(data[i].lon), parseFloat(data[i].pente)]; // if values are marked as string in the object else:

      //  data_array[i] = [data[i].lat,data[i].lon,data[i].val];
      };
      //console.log(data_array);


    //here comes the leaflet standard for the basemap:
    var map = L.map('map').setView([lat_moyenne,lon_moyenne], 12);
    // create the tile layer with correct attribution
    var tuileUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
    var attrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
      var osm = L.tileLayer(tuileUrl, {
          minZoom: 8,
          maxZoom: 17,
          attribution: attrib
      });
    osm.addTo(map);
    var heat = L.heatLayer(data_array,{
           blur: 20,
          radius: 10,
      }).addTo(map);
    }
}
