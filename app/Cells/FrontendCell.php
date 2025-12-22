<?php
namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class FrontendCell extends Cell {

    public function footer(): string {
        // Call: view_cell('FrontendCell::footer')
        return view('frontend/partials/test');
    }
}