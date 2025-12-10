<?php namespace App\Libraries;

use splitbrain\phpQRCode\QRCode;

/**
 * ****************************************************
 * SystemCore Library — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * Core utility library providing low-level helpers and
 * system-wide functionality, including file operations,
 * image handling, formatting utilities, and data helpers.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Designed to centralize reusable, non-database system logic.
 * - Includes helpers for formatting, image processing, and file management.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class SystemCore {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Groups an array by a given key or callback.
 *
 * @param array $array The input array.
 * @param string|int|callable $key The key to group by or a callback.
 * @param mixed ...$nextKeys Optional additional keys for deeper grouping.
 * @return array Grouped array.
 */
public function arrayGroupBy(array $array, string|int|callable $key, ...$nextKeys): array {
    if (!is_string($key) && !is_int($key) && !is_callable($key)) {
        throw new InvalidArgumentException(
            'arrayGroupBy(): Key must be a string, integer, or callable.'
        );
    }

    $grouped = [];

    foreach ($array as $item) {
        $groupKey = is_callable($key) ? $key($item) : (is_object($item) ? $item->{$key} : $item[$key] ?? null);

        if ($groupKey === null) continue; // Skip items with no valid group key

        $grouped[$groupKey][] = $item;
    }

    if (!empty($nextKeys)) {
        foreach ($grouped as $group => $items) {
            $grouped[$group] = $this->arrayGroupBy($items, ...$nextKeys);
        }
    }

    return $grouped;
}

/**
 * Resize an image and generate WebP versions in various sizes.
 *
 * This method reads an image, optionally corrects its orientation using EXIF data,
 * then resizes and converts it to WebP format. It saves the full-size version and
 * any number of scaled-down variants to the specified destination path.
 *
 * Example:
 *     $sizes = [
 *         0 => ['width' => 1920, 'height' => 1080],
 *         1 => ['subdir' => 'md', 'width' => 1024],
 *         2 => ['subdir' => 'tn', 'width' => 512]
 *     ];
 *     $this->img_resize('/path/to/image.jpg', $sizes);
 *
 * @param string $source      Absolute path to the original image.
 * @param array  $sizes       Array of size specifications. The first index is the main image,
 *                            following entries are additional sizes with optional 'subdir' and 'height'.
 * @param string $destination Target folder inside /public where images will be saved (default: 'images').
 *
 * @return string Returns the bare filename (without extension) of the saved WebP images.
 *
 * @throws Exception If the image format is unsupported or processing fails.
 */
public function img_resize($source, $sizes, $destination='images') {
    // Create $img
    $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));
    $bare_name = pathinfo($source, PATHINFO_FILENAME);
    $base_path = FCPATH . $destination . DIRECTORY_SEPARATOR;
    $exif      = @exif_read_data($source);

    switch($extension){
        case 'bmp' : $img = imagecreatefromwbmp($source); break;
        case 'gif' : $img = imagecreatefromgif($source);  break;
        case 'jpg' : $img = imagecreatefromjpeg($source); break;
        case 'jpeg': $img = imagecreatefromjpeg($source); break;
        case 'png' : $img = imagecreatefrompng($source);  break;
        case 'webp': $img = imagecreatefromwebp($source); break;
        default : return "Unsupported picture type!";
    }

    // Fix Orientation
    if( $exif && isset($exif['Orientation']) ) {
        $orientation = $exif['Orientation'];
        switch ($orientation) {
            case 3  : $deg = 180; break;
            case 6  : $deg = 270; break;
            case 8  : $deg = 90;  break;
            default : $deg = 0;   break;
        }
        if ( $deg != 0 ) {$img = imagerotate($img, $deg, 0);}
    }

    // Resize & Save First
    $width  = $sizes[0]['width'];
    $height = $sizes[0]['height'];
    $destination = $base_path . $bare_name . '.webp';

    if ( $width == 'auto' || $height == 'auto') {
        copy($source, $destination);
    } else {
        $img = $this->resizeCropImage($img, $width, $height);
        imagewebp($img, $destination, 75);
    }

    // Resize & Save Smaller Sizes
    unset($sizes[0]);

    foreach ($sizes as $size) {
        $destination = $base_path . $size['subdir'] . DIRECTORY_SEPARATOR . $bare_name . '.webp';

        if ( isset($size['height']) ) {
            $img = $this->resizeCropImage($img, $size['width'], $size['height']); // Changes Aspect Ratio
        } else {
            $img = imagescale($img, $size['width']); // Preserves Aspect Ratio
        }
        imagewebp($img, $destination, 75);
    }

    // Destroy and Return
    imagedestroy($img);

    return $bare_name;
}

/**
 * Resize and center-crop an image to specific dimensions.
 *
 * This function maintains the aspect ratio of the original image
 * and crops the excess to fit the desired width and height.
 *
 * @param  \GdImage|resource  $img     The source image as a GD resource or object.
 * @param  int                $width   Target width after resize and crop.
 * @param  int                $height  Target height after resize and crop.
 * @return \GdImage|resource|null      The resized and cropped GD image resource, or null on failure.
 */
private function resizeCropImage($img, $width, $height) {
    $source_ratio  = imagesx($img) / imagesy($img);
    $new_ratio     = $width / $height;

    if( $source_ratio <= $new_ratio ) {
        $img    = imagescale($img, $width);
        $crop_y = round((imagesy($img) - $height) / 2);
        $img    = imagecrop($img, ['x' => 0, 'y' => $crop_y, 'width' => $width, 'height' => $height]);
    } else {
        $new_width = round($height * $source_ratio);
        $img       = imagescale($img, $new_width, $height);
        $crop_x    = round((imagesx($img) - $width) / 2);
        $img       = imagecrop($img, ['x' => $crop_x, 'y' => 0, 'width' => $width, 'height' => $height]);
    }
    return $img;
}

/**
 * Generates and stores a QR code in SVG format for a specific post.
 *
 * This method checks whether the QR code already exists in the filesystem.
 * If not, it generates the QR code pointing to the post URL and saves it.
 *
 * File is saved under: /public/images/qrcodes/post_{id}.svg
 *
 * @param int $id The ID of the post to generate the QR code for.
 *
 * @return void
 */
public function createQrCode($id): void {
    $filePath = FCPATH . 'images'
        . DIRECTORY_SEPARATOR . 'qrcodes'
        . DIRECTORY_SEPARATOR . 'post_' . $id . '.svg';

    // Exit early if the QR code already exists
    if (file_exists($filePath)) return;

    // Build the URL that the QR code should encode
    $url = base_url("post/{$id}");

    try {
        // Generate the QR code as an SVG string
        $svg = QRCode::svg($url, ['s' => 'qrl']);

        // Save it to the filesystem
        file_put_contents($filePath, $svg);

    } catch (\Exception $e) {
        log_message('error', 'QR Code creation failed for post ID ' . $id . ': ' . $e->getMessage());
    }
}

} // ─── End of Class ───