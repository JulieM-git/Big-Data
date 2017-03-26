function addGrid(){
  // params
  var latmin = result[0];
      latmax = result[1];
      lonmin = result[2];
      lonmax = result[3];
      nb_col = 999;//Math.sqrt(num);
      nb_lig = 1000; //Math.sqrt(num);

  // gridlayer
  var grid = L.layerGroup();

  // creation of the grid composed of rectangles
  for (var i=0; i<nb_lig; i++){
      for (var j=0; j< nb_col; j++){
        // color corresponding of the danger
        var color=heatMapColorforValue(arr[i*nb_col+j]['pente_deg'], maxValue);
        // rectangle
        var rectanglePoints = [[latmin+j*(latmax-latmin)/nb_col, lonmin+i*(lonmax-lonmin)/nb_lig],
                              [latmin+(j+1)*(latmax-latmin)/nb_col, lonmin+(i+1)*(lonmax-lonmin)/nb_lig]];
        var rectangle = new L.rectangle(rectanglePoints, {stroke: false, fillOpacity: 0.4, color: color,fillColor: color});
        // add to the gid
        rectangle.addTo(grid);
      }
    }
    grid.addTo(map);
    map.setView(new L.LatLng((latmin+latmax)/2,(lonmax+lonmin)/2),13);
}

function addGridMoyen(arr, result, map){
  // params
  var latmin = result[0];
      latmax = result[1];
      lonmin = result[2];
      lonmax = result[3];
      nb_col = 99;//Math.sqrt(num);
      nb_lig = 100; //Math.sqrt(num);

  // gridlayer
  var grid = L.layerGroup();

  // creation of the grid composed of rectangles
  for (var i=0; i<nb_lig; i+=10){
      for (var j=0; j< nb_col; j+=10){
        // color corresponding of the danger
        var color=heatMapColorforValue(arr[i*nb_col+j]['pente_deg'], maxValue);
        // rectangle
        var rectanglePoints = [[latmin+j*(latmax-latmin)/nb_col, lonmin+i*(lonmax-lonmin)/nb_lig],
                              [latmin+(j+1)*(latmax-latmin)/nb_col, lonmin+(i+1)*(lonmax-lonmin)/nb_lig]];
        var rectangle = new L.rectangle(rectanglePoints, {stroke: false, fillOpacity: 0.4, color: color,fillColor: color});
        // add to the gid
        rectangle.addTo(grid);
      }
    }
    grid.addTo(map);
}
