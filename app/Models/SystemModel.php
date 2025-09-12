<?php namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\SystemCore;

/**
 * ****************************************************
 * System Model — Voralis Core 2026 Edition
 * ****************************************************
 *
 * Handles low-level system operations such as file cleanup,
 * versioning, maintenance tasks, and internal utilities.
 *
 * Version : Voralis Core 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Optimized for safe background tasks and housekeeping routines.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class SystemModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Identifies orphaned image filenames.
 *
 * Compares image files on disk with those used in the database
 * (from both photo fields and embedded <img> tags in post/page bodies).
 *
 * @return array  Filenames (without extension) of unused images
 */
public function getOrphanPhotos(): array {
    $picsPath = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

    // 1. Get all .webp image filenames on the server (without extension)
    $serverPics = glob($picsPath . '*.webp');
    $serverPics = array_map(fn($pic) => pathinfo($pic, PATHINFO_FILENAME), $serverPics);
    $serverPics = array_unique($serverPics);

    // 2. Get post photos (photo field + from body)
    $postPhotos     = array_unique($this->dbGetColumn('posts', 'photo', 'photo != ""'));
    $postBodies     = $this->dbGetColumn('posts', 'body', 'body LIKE "%<img%"');
    $postPhotosBody = [];

    foreach ($postBodies as $html) {
        foreach ($this->findPicsInHTML($html) as $src) {
            $postPhotosBody[] = pathinfo($src, PATHINFO_FILENAME);
        }
    }

    $postPhotosBody = array_unique($postPhotosBody);

    // 3. Get page photos (photo field + from body)
    $pagePhotos     = array_unique($this->dbGetColumn('pages', 'photo', 'photo != ""'));
    $pageBodies     = $this->dbGetColumn('pages', 'body', 'body LIKE "%<img%"');
    $pagePhotosBody = [];

    foreach ($pageBodies as $html) {
        foreach ($this->findPicsInHTML($html) as $src) {
            $pagePhotosBody[] = pathinfo($src, PATHINFO_FILENAME);
        }
    }

    $pagePhotosBody = array_unique($pagePhotosBody);

    // 4. Merge all used photos and remove duplicates
    $usedPhotos = array_unique(array_merge(
        $postPhotos,
        $postPhotosBody,
        $pagePhotos,
        $pagePhotosBody
    ));

    // 5. Return all photos on server that aren't used
    return array_diff($serverPics, $usedPhotos);
}

/**
 * Retrieves a single column of values from a database table.
 *
 * Optionally applies a WHERE clause to filter results.
 *
 * @param string $table   Table name
 * @param string $column  Column name to fetch
 * @param string $where   Optional WHERE condition
 * @return array          Flat array of column values
 */
private function dbGetColumn(string $table, string $column, string $where = ''): array {
    $builder = $this->db->table($table)->select($column);
    if ($where !== '') {
        $builder->where($where);
    }
    return array_column($builder->get()->getResultArray(), $column);
}

/**
 * Extracts image filenames from <img src="..."> tags in HTML.
 *
 * Returns only the basename (filename without path).
 *
 * @param string $html  HTML content to parse
 * @return array        List of image filenames
 */
private function findPicsInHTML($html) {
    $img_array = array();
    $doc = new \DOMDocument();
    @$doc->loadHTML($html);
    $tags = $doc->getElementsByTagName('img');

    foreach ($tags as $tag) {
       $path = $tag->getAttribute('src');
       array_push($img_array,basename($path));
    }
    return $img_array;
}

/**
 * Generates a complete SEO-friendly sitemap.xml file.
 *
 * Includes homepage, topics, pages, and posts with dynamic lastmod, priority, and changefreq values.
 *
 * @return void
 */
public function generateSitemap(): void {
    // --- SEO Change Frequencies ---
    $changeFreq = [
        'homepage' => 'daily',    // Homepage content updates frequently
        'topics'   => 'weekly',   // Topics may change with new posts
        'posts'    => 'weekly',   // Posts may be edited or refreshed
        'pages'    => 'monthly',  // Static pages change less frequently
    ];
    // --- SEO Priorities ---
    $priority = [
        'homepage' => '1.0', // Homepage: most important, updated often
        'topics'   => '0.8', // Category/topic listing pages
        'posts'    => '0.7', // Individual blog posts
        'pages'    => '0.6', // Static pages (about, contact, etc.)
    ];

    // Fetch content
    $posts  = $this->getSitemapData('posts');
    $pages  = $this->getSitemapData('pages');
    $topics = $this->getSitemapData('topics');

    $sitemapPath = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'sitemap.xml';
    $sitemapFile = fopen($sitemapPath, 'w') or die("Unable to open file!");

    $sm  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $sm .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Homepage
    $sm .= "
    <url>
        <loc>" . base_url() . "</loc>
        <lastmod>" . date('c') . "</lastmod>
        <changefreq>{$changeFreq['homepage']}</changefreq>
        <priority>{$priority['homepage']}</priority>
    </url>\n";

    // Topics
    foreach ($topics as $topic) {
        $sm .= "
    <url>
        <loc>" . site_url('topic/' . $topic['slug']) . "</loc>
        <lastmod>" . date('c') . "</lastmod>
        <changefreq>{$changeFreq['topics']}</changefreq>
        <priority>{$priority['topics']}</priority>
    </url>\n";
    }

    // Pages
    foreach ($pages as $page) {
        $sm .= "
    <url>
        <loc>" . site_url($page['s_slug'] . '/' . $page['slug']) . "</loc>
        <lastmod>" . date('c', strtotime($page['created'])) . "</lastmod>
        <changefreq>{$changeFreq['pages']}</changefreq>
        <priority>{$priority['pages']}</priority>
    </url>\n";
    }

    // Posts
    foreach ($posts as $post) {
        $sm .= "
    <url>
        <loc>" . site_url('post/' . $post['id']) . "</loc>
        <lastmod>" . date('c', strtotime($post['created'])) . "</lastmod>
        <changefreq>{$changeFreq['posts']}</changefreq>
        <priority>{$priority['posts']}</priority>
    </url>\n";
    }

    $sm .= '</urlset>';

    // Write plain XML
    fwrite($sitemapFile, $sm);
    fclose($sitemapFile);

    // Also create gzipped version
    $gzippedContent = gzencode($sm, 9); // Max compression
    file_put_contents(ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'sitemap.xml.gz', $gzippedContent);
}

/**
 * Fetches data for posts, pages, or topics for the sitemap.
 *
 * @param string $type 'posts', 'pages', or 'topics'
 * @return array
 */
private function getSitemapData(string $type): array {
    switch ($type) {
        case 'posts':
            return $this->db->table('posts p')
                            ->select('p.id, p.created')
                            ->where('p.status', 1)
                            ->where('p.accessibility', 0)
                            ->orderBy('p.created', 'DESC')
                            ->get()
                            ->getResultArray();

        case 'pages':
            return $this->db->table('pages p')
                            ->select('p.id, p.slug, p.created, s.slug AS s_slug')
                            ->join('sections s', 's.id = p.section_id', 'inner')
                            ->where('p.status', 1)
                            ->orderBy('p.created', 'DESC')
                            ->get()
                            ->getResultArray();

        case 'topics':
            return $this->db->table('topics t')
                            ->select('t.slug')
                            ->selectCount('p.topic_id', 'count')
                            ->join('posts p', 'p.topic_id = t.id', 'left')
                            ->where('p.status', 1)
                            ->groupBy('t.id')
                            ->having('count >', 0)
                            ->get()
                            ->getResultArray();

        default:
            return [];
    }
}

/**
 * Builds a structured form schema based on the columns of a given database table.
 *
 * Retrieves column metadata from MySQL's `INFORMATION_SCHEMA` and enhances each column
 * with metadata used to generate dynamic form controls. Optionally filters out ignored fields
 * and classifies certain columns as dropdowns, file uploads, or hidden fields.
 *
 * Enhancements per column include:
 * - `type`: SQL base type (e.g., varchar, int, text)
 * - `length`: Field length (if applicable)
 * - `input_type`: HTML input type (e.g., text, textarea, file)
 * - `label`: Human-friendly label generated from the column name
 *
 * @param string $table      The name of the database table. Defaults to 'blocks'.
 * @param array  $ignore     Columns to ignore (merged with defaults like 'created', 'updated').
 * @param array  $dropdowns  Columns to render as `<select>` elements.
 * @param array  $uploads    Columns to render as file inputs.
 * @param array  $hidden     Columns to render as hidden inputs.
 *
 * @return array {
 *     table: string,         // The name of the source table
 *     fields: array[]        // Array of normalized column definitions
 * }
 */
 public function formBuilder(
    string $table = '',
    array $ignore = [],
    array $dropdowns = [
        // 'block_group_id'=> ['block_groups', 'title']
    ],
    array $uploads = [
        // 'image'      => 'public/upload1',
        // 'background' => 'writable/upload2'
    ],
    array $hidden = ['id']
): array {
    $defaultIgnoredColumns = ['created', 'updated'];
    $ignore = array_unique(array_merge($defaultIgnoredColumns, $ignore));

    $builder = $this->db->table('INFORMATION_SCHEMA.COLUMNS')
                        ->select([
                            'COLUMN_NAME AS name',
                            'COLUMN_TYPE AS sqlType',
                            'COLUMN_COMMENT AS comment'
                        ])
                        ->where('TABLE_SCHEMA', $this->db->getDatabase())
                        ->where('TABLE_NAME', $table);

    if (!empty($ignore)) {
        $builder->whereNotIn('COLUMN_NAME', $ignore);
    }

    $structure = $builder
        ->orderBy('ORDINAL_POSITION')
        ->get()
        ->getResultArray();

    foreach ($structure as &$column) {
        $column = $this->normalizeColumn($column, $dropdowns, $uploads, $hidden);
    }

    return [
        'table'  => $table,
        'fields' => $structure
    ];

}

/**
 * Normalizes a column definition with form-specific metadata.
 *
 * Parses the SQL type and determines the appropriate HTML input type.
 * Generates a human-friendly label and returns the enriched column structure.
 *
 * @param array $column    The raw column array with `name` and `sqlType`.
 * @param array $dropdowns List of column names to render as `<select>`.
 * @param array $uploads   List of column names to render as file inputs.
 * @param array $hidden    List of column names to render as hidden inputs.
 *
 * @return array The normalized column with keys:
 *               - name (string)
 *               - sqlType (string)
 *               - type (string)
 *               - length (int|null)
 *               - input_type (string)
 *               - label (string)
 */
private function normalizeColumn(
    array $column,
    array $dropdowns,
    array $uploads,
    array $hidden): array {
    // Parse SQL type and length
    if (preg_match('/^([a-zA-Z]+)(?:\((\d+)\))?/', $column['sqlType'], $matches)) {
        $column['type']   = strtolower($matches[1]);
        $column['length'] = $matches[2] ?? null;
    } else {
        $column['type']   = strtolower($column['sqlType']);
        $column['length'] = null;
    }

    // Determine input type
    if (array_key_exists($column['name'], $uploads)) {
        $column['input_type'] = 'file';
        $column['dest'] = $uploads[$column['name']]; // Assign destination path
    } elseif (array_key_exists($column['name'], $dropdowns)) {
        $column['input_type'] = 'select';
        //$column['source'] = json_encode(array_values($dropdowns)); // Assign Dropdown source
        $column['source'] = json_encode($dropdowns[$column['name']]);

    } elseif (in_array($column['name'], $hidden)) {
        $column['input_type'] = 'hidden';
    } else {
        $column['input_type'] = match ($column['type']) {
            'datetime', 'timestamp'                => 'datetime-local',
            'date'                                 => 'date',
            'time'                                 => 'time',
            'int', 'bigint', 'tinyint', 'smallint' => 'number',
            'text', 'mediumtext', 'longtext'       => 'textarea',
            default                                => 'text',
        };
    }

    // Generate a human-readable label from column name
    $cleanName = preg_replace('/_?id$/i', '', $column['name']); // remove _id or id at end
    $column['label'] = ucwords(str_replace('_', ' ', $cleanName)); // convert to label

    return $column;
}

/**
 * Handles the upload of a single file to a specified destination path.
 *
 * This method validates the uploaded file, resolves the destination path
 * based on a prefix (`public/` or `writable/`), ensures the target directory exists,
 * and moves the file using a random filename.
 *
 * The destination string should be in the format:
 * - `public/uploads/posts`
 * - `writable/user/images`
 *
 * @param UploadedFile|null $file The uploaded file instance from CodeIgniter's request.
 * @param string            $dest The destination string, prefixed with "public/" or "writable/".
 *
 * @return array{
 *     success: bool,
 *     filename?: string,
 *     error?: string
 * } The result of the upload operation. Includes filename on success or error message on failure.
 */
public function formBuilderUpload(?\CodeIgniter\HTTP\Files\UploadedFile $file, string $dest): array {
    if (!$file || !$file->isValid() || $file->hasMoved()) {
        return [
            'success' => false,
            'error'   => 'Invalid or missing file.'
        ];
    }

    $prefixes = [
        'public'   => FCPATH,
        'writable' => WRITEPATH,
    ];

    $parts = explode('/', trim($dest, '/'));
    $base  = array_shift($parts);

    if (!isset($prefixes[$base])) {
        return [
            'success' => false,
            'error'   => 'Invalid destination prefix. Use public/ or writable/.'
        ];
    }

    $basePath     = $prefixes[$base];
    $relativePath = implode(DIRECTORY_SEPARATOR, $parts);
    $fullPath     = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $relativePath;

    if (!is_dir($fullPath)) {
        return [
            'success' => false,
            'error'   => 'Upload folder does not exist: ' . $fullPath
        ];
    }

    $mimeType = $file->getMimeType();
    $newName  = $file->getRandomName();
    $file->move($fullPath, $newName);

    // Check if it's an image and generate thumbnail
    if (str_starts_with($mimeType, 'image/')) {
        helper('image');
        $source      = $fullPath . DIRECTORY_SEPARATOR . $newName;
        $thumbDir    = $fullPath . DIRECTORY_SEPARATOR . 'tn';
        $thumbName   = pathinfo($newName, PATHINFO_FILENAME) . '.webp';
        $thumbPath   = $thumbDir . DIRECTORY_SEPARATOR . $thumbName;

        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0755, true);
        }

        $thumbResult = $this->createThumbnail($source, $thumbPath);
        if ($thumbResult !== true) {
            return [
                'success' => false,
                'error'   => 'Thumbnail error: ' . $thumbResult
            ];
        }
    }

    return [
        'success'  => true,
        'filename' => $newName
    ];
}

/**
 * Creates a 1024x1024 center-cropped WebP thumbnail from a source image using GD.
 *
 * Supported formats: JPEG, PNG, GIF, WEBP, BMP.
 * If the source is a JPEG, EXIF orientation is respected.
 *
 * @param string $source      Path to the source image file.
 * @param string $destination Path to save the generated WebP thumbnail.
 *
 * @return bool|string        Returns true on success, or a string error message on failure.
 */
private function createThumbnail(string $source, string $destination): bool|string {
    try {
        // Ensure destination folder exists and is writable
        $destDir = dirname($destination);
        if (!is_dir($destDir) || !is_writable($destDir)) {
            return "Thumbnail directory not writable: $destDir";
        }

        // Determine image type
        $mime = mime_content_type($source);
        switch ($mime) {
            case 'image/jpeg': $img = imagecreatefromjpeg($source); break;
            case 'image/png':  $img = imagecreatefrompng($source);  break;
            case 'image/gif':  $img = imagecreatefromgif($source);  break;
            case 'image/webp': $img = imagecreatefromwebp($source); break;
            case 'image/bmp':  $img = imagecreatefromwbmp($source); break;
            default: return "Unsupported image type: $mime";
        }

        // Apply EXIF rotation if JPEG
        if ($mime === 'image/jpeg' && function_exists('exif_read_data')) {
            $exif = @exif_read_data($source);
            if (!empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3: $img = imagerotate($img, 180, 0); break;
                    case 6: $img = imagerotate($img, 270, 0); break;
                    case 8: $img = imagerotate($img, 90, 0);  break;
                }
            }
        }

        $srcW = imagesx($img);
        $srcH = imagesy($img);
        $targetW = 512;
        $targetH = 512;

        // Calculate crop size to center-fit
        $srcRatio = $srcW / $srcH;
        $dstRatio = $targetW / $targetH;

        if ($srcRatio > $dstRatio) {
            // Source is wider — crop sides
            $newH = $srcH;
            $newW = (int)($srcH * $dstRatio);
            $srcX = (int)(($srcW - $newW) / 2);
            $srcY = 0;
        } else {
            // Source is taller — crop top/bottom
            $newW = $srcW;
            $newH = (int)($srcW / $dstRatio);
            $srcX = 0;
            $srcY = (int)(($srcH - $newH) / 2);
        }

        // Create destination image
        $thumb = imagecreatetruecolor($targetW, $targetH);
        imagecopyresampled($thumb, $img, 0, 0, $srcX, $srcY, $targetW, $targetH, $newW, $newH);

        // Save to WebP
        $result = imagewebp($thumb, $destination, 65);

        // Clean up
        imagedestroy($img);
        imagedestroy($thumb);

        if (!$result || !is_file($destination)) {
            return "Thumbnail not saved to: $destination";
        }

        return true;
    } catch (\Throwable $e) {
        log_message('error', 'Thumbnail creation error: ' . $e->getMessage());
        return $e->getMessage();
    }
}

/**
 * Saves (insert or update) a single database row by table and ID.
 *
 * If the ID is -1, a new row is inserted. Otherwise, it updates the existing row.
 *
 * @param string $table The database table name.
 * @param int    $id    The ID of the row to update. Use -1 to insert a new row.
 * @param array  $data  The data to insert or update.
 *
 * @return array Result with 'success' (bool), 'id' (int|null), and 'message' (string)
 */
public function ajaxSaveTableRowById(string $table, int $id, array $data): array {
    // Check if table exists
    if (!$this->db->tableExists($table)) {
        return [
            'success' => false,
            'message' => "Table '$table' does not exist."
        ];
    }

    // Remove ID from data if present
    unset($data['id']);

    if ($id === -1) {
        // Insert new row
        $inserted = $this->db->table($table)->insert($data);

        if (!$inserted) {
            return [
                'success' => false,
                'message' => 'Failed to insert new row.'
            ];
        }

        return [
            'success' => true,
            'id'      => $this->db->insertID(),
            'message' => 'Row inserted successfully.'
        ];
    } else {
        // Update existing row
        $updated = $this->db->table($table)->where('id', $id)->update($data);

        if (!$updated) {
            return [
                'success' => false,
                'message' => 'Failed to update row.'
            ];
        }

        return [
            'success' => true,
            'id'      => $id,
            'message' => 'Row updated successfully.'
        ];
    }
}

/**
 * Fetches a single database row from the specified table by ID.
 *
 * This method is intended to support AJAX-based dynamic forms.
 * It ensures the table exists and attempts to retrieve a single row
 * with the provided `id` from that table.
 *
 * Behavior:
 * - If the table does not exist, returns an error.
 * - If no row matches the ID, returns an error.
 * - If successful, returns a success flag and the row data.
 *
 * @param string     $table The name of the table to query.
 * @param int|string $id    The row ID to look up. May be string if passed from URL.
 *
 * @return array An array containing:
 *               - 'success' (bool)
 *               - 'data' (array|null) when successful
 *               - 'error' (string) when failed
 */
public function ajaxFetchTableRowById(string $table, $id): array {
    if (!$this->db->tableExists($table)) {
        return [
            'success' => false,
            'error'   => "Table '$table' does not exist."
        ];
    }

    $id = is_numeric($id) ? (int) $id : $id;

    $result = $this->db->table($table)->where('id', $id)->get()->getRowArray();

    if (!$result) {
        return [
            'success' => false,
            'error'   => "Row with ID $id not found in table '$table'."
        ];
    }

    return [
        'success' => true,
        'data'    => $result
    ];
}

/**
 * Fetches an array of rows with `id` and a specified column from the given table.
 *
 * Useful for generating select options or lookups.
 *
 * @param string $table  The database table name.
 * @param string $column The column to retrieve alongside `id`.
 * @return array Success response or error message.
 */
public function ajaxfetchTableColumnWithId(string $table, string $column): array {
    if (!$this->db->tableExists($table)) {
        return [
            'success' => false,
            'error'   => "Table '$table' does not exist."
        ];
    }

    $results = $this->db->table($table)
                        ->select(['id', $column])
                        ->orderBy($column, 'ASC')
                        ->get()
                        ->getResultArray();

    return [
        'success' => true,
        'data'    => $results
    ];
}

/**
 * Deletes a specific row from a table by ID.
 *
 * @param string $table  The name of the table.
 * @param string|int $id The ID of the row to delete.
 * @return array An array indicating success or failure.
 */
public function ajaxDeleteTableRowById(string $table, int $id): array {
    if (!$this->db->tableExists($table)) {
        return [
            'success' => false,
            'error'   => "Table '$table' does not exist."
        ];
    }

    // Attempt to delete the row
    $deleted = $this->db->table($table)->where('id', $id)->delete();

    if (!$deleted) {
        return [
            'success' => false,
            'error'   => "Failed to delete row with ID $id from table '$table'."
        ];
    }

    return [
        'success' => true,
        'message' => "Row with ID $id successfully deleted from table '$table'."
    ];
}

/**
 * Fetches the next available ID from a table based on direction.
 *
 * Behavior:
 * - If $direction is "asc", finds the next higher ID after $id.
 * - If $direction is "desc", finds the next lower ID before $id.
 * - If no ID is found (end of table), returns the current $id.
 *
 * @param string $table     The table name.
 * @param int    $id        The current ID.
 * @param string $direction 'asc' for next, 'desc' for previous.
 *
 * @return array ['success' => true, 'id' => int]
 */
public function ajaxFetchNextId(string $table, int $id, string $direction): array {
    if (!$this->db->tableExists($table)) {
        return [
            'success' => false,
            'error'   => "Table '$table' does not exist."
        ];
    }

    $builder = $this->db->table($table)->select('id');

    if (strtolower($direction) === 'asc') {
        $builder->where('id >', $id)
                ->orderBy('id', 'ASC');
    } else { // 'desc' or anything else treated as descending
        $builder->where('id <', $id)
                ->orderBy('id', 'DESC');
    }

    $nextRow = $builder->limit(1)->get()->getRowArray();

    return [
        'success' => true,
        'id'      => $nextRow['id'] ?? $id // If no next ID found, return the current
    ];
}

/**
 * Retrieves a sorted list of entries from the given table.
 *
 * Selects the 'id', 'position', and a specified column, ordering the results by 'position' ascending.
 * Logs an error if the specified table does not exist.
 *
 * @param string $table  The name of the database table to query. Defaults to 'pages'.
 * @param string $column The additional column to select along with 'id' and 'position'. Defaults to 'title'.
 *
 * @return array An array of result rows. Returns an empty array if the table does not exist.
 */
public function sortBuilder(
    string $table = 'pages',
    string $column = 'title'
): array {
    if (!$this->db->tableExists($table)) {
        log_message('error', "sortBuilder() error: Table '{$table}' does not exist.");
        return [];
    }

    $rows = $this->db->table($table)
                     ->select("id, position, {$column} AS title")
                     ->orderBy('position', 'ASC')
                     ->get()->getResultArray();

    return [
        'table' => $table,
        'rows'  => $rows
    ];
}

/**
 * Updates the sort order of a table using a batch update.
 *
 * @param string $table    The name of the database table to update.
 * @param array  $sortData An array of ['id' => int, 'position' => int] pairs.
 *
 * @return bool True on success, false if data is invalid or table missing.
 */
public function ajaxSortTable(string $table, array $sortData): bool {
    if (!$this->db->tableExists($table)) {
        log_message('error', "ajaxSortTable error: Table '{$table}' does not exist.");
        return false;
    }

    if (empty($sortData)) {
        log_message('error', "ajaxSortTable error: Empty sort data.");
        return false;
    }

    $updateData = [];

    foreach ($sortData as $item) {
        if (!isset($item['id'], $item['position'])) {
            continue; // Skip invalid entries
        }

        $updateData[] = [
            'id'       => (int) $item['id'],
            'position' => (int) $item['position']
        ];
    }

    if (!empty($updateData)) {
        $this->db->table($table)->updateBatch($updateData, 'id');
        return true;
    }

    return false;
}

/**
 * Performs an AJAX full-text search on posts using BOOLEAN MODE.
 *
 * @param string $term  Search keyword(s).
 * @param int    $limit Maximum number of results to return (default 10).
 *
 * @return array|null List of matched posts with metadata, or null if none found.
 */
public function ajaxSearch(string $term, int $limit = 10): ?array {
    $escapedTerm = $this->db->escape($term);

    return $this->db->table('posts p')
                    ->join('users u', 'u.id = p.user_id')
                    ->join('topics t', 't.id = p.topic_id')
                    ->select('p.id, p.title')
                    ->select('DATE_FORMAT(p.created, "%b %d, %Y") AS f_created', false)
                    ->select('CONCAT(u.first_name, " ", u.last_name) AS author', false)
                    ->select('u.author AS author_handle')
                    ->select('t.title AS topic, t.slug AS topic_slug')
                    ->select("MATCH(p.title, p.subtitle, p.body) AGAINST($escapedTerm IN BOOLEAN MODE) AS relevance")
                    ->where('p.status', 1)
                    ->where('p.accessibility', 0)
                    ->where("MATCH(p.title, p.subtitle, p.body) AGAINST($escapedTerm IN BOOLEAN MODE)", null, false)
                    ->orderBy('relevance', 'DESC')
                    ->limit($limit)
                    ->get()
                    ->getResultArray();
}


} // ─── End of Class ───