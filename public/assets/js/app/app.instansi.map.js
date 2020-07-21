$(document).ready(function () {
  let ico = $("#map").data("icon");

  function coordMarker(coords) {
    let lat = coords.lat.toFixed(6);
    let lng = coords.lng.toFixed(6);
    return `lat: ${lat.toString()}<br>
      lng: ${lng.toString()}`;
  }
  var map = L.map("map").setView([-6.6847263118838836, 107.39410400390625], 12);
  var marker;
  var markerSelect;

  function getMarker(c) {
    let caption = coordMarker(c);
    caption += `<br><button type="button" class="btn btn-poppup-map create-coord">Jadikan kordinat</button>`;
    if (marker) {
      marker.setLatLng([c.lat, c.lng]).setPopupContent(caption).openPopup();
      if (marker.getElement().style.display == "none") {
        marker.getElement().style.display = "block";
        marker._shadow.style.display = "block";
      }
    } else {
      marker = L.marker([c.lat, c.lng], { icon: redIcon })
        .bindPopup(caption)
        .addTo(map)
        .on("click", function (e) {})
        .openPopup();
    }
  }

  function getMarkerSelect(c) {
    let caption = coordMarker(c);

    if (markerSelect) {
      markerSelect
        .setLatLng([c.lat, c.lng])
        .setPopupContent(caption)
        .openPopup();
    } else {
      markerSelect = L.marker([c.lat, c.lng], { icon: tealIcon })
        .bindPopup(caption)
        .addTo(map)
        .openPopup();
    }
  }
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
      '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors',
  }).addTo(map);

  var geocoder = L.Control.Geocoder.nominatim({
    geocodingQueryParams: {
      "accept-language": "id",
      countrycodes: "id",
    },
  });

  var control = L.Control.geocoder({
    placeholder: "Pencarian...",
    geocoder: geocoder,
    defaultMarkGeocode: false,
    errorMessage: "Tidak ditemukan.",
  });
  control
    .on("markgeocode", function (e) {
      let zoom = map.getZoom();
      let r = e.geocode;
      if (zoom < 15) {
        map.setView([r.center.lat, r.center.lng], 15);
      } else {
        map.setView([r.center.lat, r.center.lng], zoom);
      }
      getMarker(r.center);
    })
    .addTo(map);

  map.on("click", function (e) {
    getMarker(e.latlng);
  });

  $(document).on("click", "button.create-coord", function () {
    let latlng = marker.getLatLng();
    let zoom = map.getZoom();

    if (markerSelect) {
      markerSelect
        .setLatLng([latlng.lat, latlng.lng])
        .setPopupContent(coordMarker(latlng))
        .openPopup();
    } else {
      getMarkerSelect(latlng);
    }

    marker.getElement().style.display = "none";
    marker._shadow.style.display = "none";

    $("#koordinat").val([latlng.lat.toFixed(6), latlng.lng.toFixed(6)].join());
    map.setView([latlng.lat, latlng.lng], zoom < 15 ? 15 : zoom);
  });

  if ($("#koordinat").val().length) {
    let val = $("#koordinat").val();
    let coords = decodeURIComponent(val).split(",");

    if (coords.length == 2) {
      let latlng = { lat: Number(coords[0]), lng: Number(coords[1]) };
      if (!isNaN(latlng.lat) && !isNaN(latlng.lng)) {
        let zoom = map.getZoom();
        map.setView([latlng.lat, latlng.lng], zoom < 15 ? 15 : zoom);
        getMarkerSelect(latlng);
      }
    }
  }

  $("#koordinat").on("keyup", function () {
    let val = $(this).val();
    let coords = decodeURIComponent(val).split(",");

    if (coords.length == 2) {
      let latlng = { lat: Number(coords[0]), lng: Number(coords[1]) };
      if (!isNaN(latlng.lat) && !isNaN(latlng.lng)) {
        let zoom = map.getZoom();
        if (zoom < 15) {
          map.setView(coords, 15);
        } else {
          map.setView(coords, zoom);
        }

        getMarkerSelect(latlng);
      }
    }
  });
});
