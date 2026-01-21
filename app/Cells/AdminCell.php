<?php
namespace App\Cells;
use CodeIgniter\View\Cells\Cell;
use App\Models\ContentModel;

// Call: view_cell('AdminCell::stats')

class AdminCell extends Cell {
    private ContentModel $content;
    public string $statsType = '';
    public string $contentType = 'posts';

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

    $table = $this->contentType === 'pages' ? 'pages' : 'posts';
    $label = $this->contentType === 'pages' ? 'Pages' : 'Posts';

    $stats = [];
    if ($this->statsType !== '') {
        $stats[] = [
            'title' => ucfirst($this->statsType) . ' ' . $label,
            'value' => $this->content->countContent($this->statsType, [$table]),
            'desc'  => $descriptions[$this->statsType] ?? 'Pending',
        ];
    }

    $data = [
        'stats'         => $stats,
        'content_label' => $label,
        'public_count'  => $this->content->countContent('public', [$table]),
        'total_count'   => $this->content->countContent('total', [$table]),
    ];
    return view('admin/partials/stats', $data, ['saveData' => false]);
}


}
