require('./bootstrap');

$(document).ready(function() {
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
