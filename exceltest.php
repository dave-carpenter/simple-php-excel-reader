<?php

  //modified example from PhpSpreadsheet documentation
  //https://phpspreadsheet.readthedocs.io/en/latest/topics/accessing-cells/

  require 'vendor/autoload.php';

  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
  $reader->setReadDataOnly(TRUE);
  $spreadsheet = $reader->load("test.xlsx");

  $worksheet = $spreadsheet->getActiveSheet();

  $rows = $worksheet->toArray();

  echo "<table style='border:2px solid black'>";
  foreach ($rows as $array) {
    echo "<tr>";
    foreach ($array as $names) {
      echo "<th> $names </th>";
    }
    echo "</tr>";
  }
  echo "</table>";


?>
