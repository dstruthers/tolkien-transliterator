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
          <option value="latin">Latin Characters</option>
        </select>
        <p><textarea name="source_text"></textarea></p>
      </div>

      <div id="mid">
        <button id="swap-button" title="Swap Alphabets">&lt;-&gt;</button>
      </div>

      <div id="result">
        <select id="result-lang">
          <option value="tengwar_orthographic">Tengwar (Orthographic)</option>
          <option value="tengwar_en_phonetic">Tengwar (English Phonetic)</option>
        </select>
        <div id="text">
        </div>
      </div>
    </div>
    <div id="options">
      <fieldset>
        <legend>Options</legend>
        Tengwar Font:
        <select id="tengwar-font">
          <option value="tengwar-formal">Tengwar Formal</option>
          <option value="tengwar-mono">FreeMono Tengwar</option>
          <option value="tengwar-telcontar">Tengwar Telcontar</option>
        </select>
      </fieldset>
    </div>
  </body>
</html>
