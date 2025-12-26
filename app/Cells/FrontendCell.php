<?php
namespace App\Cells;
use CodeIgniter\View\Cells\Cell;
use App\Models\ContentModel;

// Call: view_cell('FrontendCell::footer')

class FrontendCell extends Cell {
    public string $gridStyle = '';
    public int $post_id  = 0;
    public int $topic_id = 0;

public function nav(): string {
    $content = new ContentModel();
    $data = ['menu_items' => $content->getMenuItems()];
    return view('frontend/partials/nav', $data, ['saveData' => false]);
}

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

public function featured(): string {
    $content = new ContentModel();
    $postData = $content->getPosts(amount: 10, featured: true);
    $data = [
        'posts' => $postData['posts'] ?? [],
        'style' => $this->gridStyle
    ];
    return view('frontend/partials/post_list_lite', $data, ['saveData' => false]);
}

public function trending(): string {
    $content = new ContentModel();
    $postData = $content->getRankingPosts(amount: 10, type: 'trending');
    $data = [
        'posts' => $postData['posts'] ?? [],
        'style' => $this->gridStyle
    ];
    return view('frontend/partials/post_list_lite', $data, ['saveData' => false]);
}

public function popular(): string {
    $content = new ContentModel();
    $postData = $content->getRankingPosts(amount: 10, type: 'popular');
    $data = ['posts' => $postData['posts'] ?? []];
    return view('frontend/partials/post_list_lite', $data, ['saveData' => false]);
}

public function related(): string {
    $post_id  = $this->post_id;
    $topic_id = $this->topic_id;

    $content = new ContentModel();
    $postData = $content->getRelatedPosts(id: $post_id, topic_id: $topic_id);
    $data = [
        'posts' => $postData ?? [],
        'style' => $this->gridStyle
    ];
    return view('frontend/partials/post_list_lite', $data, ['saveData' => false]);
}

public function featuredBlock(): string {
    $content = new ContentModel();
    $data = $content->getPosts(amount: 10, featured: true) ?? [];
    return view('frontend/partials/featured_block', $data, ['saveData' => false]);
}

}
