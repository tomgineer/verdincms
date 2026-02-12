<?php

namespace App\Filters;

use App\Models\StatsModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class TrackVisitor implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        (new StatsModel())->trackVisitor();
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
