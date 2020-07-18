<?php
echo script_tag('assets/lib/jquery/jquery.min.js');
echo script_tag('assets/lib/bootstrap/js/bootstrap.bundle.min.js');
echo $this->renderSection('bottom_assets');
echo script_tag('assets/js/app.js');
