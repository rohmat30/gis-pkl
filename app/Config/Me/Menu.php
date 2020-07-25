<?php


namespace Config\Me;

use CodeIgniter\Config\BaseConfig;

class Menu extends BaseConfig
{
    protected $uri;

    public function get($role)
    {
        return [
            'siswa'               => $this->menuSiswa(),
            'kajur'               => $this->menuKajur(),
            'pembimbing_lapangan' => $this->menuPembimbingLapangan(),
            'pembimbing'          => $this->menuPembimbing(),
            'staff_tu'            => $this->menuStaffTU()
        ][$role];
    }

    private function menuSiswa()
    {
        return [
            'pengajuan' => [
                'title' => 'Pengajuan Instansi',
                'icon'  => 'fas fa-diagnoses'
            ],
            'jadwal' => [
                'title' => 'Jadwal &amp; tempat',
                'icon'  => 'far fa-calendar-alt'
            ],
            'nilai' => [
                'title' => 'Nilai',
                'icon'  => 'fas fa-object-group'
            ],
            'map' => [
                'title' => 'Lokasi prakerin',
                'icon'  => 'fas fa-map'
            ]
        ];
    }

    private function menuKajur()
    {
        return [
            'nilai' => [
                'title' => 'Kelola nilai',
                'icon'  => 'fas fa-object-group'
            ],
            'evaluasi' => [
                'title' => 'Kelola evaluasi',
                'icon'  => 'fas fa-vector-square'
            ],
            'map' => [
                'title' => 'Lokasi prakerin',
                'icon'  => 'fas fa-map'
            ],
            'persetujuan' => [
                'title' => 'Persetujuan tempat',
                'icon'  => 'fas fa-vote-yea'
            ]
        ];
    }

    private function menuPembimbing()
    {
        return [
            'jadwal' => [
                'title' => 'Jadwal &amp; tempat',
                'icon'  => 'far fa-calendar-alt'
            ],
            'nilai' => [
                'title' => 'Kelola nilai',
                'icon'  => 'fas fa-object-group'
            ],
            'map' => [
                'title' => 'Lokasi prakerin',
                'icon'  => 'fas fa-map'
            ],
            'evaluasi' => [
                'title' => 'Evaluasi',
                'icon'  => 'fas fa-vector-square'
            ]
        ];
    }

    private function menuPembimbingLapangan()
    {
        return [
            'jadwal' => [
                'title' => 'Jadwal &amp; tempat',
                'icon'  => 'far fa-calendar-alt'
            ],
            'nilai' => [
                'title' => 'Kelola nilai',
                'icon'  => 'fas fa-object-group'
            ],
        ];
    }

    private function menuStaffTU()
    {
        return [
            'jadwal' => [
                'title' => 'Kelola tempat &amp; jadwal',
                'icon'  => 'far fa-calendar-alt'
            ],
            'nilai' => [
                'title' => 'Kelola nilai',
                'icon'  => 'fas fa-object-group'
            ],
            'lokasi' => [
                'title' => 'Kelola lokasi',
                'icon'  => 'fas fa-map'
            ],
            'pengguna' => [
                'title' => 'Kelola pengguna',
                'icon'  => 'fas fa-users'
            ],
            'evaluasi' => [
                'title' => 'Evaluasi',
                'icon'  => 'fas fa-vector-square'
            ],
        ];
    }

    public function getActiveMenu()
    {
        $request = service('request');
        return $request->uri->getSegment(1);
    }
}
