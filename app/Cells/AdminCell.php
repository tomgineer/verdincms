<?php
namespace App\Cells;
use CodeIgniter\View\Cells\Cell;
use App\Models\ContentModel;

// Call: view_cell('AdminCell::stats')

class AdminCell extends Cell {
    private ContentModel $content;
    public string $statsType = '';

    public function __construct() {
        $this->content = new ContentModel();
    }

/**
 * Build data for the navigation bar and render the nav partial.
 */
public function stats(): string {
    $descriptions = [
        'drafts' => 'Unpublished or Deleted',
        'review' => 'Awaiting Editorial Review',
    ];

    $stats = [];
    if ($this->statsType !== '') {
        $stats[] = [
            'title' => ucfirst($this->statsType),
            'value' => $this->content->countContent($this->statsType),
            'desc'  => $descriptions[$this->statsType] ?? 'Pending',
        ];
    }

    $data = [
        'stats'        => $stats,
        'public_posts' => $this->content->countContent('public'),
        'total_posts'  => $this->content->countContent('total'),
    ];
    return view('admin/partials/stats', $data, ['saveData' => false]);
}


}
