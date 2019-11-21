<?php

  require 'vendor/autoload.php';

  echo "<title>upload</title>";

  // function to handle file upload then display table from excel doc
  function upload($options) {

    $targetDir = "uploads/";

    // uses scandir to find most recent file BY FILENAME
    // files must be NAMED sequentially for this to work
    if ($options == "recent") {
      $files = scandir($targetDir, SCANDIR_SORT_DESCENDING);
      $targetFile = $targetDir . $files[0];
      displayTable($targetFile);
    }

  // uses uploaded file with relevant checks
  else if ($options == "upload") {

      //relative directory path to uploaded file
      $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

      $uploadOk = 1;
      $fileExtension = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

      // Check if file already exists
      if (file_exists($targetFile)) {
          echo "error: file already exists";
          $uploadOk = 0;
      }

      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
          echo "error: file is too large";
          $uploadOk = 0;
      }

      // Allow certain file formats
      if($fileExtension != "xlsx" && $fileExtension != "xls") {
          echo "error: only .xlsx and .xls files are allowed";
          $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          echo "<br>upload error";

      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
              echo "success: file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded";

              // rename file YYYYMMDD_HHMMSS
              $newFileName = "uploads/" . date("Ymd_His") . ".xlsx";
              rename($targetFile, $newFileName);

              displayTable($newFileName);

          } else {
              echo "there was an error uploading your file";
          }
      }
  }

}

// displays table based on FULL filepath
function displayTable($fileName) {

  // create reader from phpoffice and loads file from parameter
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
  $reader->setReadDataOnly(TRUE);
  $spreadsheet = $reader->load($fileName);
  $worksheet = $spreadsheet->getActiveSheet();

  // creates 1D array from excel doc
  $rows = $worksheet->toArray();

  // prints basic table with textareas
  echo "<table style='border:2px solid black'>";
  foreach ($rows as $array) {
    echo "<tr>";
    foreach ($array as $names) {
      echo "<th> <textarea required>$names</textarea> </th>";
    }
    echo "</tr>";
  }
  echo "</table>";

  // javascript for reading all textareas in document
  // should probably move this script to a separate file in the future
  echo "
  <button onclick='readTable()'>read table</button>
  <script>

    function readTable() {
      var x = document.getElementsByTagName('textarea');

      for (var i = 0; i < x.length; i++) {
          console.log(x[i].value);
      }

      for (var i = 2; i < x.length; i += 2) {
        console.log('INSERT INTO students (lastName, firstName) VALUES (' + x[i].value + ', ' + x[i+1].value + ');')
      }

    }

  </script>
  ";
}

  // call upload upon form submission
  // i know that using strings to change functionality in the function is probably
  // bad practice, but it seems like the easiest way right now

  if(isset($_POST['submit'])) {
    if($_POST['submit'] == "upload") {
      upload("upload");
    }
    if ($_POST['submit'] == "recent") {
      upload("recent");
    }
  }

?>
