<?php
namespace App\Cells;
use CodeIgniter\View\Cells\Cell;
use App\Models\ContentModel;

// Call: view_cell('FrontendCell::footer')

class FrontendCell extends Cell {

    /**
     * Build and render the frontend navigation view data.
     */
    public function nav(): string {
        $content = new ContentModel();

        $data = [
            'menu_items' => $content->getMenuItems()
        ];

        return view('frontend/partials/nav', $data, ['saveData' => false]);
    }

    /**
     * Build and render the frontend footer view data.
     */
    public function footer(): string {
        $content = new ContentModel();

        $data = [
            'topics_list'       => $content->getTopicsList(),
            'public_posts'      => $content->countContent('public'),
            'total_subscribers' => $content->countSubscribers(),
            'pages_list'        => $content->getPagesList(),
            'base_blocks'       => $content->getBlocks(['footer']),
            'socials_list'      => $content->getSocialsList()
        ];

        return view('frontend/partials/footer', $data, ['saveData' => false]);
    }
}
