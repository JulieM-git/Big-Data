<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Pente</title>
		<!-- Metadonnees -->
		<meta charset="utf-8">
		<!-- Insertion des librairies -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
		<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
		<script src="http://d3js.org/d3.v3.min.js" language="JavaScript"></script>
    <script src="liquidFillGauge.js" language="JavaScript"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.js"></script>
		<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
<script src="http://leaflet.github.io/Leaflet.heat/dist/leaflet-heat.js"></script>

		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
		<script src="leaflet-heat.js"></script>
		<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>

		<!-- Insertion des scripts js -->
		<script src="map.js"></script>

		<!-- CSS pour l'instant -->
		<style>
			body {
				margin: 0px;
				background-color: #000000;
				overflow: hidden;
			}
			.axis path,
			.axis line {
			  fill: none;
			  stroke: #000;
			  shape-rendering: crispEdges;
			}

			.bar {
			  fill: orange;
			}

			.bar:hover {
			  fill: orangered ;
			}

			.x.axis path {
			  display: none;
			}

			.d3-tip {
			  line-height: 1;
			  font-weight: bold;
			  padding: 12px;
			  background: rgba(0, 0, 0, 0.8);
			  color: #fff;
			  border-radius: 2px;
			}

			/* Creates a small triangle extender for the tooltip */
			.d3-tip:after {
			  box-sizing: border-box;
			  display: inline;
			  font-size: 10px;
			  width: 100%;
			  line-height: 1;
			  color: rgba(0, 0, 0, 0.8);
			  content: "\25BC";
			  position: absolute;
			  text-align: center;
			}

			/* Style northward tooltips differently */
			.d3-tip.n:after {
			  margin: -1px 0 0 0;
			  top: 100%;
			  left: 0;
			}
			.liquidFillGaugeText { font-family: Arial; font-weight: bold; }
		</style>

	</head>

		<!-- Affichage Map -->


		<body onload="initCarte() ;">
			<div class='container-fluid'>
				<div class="row">
					<div class="col-md-8" style="padding:0">
						<div id="map"></div>
					</div>
					<div class="col-md-4">
						<div class='container-fluid'>
							<div class="row" style="margin:5%; min-height:50px;">
									<svg id="fillgaugemoy" width="50%" height="100"></svg>
									<p style="text-align:center; font-size:160%; color:	#FF8C00;">Pente moyenne</p>
									<svg id="fillgaugemax" width="50%" height="100"></svg>
									<p style="text-align:center; font-size:160%; color:	#8B0000;">Pente maximale</p>
							</div>
							<div class="row" style="margin:auto; min-height:50px;">
								<svg id="diagramme" width="100%" height="400"></svg>
								<p style="text-align:center; font-size:160%; color:	#FFA500;">Diagramme de Pentes</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

			<script language="JavaScript">

			/**
				* Jauge Pente Moyenne
			**/
			var pente_moyenne = 2.22;
			var pente_max = 26.97;

			var config_moy = liquidFillGaugeDefaultSettings();
			config_moy.maxValue=30 ;
			config_moy.circleColor = "#FF8C00";
			config_moy.textColor = "#FF8C00";
			config_moy.waveTextColor = "#FFAAAA";
			config_moy.waveColor = "#FF8C00";
			config_moy.circleThickness = 0.1;
			config_moy.waveAnimateTime = 1000;
			var gauge_moy = loadLiquidFillGauge("fillgaugemoy", pente_moyenne, config_moy);

			var config_max = liquidFillGaugeDefaultSettings();
			config_max.maxValue=30 ;
			config_max.circleColor = "#B22222";
			config_max.textColor = "#B22222";
			config_max.waveTextColor = "#FFAAAA";
			config_max.waveColor = "#B22222";
			config_max.circleThickness = 0.1;
			config_max.waveAnimateTime = 1000;
			var gauge_max = loadLiquidFillGauge("fillgaugemax", pente_max, config_max);

			/**
				* Diagramme Pente
			**/

			var margin = {top: 40, right: 20, bottom: 20, left: 40},
			    width = 400 ,
			    height = 300;


			var x = d3.scale.ordinal()
			    .rangeRoundBands([margin.left, width+margin.left], .1);

			var y = d3.scale.linear()
			    .range([margin.top+height, margin.top]);

			var xAxis = d3.svg.axis()
			    .scale(x)
			    .orient("bottom");

			var yAxis = d3.svg.axis()
			    .scale(y)
			    .orient("left");

			var tip = d3.tip()
			  .attr('class', 'd3-tip')
			  .offset([-10, 0])
			  .html(function(d) {
			    return " <span style='color:red'>" + d.number + "</span>";
			  })

			var svg = d3.select("svg[id='diagramme']");
			svg.attr("width", width + margin.left + margin.right)
    	svg.attr("height", height + margin.top + margin.bottom)
			svg.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
			svg.call(tip);

			d3.tsv("data.tsv", type, function(error, data) {
			  x.domain(data.map(function(d) { return d.degre; }));
			  y.domain([0, d3.max(data, function(d) { return d.number; })]);

			  svg.append("g")
			      .attr("class", "x axis")
			      .attr("transform", "translate(0," + height + ")")
			      .call(xAxis)
						.style("fill", "white");


			  svg.append("g")
			      .attr("class", "y axis")
			      .call(yAxis);

			  svg.selectAll(".bar")
			      .data(data)
			    .enter().append("rect")
			      .attr("class", "bar")
			      .attr("x", function(d) { return x(d.degre); })
			      .attr("width", x.rangeBand())
			      .attr("y", function(d) { return y(d.number); })
			      .attr("height", function(d) { if( height - y(d.number) > 0){return height - y(d.number);} else{ return 0;} })
			      .on('mouseover', tip.show)
			      .on('mouseout', tip.hide)

			});

			function type(d) {
			  d.number = +d.number;
			  return d;
			}

			</script>
		</body>

</html>
