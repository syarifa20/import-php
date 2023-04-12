<?php
require_once('class.php');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_POST['submit'])){
    // Cek apakah file berhasil diupload
    if($_FILES['file']['error'] == 0){
        // Baca file Excel menggunakan PhpSpreadsheet
        $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Import data ke database
        $class = new DataImport();
        $header = true;
        foreach($rows as $row){
            if($header){
                $header = false;
            } else {
                $class->insert_data($row);
            }
        }
        echo "Data berhasil diimpor";
    } else {
        echo "File gagal diupload";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" name="submit" value="Upload">
    </form>
</body>
</html>
