     function initMap() {

         // Retrieving checkbox heatmap
         var heatmap = JSON.parse(window.localStorage.getItem("heatmap"));
         var mapType = 'terrain';
         if (heatmap) {
             mapType = 'satellite';
         }

         var jsArray = JSON.parse(window.localStorage.getItem("jsArray")); // Retrieving full array
         var jsArraySize = jsArray[0].length;

         var coordinates = [];
         var heatmapCoord = [];
         for (var i = 0; i <= (jsArraySize) - 1; i++) {

             var output = {};
             output.lat = parseFloat(jsArray[1][i]);
             output.lng = parseFloat(jsArray[2][i]);
             coordinates.push(output);

             heatmapCoord.push(new google.maps.LatLng(jsArray[1][i], jsArray[2][i]));
         }

         var animal_id = jsArray[0][0];

         var map = new google.maps.Map(document.getElementById('map'), {
             zoom: 17,
             // first coordinate of the loris
             center: coordinates[0],

             mapTypeId: mapType
         });

         // Retrieving checkbox display marker clusters
         var clusters = JSON.parse(window.localStorage.getItem("clusters"));
         if (!clusters && !heatmap) {
             var flightPath = new google.maps.Polyline({
                 path: coordinates,
                 geodesic: true,
                 strokeColor: '#FF0000',
                 strokeOpacity: 1.0,
                 strokeWeight: 2
             });
             flightPath.setMap(map);

         }

         // Retrieving checkbox display markers
         var markers = JSON.parse(window.localStorage.getItem("markers"));
         if (markers || clusters && !heatmap) {
             // draw markers - put them inside param - do not always have to display//
             for (var i = 0; i < coordinates.length; i++) {
                 var coords = coordinates[i];
                 var latLng = coords;
                 var marker = new google.maps.Marker({
                     position: latLng,
                     //label: animal_id, makes it slow...
                     map: map
                 });
             }
         }

         //flightPath.setMap(map);

         if (heatmap) {
             heatmap = new google.maps.visualization.HeatmapLayer({
                 data: heatmapCoord,
                 map: map
             });
         }

         function toggleHeatmap() {
             heatmap.setMap(heatmap.getMap() ? null : map);
         }

     }