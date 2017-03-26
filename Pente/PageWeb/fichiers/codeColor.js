
// rgb
// value between 0 and 1
function codeColorRed(value, maxValue){
  var r = Math.floor(value/maxValue * 255);
  var g = 0;
  var b = 0;
  return color= "rgb("+r+" ,"+g+","+ b+")";
}

// hsl
// value between 0 and 1
function heatMapColorforValue(value, maxValue){
  var h = (1.0 - value /maxValue) * 130;
  return "hsl(" + h + ", 100%, 50%)";
}
