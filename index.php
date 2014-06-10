<?php
require_once 'lib/tengwar.php';

header('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Tengwar Transliteration</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/transliterate.js"></script>
  </head>
  <body>
    <div id="banner">
      <h1>darrenstruthers.net</h1>: Digital Center for Middle-earth Linguistic Studies
    </div>
    <div id="content">
      <h3>Transliterate</h3>
      <div id="source">
        <select id="source-lang">
          <option value="en">English</option>
        </select>
        <p><textarea name="source_text"></textarea></p>
      </div>

      <div id="result">
        <select id="result-lang">
          <option value="tengwar_phonetic">Tengwar (Phonetic)</option>
        </select>
        <div id="text" class="tengwar">
        </div>
      </div>
    </div>
  </body>
</html>
