<?php
error_reporting(-1);
$source_code = file_get_contents("blenc_myscript.php");
// The encoded source passed to blenc_encrypt() cannot contain
// any php tags. We are removing php tags at the beginning and
// end of file. Also checking that there are no other php tag
// openings/closings.
$source_code = preg_replace('#^<'.'\?php\s+#', '', $source_code);
$source_code = preg_replace('#\s+\?>\s*$#', '', $source_code);
if (preg_match('#<'.'\?#', $source_code) 
        || preg_match('#\?>#', $source_code)) {
    print("Script to be encoded can only contain PHP code.");
    print(" Only a single php opening tag at the beginning of file");
    print(" and a single php closing tag at the end of file are allowed.");
    print(" This is a limitation as of BENC encoder 1.1.4b.");
    exit();
}
$redist_key = blenc_encrypt($source_code, "blenc_myscript_encoded.php");
$key_file = ini_get('blenc.key_file');
file_put_contents($key_file, $redist_key, FILE_APPEND);
print("DONE. See");
print(" <a href='blenc_myscript_encoded.php'>blenc_myscript_encoded.php</a>");
?>