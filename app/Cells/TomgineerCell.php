<?php
namespace App\Cells;
use CodeIgniter\View\Cells\Cell;
use App\Models\ContentModel;

// Call: view_cell('TomgineerCell::hero')

class TomgineerCell extends Cell {
    private ContentModel $content;

    public function __construct() {
        $this->content = new ContentModel();
    }

/**
 * Build data for the navigation bar and render the nav partial.
 */
public function hero(): string {
    $data = $this->content->getBlocksByGroupAndAlias(['frontpage']);
    return view('themes/tomgineer/partials/hero', $data, ['saveData' => false]);
}


}
