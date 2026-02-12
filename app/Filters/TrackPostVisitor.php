<?php

namespace App\Filters;

use App\Models\StatsModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class TrackPostVisitor implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $id = (int) $request->getUri()->getSegment(2);

        if ($id > 0) {
            (new StatsModel())->trackVisitor($id);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
