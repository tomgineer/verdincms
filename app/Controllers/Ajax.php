<?php namespace App\Controllers;
use App\Models\ActionsModel;
use App\Models\ModalsModel;
use App\Models\DashboardModel;
use App\Models\EditContentModel;
use App\Models\ContentModel;
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

/**
 * AJAX: Fills a modal form with data from the given table record.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface JSON response
 */
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

/**
 * Processes AJAX modal form submissions.
 *
 * Validates request, checks tier, and saves form data
 * via ModalsModel::ajaxSaveForm().
 *
 * @return \CodeIgniter\HTTP\ResponseInterface JSON response
 */
public function modalSaveForm() {
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $json = $this->request->getJSON(true); // decoded to array

    if (empty($json['table']) || empty($json['data'])) {
        return $this->failValidationErrors('Missing table or data');
    }

    $table = $json['table'];
    $data  = $json['data'];

    $result = (new ModalsModel)->ajaxSaveForm($table, $data);
    return $this->response->setJSON($result);
}

/**
 * Handles AJAX file uploads from modals.
 *
 * Validates user tier (≥10), ensures upload path exists,
 * saves the file with a random name, and returns a JSON response.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface JSON with status, filename, and field
 */
public function modalUploadFile() {
    if (!$this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $file  = $this->request->getFile('file');
    $path  = $this->request->getPost('path');
    $field = $this->request->getPost('field'); // 'image' or 'background'

    if (!$file || !$file->isValid()) {
        return $this->fail('Invalid file upload.');
    }

    // Convert path to system-safe format
    $relativePath = trim($path, '/');
    $relativePath = str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    $uploadPath = FCPATH . DIRECTORY_SEPARATOR . $relativePath;

    // Create folder if needed
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    $newName = $file->getRandomName();
    $file->move($uploadPath, $newName);

    return $this->respond([
        'status'   => 'success',
        'filename' => $newName,
        'field'    => $field,
    ]);
}

/**
 * Handles AJAX search requests and returns JSON results.
 *
 * Validates the request type, retrieves the search term from the
 * query string, and calls the model search method. Returns an
 * empty array for short or empty queries and handles exceptions
 * gracefully with proper error responses.
 *
 * @return \CodeIgniter\HTTP\ResponseInterface JSON response containing search results or an error message.
 */
public function search() {
    // Ensure it's an AJAX request
    if (! $this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    // Get search term from query string: /ajax/search?q=foo
    $query = trim((string) $this->request->getGet('q'));

    // Gracefully ignore short or empty queries
    if ($query === '' || mb_strlen($query) < 2) {
        return $this->respond([]);
    }

    try {
        // Call your model (adjust to your actual model name/method)
        $results = (new ContentModel)->search($query);

        // Ensure we always return an array
        if (! is_array($results)) {
            $results = [];
        }

        return $this->respond($results); // 200 with JSON
    } catch (\Throwable $e) {
        log_message('error', 'Search error: {message}', ['message' => $e->getMessage()]);
        return $this->failServerError('An error occurred while performing the search.');
    }
}

/**
 * Deletes multiple records from an allowed table via AJAX.
 *
 * Validates request type, user tier, table name, and IDs.
 * Delegates deletion to DashboardModel::bulk_delete().
 *
 * @return \CodeIgniter\HTTP\ResponseInterface JSON response with status, message, table, deleted_ids, and affected_rows.
 */
public function bulk_delete() {
    if (! $this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $data  = $this->request->getJSON(true);
    $table = $data['table'] ?? null;
    $ids   = $data['ids']   ?? null;

    if (! $table || ! is_array($ids) || empty($ids)) {
        return $this->failValidationErrors('Missing or invalid "table" or "ids" in payload.');
    }

    $allowedTables = ['topics', 'sections', 'blocks', 'block_groups', 'users']; // Add other allowed tables here
    if (! in_array($table, $allowedTables, true)) {
        return $this->failValidationErrors('Table not allowed for bulk delete.');
    }

    $ids = array_values(array_unique(
        array_filter(
            array_map('intval', $ids),
            static fn ($id) => $id > 0
        )
    ));

    if (empty($ids)) {
        return $this->failValidationErrors('No valid IDs provided.');
    }

    $result = (new DashboardModel)->bulk_delete($table, $ids);

    if (! $result || ($result['status'] ?? '') !== 'success') {
        return $this->failServerError('Bulk delete failed.');
    }

    // --- Respond with model’s data ---
    return $this->respond([
        'status'        => 'success',
        'message'       => 'Records deleted successfully.',
        'table'         => $table,
        'deleted_ids'   => $ids,
        'affected_rows' => $result['affected_rows'] ?? 0,
    ]);
}

/**
 * Handle AJAX request to update the sort order of records.
 *
 * Expects JSON payload:
 * {
 *   "table": "pages",        // or "topics", "sections"
 *   "order": [3, 1, 2]       // IDs in the new order
 * }
 *
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function update_order() {
    // Ensure it's an AJAX request
    if (! $this->request->isAJAX()) {
        return $this->failForbidden('Not an AJAX request.');
    }

    if (tier() < 10) {
        return $this->fail('Tier too low', 403);
    }

    $payload = $this->request->getJSON(true);
    if (! is_array($payload)) {
        return $this->failValidationError('Invalid JSON payload.');
    }

    $table = $payload['table'] ?? '';
    $order = $payload['order'] ?? [];

    // Whitelist allowed tables
    $allowedTables = ['topics', 'sections', 'pages'];
    if ($table === '' || ! in_array($table, $allowedTables, true)) {
        return $this->failValidationError('Invalid table.');
    }

    if (! is_array($order) || empty($order)) {
        return $this->failValidationError('Invalid order data.');
    }

    // Sanitize IDs
    $ids = array_values(
        array_filter(
            array_map('intval', $order),
            static fn($id) => $id > 0
        )
    );

    if (empty($ids)) {
        return $this->failValidationError('No valid IDs provided.');
    }

    try {
        (new DashboardModel)->updateOrder($table, $ids);

        return $this->respond([
            'success' => true,
            'message' => 'Order updated successfully.',
        ]);
    } catch (\Throwable $e) {
        log_message('error', 'Update order failed: ' . $e->getMessage());
        return $this->failServerError('An error occurred while updating the order.');
    }
}

} // ─── End of Class ───
