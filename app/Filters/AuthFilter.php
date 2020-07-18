<?php

namespace App\Filters;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        helper('info');
        if (empty(user()->isLoggedIn())) {
            if (empty($request->uri->getSegment(1))) {
                return redirect()->to('/login');
            }
            throw PageNotFoundException::forPageNotFound();
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
    }
}
