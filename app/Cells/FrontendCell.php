<?php
namespace App\Cells;
use CodeIgniter\View\Cells\Cell;
use App\Models\ContentModel;

// Call: view_cell('FrontendCell::footer')

class FrontendCell extends Cell {
    public string $gridStyle = '';
    public int $post_id  = 0;
    public int $topic_id = 0;
    private int $postsPerCell;
    private ContentModel $content;

    public function __construct() {
        $this->postsPerCell = setting('content.postsPerCell');
        $this->content = new ContentModel();
    }

/**
 * Build data for the navigation bar and render the nav partial.
 */
public function nav(): string {
    $data = ['menu_items' => $this->content->getMenuItems()];
    return theme_view('frontend/cells/nav', $data, ['saveData' => false]);
}

/**
 * Build footer data (lists, counts, socials) and render the footer partial.
 */
public function footer(): string {
    $data = [
        'topics_list'       => $this->content->getTopicsList(),
        'public_posts'      => $this->content->countContent('public'),
        'total_subscribers' => $this->content->countSubscribers(),
        'pages_list'        => $this->content->getPagesList(),
        'base_blocks'       => $this->content->getBlocks(['footer']),
        'socials_list'      => $this->content->getSocialsList()
    ];

    return theme_view('frontend/cells/footer', $data, ['saveData' => false]);
}

/**
 * Small Footer for bare layouts
 */
public function footerSm(): string {
    $data = [];
    return theme_view('frontend/cells/footer_sm', $data, ['saveData' => false]);
}

/**
 * Fetch featured posts and render them with the selected grid style.
 */
public function featured(): string {
    $postData = $this->content->getPosts(amount: $this->postsPerCell, featured: true);
    $data = [
        'posts' => $postData['posts'] ?? [],
        'style' => $this->gridStyle
    ];
    return view('frontend/partials/post_list_lite', $data, ['saveData' => false]);
}

/**
 * Fetch trending posts based on settings and render the list partial.
 */
public function trending(): string {
    $postData = $this->content->getRankingPosts(amount: $this->postsPerCell, type: 'trending');
    $data = [
        'posts' => $postData['posts'] ?? [],
        'style' => $this->gridStyle
    ];
    return view('frontend/partials/post_list_lite', $data, ['saveData' => false]);
}

/**
 * Fetch popular posts and render the list partial.
 */
public function popular(): string {
    $postData = $this->content->getRankingPosts(amount: $this->postsPerCell, type: 'popular');
    $data = ['posts' => $postData['posts'] ?? []];
    return view('frontend/partials/post_list_lite', $data, ['saveData' => false]);
}

/**
 * Fetch posts related to the current post/topic and render the list partial.
 */
public function related(): string {
    $post_id  = $this->post_id;
    $topic_id = $this->topic_id;

    $postData = $this->content->getRelatedPosts(id: $post_id, topic_id: $topic_id, amount: $this->postsPerCell);
    $data = [
        'posts' => $postData ?? [],
        'style' => $this->gridStyle
    ];
    return view('frontend/partials/post_list_lite', $data, ['saveData' => false]);
}

/**
 * Fetch featured posts and render the carousel partial.
 */
public function featuredCarousel(): string {
    $data = $this->content->getPosts(amount: $this->postsPerCell, featured: true) ?? [];
    return view('frontend/cells/carousel', $data, ['saveData' => false]);
}

/**
 * Render the newsletter block content.
 */
public function newsletter(): string {
    $data = $this->content->getSingleBlock('newsletter.newsletter');
    return theme_view('frontend/cells/newsletter', $data, ['saveData' => false]);
}

/**
 * Render the hero block content.
 */
public function hero(): string {
    $data = $this->content->getSingleBlock('frontpage.hero');
    return view('frontend/cells/hero', $data, ['saveData' => false]);
}

/**
 * Testimonials.
 */
public function testimonials(): string {
    $block = $this->content->getBlockGroups(['testimonials']);
    $testimonials = $block['testimonials'];
    $intro = array_shift($testimonials);

    $data = [
        'intro'        => $intro,
        'testimonials' => $testimonials
    ];

    return view('frontend/cells/testimonials', $data, ['saveData' => false]);
}

public function share(): string {
    $data = $this->content->getSingleBlock('share.share');
    return view('frontend/cells/share', $data, ['saveData' => false]);
}

} // END Class