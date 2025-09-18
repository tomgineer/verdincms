<?php namespace App\Controllers;
use App\Models\ActionsModel;
use App\Models\SystemModel;
use App\Models\ModalsModel;
use App\Models\EditContentModel;
use CodeIgniter\API\ResponseTrait;

class Ajax extends BaseController {

	use ResponseTrait;

/**
 * Handles AJAX upload of a content photo.
 *
 * - Allows only AJAX requests from users with tier >= 10.
 * - Accepts an uploaded image file under the name 'file'.
 * - Validates the file and MIME type.
 * - Delegates file processing to EditContentModel.
 * - Returns a JSON response.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function uploadContentPhoto() {
    // Ensure it's an AJAX request
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    // Ensure the user has a high enough tier
    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    // Get uploaded file
    $file = $this->request->getFile('file');

    // Validate file presence and integrity
    if (!$file || !$file->isValid()) {
        return $this->fail('Invalid file upload', 400);
    }

    // Validate allowed MIME types
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($file->getMimeType(), $allowedTypes)) {
        return $this->fail('Unsupported file type', 415);
    }

    // Get 'type' from POST data
    $type = $this->request->getPost('type');

    // Pass to model for handling
    $result = (new EditContentModel)->ajaxUploadContentPhoto($file, $type);

    // Return result as JSON
    return $this->response->setJSON($result);
}

/**
 * Handles AJAX upload of an inline photo for rich text editors.
 *
 * - Accepts only AJAX requests from users with tier >= 10.
 * - Expects an uploaded image file under the name 'file'.
 * - Validates the file presence and MIME type.
 * - Delegates file handling to EditContentModel::ajaxUploadInlinePhoto().
 * - Returns a JSON response indicating success or failure.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function uploadInlinePhoto() {
    // Ensure it's an AJAX request
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    // Ensure the user has a high enough tier
    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    // Get uploaded file
    $file = $this->request->getFile('file');

    // Validate file presence and integrity
    if (!$file || !$file->isValid()) {
        return $this->fail('Invalid file upload', 400);
    }

    // Validate allowed MIME types
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($file->getMimeType(), $allowedTypes)) {
        return $this->fail('Unsupported file type', 415);
    }

    // Pass to model for handling
    $result = (new EditContentModel)->ajaxUploadInlinePhoto($file);

    // Return result as JSON
    return $this->response->setJSON($result);
}

/**
 * Handles AJAX-based post updates for high-tier users.
 *
 * Validates the request, filters allowed fields, and updates the post via the model.
 * Returns appropriate HTTP status codes and messages on failure.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function saveContent() {
    // Ensure it's an AJAX request
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    // Ensure the user has a high enough tier
    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    // Read JSON data as an associative array
    $data = $this->request->getJSON(true);

    if (!isset($data['id']) || !is_numeric($data['id'])) {
        return $this->fail('Missing or invalid post ID.', 400);
    }

    $id = (int) $data['id'];
    unset($data['id']);

    if (empty($data['type'])) {
        return $this->fail('Missing content type.', 400);
    }

    $type = $data['type'];
    unset($data['type']);

    // Define allowed fields (based on your list)
    $allowedFields = [
        'title', 'subtitle', 'body', 'photo', 'topic_id', 'status',
        'featured', 'unlisted', 'review', 'accessibility', 'downloads',
        'words', 'created', 'user_id', 'disable_hero', 'slug', 'label',
        'icon', 'module', 'section_id', 'highlight'
    ];

    // Only keep fields that are allowed
    $updateData = array_intersect_key($data, array_flip($allowedFields));

    if (empty($updateData)) {
        return $this->fail('No valid data provided for update.', 400);
    }

    // Pass to model
    $result = (new EditContentModel)->saveContent($id, $type, $updateData);

    if (!$result) {
        return $this->fail('Database update failed.', 500);
    }

    return $this->respond([
        'success' => true,
        'id'      => $result
    ]);

}

/**
 * Executes a named dashboard action using the ActionsModel.
 *
 * Accepts POST AJAX requests only, accessible to users with tier >= 10.
 * Returns action result in JSON.
 *
 * @param string $action The action identifier.
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function run_action($action) {

    // Ensure it's an AJAX request
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    // Ensure the user has a high enough tier
    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $actionsModel = new ActionsModel();
    $result = $actionsModel->runAction($action);

    return  $this->respond($result);
}

/**
 * Handles file upload for Form Builder fields.
 *
 * Requires AJAX and tier >= 10.
 * Accepts a file and destination string and returns result as JSON.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function formBuilderUploader() {
    // Ensure it's an AJAX request
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    // Ensure the user has a high enough tier
    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $file = $this->request->getFile('file');
    $dest = $this->request->getPost('dest');

    $result = (new SystemModel)->formBuilderUpload($file, $dest);

    return $this->response->setJSON($result);
}

/**
 * Fetches an ID/label pair from a specified table for dropdown population.
 *
 * Returns a list of entries for use in dynamic form builder dropdowns.
 * Ensures table exists before querying.
 *
 * @param string $table  The name of the database table.
 * @param string $column The label column to display.
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function fetchTableColumnWithId(string $table, string $column) {

    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $result = (new SystemModel)->ajaxfetchTableColumnWithId($table, $column);
    return $this->response->setJSON($result);
}

/**
 * Fetches a single database row by table name and ID via AJAX.
 *
 * This endpoint is secured for high-tier users and only responds to AJAX requests.
 * It dynamically queries the given table and returns the row with the specified ID.
 *
 * Behavior:
 * - Validates that the request is an AJAX call.
 * - Verifies the authenticated user's tier is 10 or higher.
 * - Confirms that the given table exists in the database.
 * - Attempts to fetch a single row where `id = $id`.
 * - Responds with JSON containing either the data or an error message.
 *
 * Example URL:
 *   GET /ajax/fetchTableRowById/users/42
 *
 * @param string $table The name of the table to query.
 * @param int    $id    The ID of the row to retrieve.
 * @return \CodeIgniter\HTTP\ResponseInterface JSON response with success flag and data or error.
 */
public function fetchTableRowById(string $table, $id) {
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $response = (new SystemModel)->ajaxFetchTableRowById($table, $id);
    return $this->response->setJSON($response);
}

/**
 * Handles saving (insert/update) a table row via AJAX request.
 *
 * Delegates to SystemModel::ajaxSaveTableRowById().
 *
 * @param string $table The name of the table.
 * @param int    $id    The ID of the row. Use -1 to insert new.
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function saveTableRowById(string $table, int $id) {
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $data = $this->request->getJSON(true);

    if (!$data || !is_array($data)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid or missing data.'
        ]);
    }

    $result = (new SystemModel)->ajaxSaveTableRowById($table, $id, $data);
    return $this->response->setJSON($result);
}

/**
 * Deletes a row from the specified table by ID via AJAX.
 *
 * @param string $table The table name.
 * @param int    $id    The ID of the row to delete.
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function deleteTableRowById(string $table, int $id) {
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $result = (new SystemModel)->ajaxDeleteTableRowById($table, $id);
    return $this->response->setJSON($result);
}

/**
 * Fetches the next available ID in a table based on the given direction.
 *
 * Behavior:
 * - Validates the request to be AJAX and user tier >= 10.
 * - Calls the SystemModel to find the next (or previous) available row ID.
 * - If no next/previous ID exists, returns the current or closest available ID.
 *
 * Usage:
 * - Direction can be 'asc' (next) or 'desc' (previous).
 *
 * @param string $table     The name of the table to search.
 * @param int    $id        The current ID to find the next/previous from.
 * @param string $direction The direction to search: 'asc' for next, 'desc' for previous. Defaults to 'asc'.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface JSON response with success status and the next ID.
 */
public function fetchNextId(string $table, int $id, string $direction ='asc') {
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $result = (new SystemModel)->ajaxFetchNextId($table, $id, $direction);
    return $this->response->setJSON($result);
}

/**
 * Handles AJAX request to save a new sort order for a table.
 *
 * @param string $table The name of the database table to update.
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function sortTable(string $table) {
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $data = $this->request->getJSON(true);

    if (empty($data['sortedData']) || !is_array($data['sortedData'])) {
        return $this->failValidationErrors('Invalid sorted data format.');
    }

    $systemModel = new SystemModel();

    if (!$systemModel->ajaxSortTable($table, $data['sortedData'])) {
        return $this->fail('Failed to save sort order.');
    }

    return $this->respond([
        'success' => true,
        'message' => 'Sort order saved successfully.'
    ]);
}

/**
 * Checks if a given photo file exists on the server.
 *
 * - Accepts only AJAX requests from users with tier >= 10.
 * - Expects a JSON body with a 'filename' key.
 * - Validates the filename and checks for a corresponding .webp file in /public/images/.
 * - Returns a JSON response with a boolean 'photoExists' key.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface JSON response indicating file existence.
 */
public function checkPhotoExists() {
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $data = $this->request->getJSON(true);
    $filename = $data['filename'] ?? '';

    if (!$filename) {
        return $this->failValidationErrors('Filename is required');
    }

    $exists = is_file(FCPATH . 'images/' . $filename . '.webp');

    return $this->response->setJSON(['photoExists' => $exists]);
}

/**
 * Handles an AJAX request to search posts by a query term.
 *
 * Validates the request as AJAX, checks the query length,
 * and returns JSON-formatted search results using full-text search.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface JSON response with search results or an empty array.
 */
public function search() {
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    $term = $this->request->getGet('q');

    if (!$term || strlen($term) < 2) {
        return $this->response->setJSON([]);
    }

    $results = (new SystemModel)->ajaxSearch($term);
    return $this->response->setJSON($results);
}

// ===============================[ MODALS ]===============================

/**
 * Handles AJAX requests to populate modal <select> elements.
 *
 * Validates the request type and user tier, extracts the target table
 * and column from the JSON payload, and returns the results as JSON.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface JSON response with id/column data
 */
public function modalFillSelect() {

    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $request = $this->request->getJSON(true); // true => array

    $table  = $request['table'];
    $column = $request['column'];

    $result = (new ModalsModel)->ajaxModalFillSelect($table, $column);
    return $this->response->setJSON($result);
}

public function modalFillForm() {

    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $request = $this->request->getJSON(true); // true => array

    $id     = $request['id'];
    $table  = $request['table'];

    $result = (new ModalsModel)->ajaxModalFillForm($id, $table);
    return $this->response->setJSON($result);

}

} // ─── End of Class ───
