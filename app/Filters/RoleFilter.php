<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Exceptions\PageNotFoundException;


class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $roles = null)
    {
        helper('info');
        $role = user()->role;

        if (isset($role) && !in_array($role, $roles)) {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}
