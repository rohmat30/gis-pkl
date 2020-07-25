$(document).ready(function () {
  var map = L.map("map").setView([-6.7047263118838836, 107.39410400390625], 11);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
      '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors',
  }).addTo(map);

  var myJson;
  var mySelect;

  let geojsonURL = "/map/geojson";
  $.getJSON(geojsonURL, async function (data) {
    myJson = L.geoJson(data, {
      pointToLayer: function (feature, latlng) {
        let st = feature.properties.students;
        return L.marker(latlng, { icon: st ? blueIconSm : grayIconSm });
      },
      onEachFeature: function (feature, layer) {
        layer
          .on("click", function (e) {
            let popup = e.target.getPopup();
            if (typeof popup == "undefined") {
              let content = `<div class="d-flex justify-content-between" style="max-width: 320px">
                <div style="width: 80px;max-height: 80px" class="mr-2">
                    <img src="${feature.properties.photo}" class="mw-100"/>
                </div>
                <div>
                  <table class="table table-borderless p-0 m-0">
                      <tr>
                          <th class="p-0">Nama Instansi</th>
                          <td class="py-0 px-1">:</td>
                          <td class="p-0">${feature.properties.name}</td>
                      </tr>
                      <tr>
                          <th class="p-0">Alamat</th>
                          <td class="py-0 px-1">:</td>
                          <td class="p-0">${feature.properties.address}</td>
                      </tr>
                      <tr>
                          <th class="p-0">Status</th>
                          <td class="py-0 px-1">:</td>
                          <td class="p-0">${feature.properties.status}</td>
                      </tr>
                      <tr>
                        <th class="p-0">Latitude</th>
                        <td class="py-0 px-1">:</td>
                        <td class="p-0">${feature.geometry.coordinates[1]}</td>
                      </tr>
                      <tr>
                        <th class="p-0">Longitude</th>
                        <td class="py-0 px-1">:</td>
                        <td class="p-0">${feature.geometry.coordinates[0]}</td>
                      </tr>
                      <tr>
                          <th class="p-0">Jumlah siswa</th>
                          <td class="py-0 px-1">:</td>
                          <td class="p-0">${feature.properties.students} orang</td>
                      </tr>
                  </table>
                </div>
              </div>`;

              e.target.bindPopup(`${content}`).openPopup();
            }
            map.setView(e.latlng, map.getZoom());
            if (mySelect) {
              let ico = mySelect.feature.properties.students;
              mySelect.getElement().style.transition = ".35s ease all";
              mySelect.setIcon(ico > 0 ? blueIconSm : grayIconSm);
            }
            let activeIco = e.target.feature.properties.students;
            e.target.getElement().style.transition = ".35s ease all";
            e.target.setIcon(activeIco > 0 ? blueIcon : grayIcon);
            mySelect = e.target;
          })
          .bindTooltip(`${feature.properties.name}`);
      },
    });
    myJson.addTo(map);
  });

  map.on("click", function () {
    if (mySelect) {
      let ico = mySelect.feature.properties.students;
      mySelect.getElement().style.transition = ".35s ease all";
      mySelect.setIcon(ico > 0 ? blueIconSm : grayIconSm);
    }
  });
});
