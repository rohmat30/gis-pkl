<?php

namespace Config\Me;

use CodeIgniter\Config\BaseConfig;

class Site extends BaseConfig
{
    public $appName = 'Sistem Informasi Geografis Tempat prakerin';
    public $logo = '/assets/img/logo.png';

    private $title;
    private $breadcrumb = [];

    public function setTitle(string $title)
    {
        $this->title  = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }


    public function setBreadcrumb($breadcrumb)
    {
        $this->breadcrumb = [$breadcrumb];

        if (is_array($breadcrumb)) {
            $this->breadcrumb = $breadcrumb;
        }

        if ($breadcrumb == FALSE) {
            $this->breadcrumb = [];
        }

        return $this;
    }

    public function getBreadcrumb(): array
    {
        return $this->breadcrumb;
    }


    // menampilkan di halaman bar pada halaman
    // <title></title>
    public function appTitle()
    {
        return (isset($this->title) ? $this->title . ' · ' : NULL) .
            $this->appName;
    }
}
