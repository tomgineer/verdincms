<?php

namespace App\Filters;

use App\Models\ContentModel;
use App\Models\StatsModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class TrackPageVisitor implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $slug = (string) $request->getUri()->getSegment(2);

        if ($slug === '') {
            return;
        }

        $id = (new ContentModel())->getIdFromSlug($slug, 'pages');

        if (! empty($id)) {
            (new StatsModel())->trackVisitor((int) $id, 'page');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
