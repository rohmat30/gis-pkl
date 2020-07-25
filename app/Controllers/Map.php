<?php

namespace App\Controllers;

use App\Models\InstansiModel;

class Map extends BaseController
{
    protected $instansiModel;
    public function __construct()
    {
        $this->instansiModel = new InstansiModel;
    }
    public function index()
    {
        site()->setTitle('Lokasi prakerin')
            ->setBreadcrumb('Lokasi prakerin');
        return view('map\v-map-index');
    }
    //--------------------------------------------------------------------
    public function geojson()
    {
        $data = $this->instansiModel
            ->geojson();
        return $this->response->setJSON($data);
    }
}
