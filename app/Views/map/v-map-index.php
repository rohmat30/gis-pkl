<?php
echo $this->extend('layout\app');

echo $this->section('head_assets');
echo link_tag('assets/lib/leaflet/leaflet.css');
echo script_tag('assets/lib/leaflet/leaflet.js');
echo link_tag('assets/lib/leaflet-control-geocoder/Control.Geocoder.css');
echo script_tag('assets/lib/leaflet-control-geocoder/Control.Geocoder.min.js');
echo $this->endSection();

// content
echo $this->section('content');
?>
<div id="map" style="height: 400px"></div>
<?php
echo $this->endSection();

// bottom assets
echo $this->section('bottom_assets');
echo script_tag('assets/js/app/app.lokasi.form.image.preview.js');
echo script_tag('assets/js/app/app.marker.icon.js');
echo script_tag('assets/js/app/app.map.js');
echo $this->endSection()
?>