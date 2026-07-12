<?php
/**
 * extract_hardcoded_strings.php
 *
 * Scans all Blade view files under resources/views for hard‑coded text strings
 * that are not wrapped in Laravel's translation helper __().
 * Generates a CSV file (hardcoded_strings.csv) with columns:
 *   file_path,line_number,original_text,generated_key
 * The generated key follows a simple snake_case convention based on the text.
 */

$viewPath = __DIR__ . '/../resources/views';
$outputCsv = __DIR__ . '/hardcoded_strings.csv';

$fh = fopen($outputCsv, 'w');
if (!$fh) {
    die('Unable to open CSV for writing');
}
// CSV header
fputcsv($fh, ['file_path', 'line_number', 'original_text', 'generated_key']);

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewPath));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $lines = file($file->getRealPath());
        foreach ($lines as $i => $line) {
            // Skip lines that already use __() or @lang
            if (preg_match('/__(\s*\(|\s*\[)/', $line) || preg_match('/@lang\s*\(/', $line)) {
                continue;
            }
            // Find plain text inside HTML tags or between Blade directives
            // Simple heuristic: look for >...< with letters
            if (preg_match_all('/>([^<]+)</', $line, $matches)) {
                foreach ($matches[1] as $text) {
                    $trim = trim($text);
                    if ($trim === '' || preg_match('/^\s*$/', $trim)) continue;
                    // Exclude Blade variables {{ ... }}
                    if (strpos($trim, '{{') !== false) continue;
                    // Generate a key: snake_case of first few words
                    $keyBase = strtolower(preg_replace('/[^A-Za-z0-9]+/', '_', $trim));
                    $key = substr($keyBase, 0, 30);
                    // Ensure key is not empty
                    if (empty($key)) continue;
                    fputcsv($fh, [
                        $file->getRealPath(),
                        $i + 1,
                        $trim,
                        $key
                    ]);
                }
            }
        }
    }
}

fclose($fh);

echo "Extraction complete. CSV written to $outputCsv\n";
?>
