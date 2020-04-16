require('./bootstrap');

$(document).ready(function() {
  var oldquery;
  $("#address").keyup(function(event) {
    var query = event.target.value;
    oldquery = query;
    setTimeout(function(){
      if (query == oldquery) {
        console.log(query);
        $.ajax({
          url:"https://api.tomtom.com/search/2/search/" + query + ".json?",
          method:"GET",
          data: {
            "typeahead" : true,
            "lat" : 42.66,
            "lon" : 12.66,
            "language" : "it-IT",
            "idxSet" : "Geo,Str",
            "key" : "hybTDScBzqzH9mWgKjU0mSeOf7eDO4AV"
          },
          success: function(response) {
            var suggestions = [];
            for (var i = 0; suggestions.length < 5 && response.results[i]; i++) {
              if (response.results[i].type == "Geography") {
                if (response.results[i].entityType == "Municipality") {
                  suggestions.push({
                    "address" : response.results[i].address.freeformAddress,
                    "lat" : response.results[i].position.lat,
                    "lon" : response.results[i].position.lon
                  });
                }
              } else {
                suggestions.push({
                  "address" : response.results[i].address.freeformAddress,
                  "lat" : response.results[i].position.lat,
                  "lon" : response.results[i].position.lon
                });
              }
            }
            $(".dropdown-address").html("");
            $(".dropdown-address").removeClass("hidden");
            for (var index in suggestions) {
              $(".dropdown-address").append("<p>" + suggestions[index].address + "</p>");
            }
          },
          error: function() {
            console.log("error");
          }
        });
      }
    }, 600);

  });
  $(document).on("click", function(event) {
      $(".dropdown-address").addClass("hidden");
  });
  var latitude = $("#map").attr("data-lat");
  var longitude = $("#map").attr("data-lon");
  console.log(longitude);
  var center = [longitude, latitude];
  var map = tt.map({
      key: 'hybTDScBzqzH9mWgKjU0mSeOf7eDO4AV',
      container: 'map',
      style: 'tomtom://vector/1/basic-main',
      center: [longitude, latitude],
      zoom: 10
  });

  var config = {
      key: 'hybTDScBzqzH9mWgKjU0mSeOf7eDO4AV',
      style: 'tomtom://vector/2/relative',
      refresh: 30000
  };

  map.on('load', function() {
      map.addTier(new tt.TrafficFlowTilesTier(config));
  });

  map.addControl(new tt.FullscreenControl());
  map.addControl(new tt.NavigationControl());

  var marker = new tt.Marker({
      draggable: false
  }).setLngLat(center).addTo(map);

  function onDragEnd() {
      var lngLat = marker.getLngLat();
      lngLat = new tt.LngLat(roundLatLng(lngLat.lng), roundLatLng(lngLat.lat));

      popup.setHTML(lngLat.toString());
      popup.setLngLat(lngLat);
      marker.setPopup(popup);
      marker.togglePopup();
  }

  marker.on('dragend', onDragEnd);

});
