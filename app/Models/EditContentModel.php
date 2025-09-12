<?php namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\QRCode;

/**
 * ****************************************************
 * EditContent Model — Voralis Core 2026 Edition
 * ****************************************************
 *
 * Primary Responsibilities
 * ------------------------
 * • Retrieve, create, and save post/page content
 * • Manage user metadata, topics, sections, and user groups
 * • Handle image uploads and conversions to WebP with automatic thumbnails
 * • Generate QR codes for new posts
 *
 * Version : Voralis Core 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes
 * -----
 * - Optimized for PHP 8.3 and CodeIgniter 4.x
 * - Requires GD library for image processing
 * - Ensure proper write permissions for WRITEPATH and FCPATH
 *
 * ****************************************************
 */

class EditContentModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Get a post or page by its ID.
 *
 * @param string $type Either 'post' or 'page'.
 * @param int $id The content ID.
 * @return array|null The content data as an associative array, or null if not found.
 */
public function getContent(string $type, int|string $id): ?array {

    if ($id==='new') {
        return $this->initNewContent($type);
    }

    $table = $type === 'post' ? 'posts' : 'pages';

    return $this->db->table($table)
                    ->where('id', $id)
                    ->get()
                    ->getRowArray();
}

/**
 * Initializes a default content array for a new post or page.
 *
 * Returns a pre-filled content structure with sensible defaults.
 * Adds type-specific fields for 'post' or 'page'.
 *
 * @param string $type The content type ('post' or 'page').
 * @return array The initialized content data, or an empty array for unknown types.
 *
 * @throws Exception If random_bytes() fails.
 */
private function initNewContent(string $type): array {
    $common = [
        'id'             => 0,
        'title'          => '',
        'subtitle'       => '',
        'body'           => 'Your next masterpiece begins here...',
        'photo'          => '',
        'status'         => 2,
        'user_id'        => session('user_id'),
        'hits'           => 0,
        'words'          => 0,
        'accessibility'  => 0,
        'featured'       => 0,
        'review'         => 0,
        'highlight'      => 0,
        'created'        => date('Y-m-d H:i:s'),
    ];

    return match ($type) {
        'post' => [...$common, 'topic_id' => 1, 'unlisted' => 0],
        'page' => [...$common,
            'section_id'   => 1,
            'slug'         => 'p-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)),
            'label'        => 'New Page',
            'module'       => '',
            'icon'         => 'page',
            'disable_hero' => 0,
        ],
        default => [],
    };
}

/**
 * Get a list of users with ID and full name (last name, first name).
 *
 * @return array|null Returns an array of users, each with 'id' and 'user' keys, or null if no users found.
 */
public function getUsers(): ?array {
    return $this->db->table('users')
                    ->select("id, CONCAT(last_name, ', ', first_name) AS user")
                    ->orderBy('user', 'ASC')
                    ->get()
                    ->getResultArray();
}

/**
 * Get a list of topics with ID, title, and number of posts.
 *
 * @return array|null Returns an array of topics, each with 'id', 'title', and 'posts' keys, or null if no topics found.
 */
public function getTopics(): ?array {
    return $this->db->table('topics')
                    ->select("id, title, posts")
                    ->orderBy('title', 'ASC')
                    ->get()
                    ->getResultArray();
}

/**
 * Get a list of sections with ID and title.
 *
 * @return array|null Returns an array of sections, each with 'id' and 'title' keys, or null if no sections found.
 */
public function getSections(): ?array {
    return $this->db->table('sections')
                    ->select("id, title, slug")
                    ->orderBy('title', 'ASC')
                    ->get()
                    ->getResultArray();
}

/**
 * Get user groups including custom groups (Members, Everyone).
 *
 * @return array Returns an array of user groups with 'tier' and 'title' keys.
 */
public function getUserGroups(): array {
    $groups = $this->db->table('user_groups')
        ->select("tier, title")
        ->orderBy('title', 'DESC')
        ->get()
        ->getResultArray();

    $customGroups = [
        ['tier' => 1, 'title' => 'Members'],
        ['tier' => 0, 'title' => 'Everyone']
    ];

    // Merge
    $allGroups = array_merge($customGroups, $groups);

    // Sort by tier ascending
    usort($allGroups, function ($a, $b) {
        return $a['tier'] <=> $b['tier'];
    });

    return $allGroups;
}

/**
 * Handles an AJAX image upload by generating 1024x1024 and 512x512 WebP thumbnails.
 *
 * - Saves the large image to /public/images/
 * - Saves the smaller thumbnail to /public/images/tn/
 * - Deletes the original uploaded file after processing
 *
 * @param \CodeIgniter\HTTP\Files\UploadedFile|null $file
 * @return array
 */
public function ajaxUploadContentPhoto(?\CodeIgniter\HTTP\Files\UploadedFile $file, string $type): array {
    if (!$file || !$file->isValid()) {
        return ['success' => false, 'error' => 'Invalid file upload.'];
    }

    if (!in_array($type, ['post', 'page'])) {
        return ['success' => false, 'error' => 'Invalid content type.'];
    }

    $baseName    = pathinfo($file->getRandomName(), PATHINFO_FILENAME); // without extension
    $extension   = $file->getExtension();
    $tempName    = $baseName . '.' . $extension;
    $tempDir     = WRITEPATH . 'uploads/';
    $tempPath    = $tempDir . $tempName;

    $imagesDir   = FCPATH . 'images/';
    $thumbsDir   = $imagesDir . 'tn/';
    $xsThumbsDir = $imagesDir . 'xs/';
    $mainPath    = $imagesDir . $baseName . '.webp';
    $thumbPath   = $thumbsDir . $baseName . '.webp';
    $xsThumbPath = $xsThumbsDir . $baseName . '.webp';

    // Ensure directories exist
    foreach ([$tempDir, $imagesDir, $thumbsDir, $xsThumbsDir] as $dir) {
        if (!is_dir($dir)) mkdir($dir, 0755, true);
    }

    // Move file to writable/uploads
    $file->move($tempDir, $tempName);

    if ($type==='post') {
        // Create 1024x1024 image
        $mainResult = $this->createThumbnail($tempPath, $mainPath, 1024, 1024);
    } else {
        // Create 2304x960 image -- 1536 x 640 Base x 1.5 Upscale = 2304 x 960
        $mainResult = $this->createThumbnail($tempPath, $mainPath, 2304, 960);
    }

    if ($mainResult !== true) {
        return ['success' => false, 'error' => 'Main image error: ' . $mainResult];
    }

    // Create appropriate thumbnail based on type
    if ($type === 'page') {
        // 1536 x 640 for pages
        $thumbResult = $this->createThumbnail($tempPath, $thumbPath, 1536, 640);
    } else {
        // 512 x 512 for posts
        $thumbResult = $this->createThumbnail($tempPath, $thumbPath, 512, 512);
    }

    if ($thumbResult !== true) {
        return ['success' => false, 'error' => 'Thumbnail error: ' . $thumbResult];
    }

    // Create 256x256 thumbnail
    $xsResult = $this->createThumbnail($tempPath, $xsThumbPath, 256, 256);
    if ($xsResult !== true) {
        return ['success' => false, 'error' => 'XS thumbnail error: ' . $xsResult];
    }

    // Clean up temp file
    @unlink($tempPath);

    return [
        'success'  => true,
        'filename' => $baseName,
    ];
}

/**
 * Handles uploading and processing of an inline image.
 *
 * Moves the uploaded file to a temporary location, resizes it to a maximum
 * of 1280x1280 pixels while preserving aspect ratio, saves it as a WebP image
 * in the public images directory, and deletes the temporary file.
 *
 * @param \CodeIgniter\HTTP\Files\UploadedFile|null $file The uploaded image file.
 *
 * @return array{
 *     success: bool,
 *     filename?: string,
 *     error?: string
 * }
 */
public function ajaxUploadInlinePhoto(?\CodeIgniter\HTTP\Files\UploadedFile $file): array {
    if (!$file || !$file->isValid()) {
        return ['success' => false, 'error' => 'Invalid file upload.'];
    }

    $baseName    = pathinfo($file->getRandomName(), PATHINFO_FILENAME); // without extension
    $extension   = $file->getExtension();
    $tempName    = $baseName . '.' . $extension;
    $tempDir     = WRITEPATH . 'uploads/';
    $tempPath    = $tempDir . $tempName;

    $imagesDir   = FCPATH . 'images/';
    $mainPath    = $imagesDir . $baseName . '.webp';

    // Ensure directories exist
    foreach ([$tempDir, $imagesDir] as $dir) {
        if (!is_dir($dir)) mkdir($dir, 0755, true);
    }

    // Move file to writable/uploads
    $file->move($tempDir, $tempName);

    // Create image
    $mainResult = $this->createThumbnail($tempPath, $mainPath, 1600, 1600, true);
    if ($mainResult !== true) {
        return ['success' => false, 'error' => 'Main image error: ' . $mainResult];
    }

    // Clean up temp file
    @unlink($tempPath);

    return [
        'success'  => true,
        'filename' => $baseName,
        'url'      => base_url('images/' . $baseName . '.webp')
    ];

}

/**
 * Creates a resized and optionally center-cropped thumbnail from a source image and saves it as WebP.
 *
 * Supports JPEG, PNG, GIF, WebP, and BMP formats. Automatically corrects EXIF orientation.
 *
 * @param string  $source          Full path to the source image.
 * @param string  $destination     Full path to save the resized WebP image.
 * @param int     $width           Final thumbnail width.
 * @param int     $height          Final thumbnail height.
 * @param bool    $preserveAspect  If true, scales to fit; if false, image is center-cropped.
 *
 * @return bool|string             True on success, or error message on failure.
 */
private function createThumbnail(
    string $source,
    string $destination,
    int $width,
    int $height,
    bool $preserveAspect = false
): bool|string {
    try {
        $destDir = dirname($destination);
        if (!is_dir($destDir) || !is_writable($destDir)) {
            return "Destination directory not writable: $destDir";
        }

        $mimeType = mime_content_type($source);
        switch ($mimeType) {
            case 'image/jpeg': $img = imagecreatefromjpeg($source); break;
            case 'image/png' : $img = imagecreatefrompng($source);  break;
            case 'image/gif' : $img = imagecreatefromgif($source);  break;
            case 'image/webp': $img = imagecreatefromwebp($source); break;
            case 'image/bmp' : $img = imagecreatefromwbmp($source); break;
            default: return "Unsupported image type: $mimeType";
        }

        // EXIF orientation correction
        if ($mimeType === 'image/jpeg' && function_exists('exif_read_data')) {
            $exif = @exif_read_data($source);
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                switch ($orientation) {
                    case 3: $img = imagerotate($img, 180, 0); break;
                    case 6: $img = imagerotate($img, 270, 0); break;
                    case 8: $img = imagerotate($img, 90, 0);  break;
                }
            }
        }

        $srcWidth  = imagesx($img);
        $srcHeight = imagesy($img);

        if ($preserveAspect) {
            // Resize while preserving aspect ratio
            $ratio = min($width / $srcWidth, $height / $srcHeight);
            $newWidth  = (int)($srcWidth * $ratio);
            $newHeight = (int)($srcHeight * $ratio);

            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($thumb, $img, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);
        } else {
            // Resize and center-crop (like CI4's fit)
            $srcRatio = $srcWidth / $srcHeight;
            $dstRatio = $width / $height;

            if ($srcRatio > $dstRatio) {
                // Source is wider than destination
                $scaledHeight = $height;
                $scaledWidth = (int)($height * $srcRatio);
            } else {
                // Source is taller than destination
                $scaledWidth = $width;
                $scaledHeight = (int)($width / $srcRatio);
            }

            // Scale first
            $scaled = imagecreatetruecolor($scaledWidth, $scaledHeight);
            imagecopyresampled($scaled, $img, 0, 0, 0, 0, $scaledWidth, $scaledHeight, $srcWidth, $srcHeight);

            // Then crop center
            $thumb = imagecreatetruecolor($width, $height);
            $xOffset = (int)(($scaledWidth - $width) / 2);
            $yOffset = (int)(($scaledHeight - $height) / 2);
            imagecopy($thumb, $scaled, 0, 0, $xOffset, $yOffset, $width, $height);

            imagedestroy($scaled);
        }

        $result = imagewebp($thumb, $destination, 75);
        imagedestroy($img);
        imagedestroy($thumb);

        if (!$result || !is_file($destination)) {
            return "Failed to save image: $destination";
        }

        return true;
    } catch (\Throwable $e) {
        log_message('error', 'Thumbnail creation error: ' . $e->getMessage());
        return $e->getMessage();
    }
}

/**
 * Saves content to the database by either inserting a new record or updating an existing one.
 *
 * If $id is 0, a new record is inserted into the corresponding table ('posts' or 'pages').
 * If the content type is 'post' and a new record is inserted, a QR code will be generated.
 * If $id is non-zero, the existing record is updated.
 *
 * @param int $id The ID of the content. Use 0 to insert new content.
 * @param string $type The type of content ('post' or 'page').
 * @param array $updateData The data to insert or update.
 *
 * @return int|false The ID of the inserted or updated record, or false on failure.
 */
public function saveContent(int $id, string $type, array $updateData): int|false {
    $table = ($type === 'post') ? 'posts' : 'pages';

    // Update existing content
    if ($id !== 0) {
        $success = $this->db->table($table)
                            ->where('id', $id)
                            ->update($updateData);
        return $success ? $id : false;
    }

    // Insert new content
    if (!$this->db->table($table)->insert($updateData)) {
        return false;
    }

    $insertID = $this->db->insertID();

    // Generate QR code only for posts
    ($type === 'post') && $this->createQrCode($insertID);

    return $insertID;
}

/**
 * Generates a QR code SVG file for a specific post ID if it doesn't already exist.
 *
 * The QR code encodes the URL to the post, e.g., site_url('post/{id}'),
 * and is saved to the /public/images/qrcodes/ directory.
 *
 * @param int $id The ID of the post for which the QR code is generated.
 *
 * @return void
 */
public function createQrCode(int $id): void {
    $filePath = FCPATH . 'images' . DIRECTORY_SEPARATOR . 'qrcodes' . DIRECTORY_SEPARATOR . "post_{$id}.svg";

    // Ensure the target directory exists
    $dir = dirname($filePath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    // Skip creation if file already exists
    if (file_exists($filePath)) {
        return;
    }

    $url = site_url("post/{$id}");

    try {
        $svg = QRCode::svg($url, ['s' => 'qrl']);
        file_put_contents($filePath, $svg);
    } catch (\Exception $e) {
        log_message('error', "QR Code creation failed for post ID {$id}: " . $e->getMessage());
    }
}


} // ─── End of Class ───