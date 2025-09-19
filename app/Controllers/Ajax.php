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


} // ─── End of Class ───
