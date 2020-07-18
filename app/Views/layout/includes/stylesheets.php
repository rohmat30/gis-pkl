<?php
echo link_tag('assets/lib/bootstrap/css/bootstrap.min.css');
echo link_tag('assets/lib/fontawesome/css/all.min.css');
echo $this->renderSection('head_assets');
echo link_tag('assets/css/app.css');
echo $this->renderSection('other_assets');
