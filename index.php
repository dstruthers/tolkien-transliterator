<?php
require_once 'lib/tengwar.php';

header('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Tengwar Transliteration</title>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="stylesheet" href="css/tengwar-keyboard.css" type="text/css"/>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery-ui-1.11.1.custom/jquery-ui.min.js"></script>
    <script src="js/tengwar-keyboard.js"></script>
    <script src="js/transliterate.js"></script>
  </head>
  <body>
    <div id="notice">
    </div>
    <div id="banner">
      <h1>darrenstruthers.net</h1>: Digital Center for Middle-earth Linguistic Studies
    </div>
    <div id="content">
      <h3>Tengwar Transliterator</h3>
      <div id="source">
        <select id="source-lang">
          <option value="latin">Latin Characters</option>
        </select>
        <div>
          <textarea name="source_text"></textarea>
        </div>
        <div id="input-options">
          <a href="#" id="toggle-tengwar-keyboard">Show Tengwar Keyboard</a>
          <div id="tengwar-keyboard"></div>
        </div>
      </div>

      <div id="mid">
        <button id="swap-button" title="Swap Alphabets">&lt;-&gt;</button>
      </div>

      <div id="result">
        <select id="result-lang">
          <option value="tengwar_orthographic">Tengwar (English Orthographic)</option>
          <option value="tengwar_en_phonetic">Tengwar (English Phonetic)</option>
        </select>
        <div id="text">
        </div>
      </div>
    </div>
    <div id="options">
      <div id="links">
        <h4>Useful Links</h4>
        <ul>
          <li><a href="http://www.starchamber.com/paracelsus/elvish/tengwar-textbook.pdf">Tengwar Textbook 4th Edition</a></li>
          <li><a href="http://freetengwar.sourceforge.net/">Free Tengwar Font Project</a></li>
        </ul>
      </div>

      <div class="option-group">
        <h4>Display Options</h4>
        <span class="option-label">Tengwar Font:</span>
        <select id="tengwar-font">
          <option value="tengwar-formal">Tengwar Formal</option>
          <option value="tengwar-mono">FreeMono Tengwar</option>
          <option value="tengwar-telcontar">Tengwar Telcontar</option>
        </select>
      </div>
      <div class="option-group">
        <h4>Tengwar Output</h4>
        <span class="option-label">Tengwar Word Spacing:</span>
        <select id="tengwar-word-spacing">
          <option value="1">Standard space</option>
          <option value="0">Zero-width space</option>
        </select>
      </div>
      <div class="option-group">
        <h4>Numeral Options</h4>
        <div>
          <span class="option-label">Tengwar Numeral Base:</span>
          <select id="tengwar-numeral-base">
            <option value="10">Decimal (10)</option>
            <option value="12" selected="selected">Duodecimal (12)</option>
          </select>
        </div>

        <div>
          <span class="option-label">Tengwar Numeral Direction:</span>
          <select id="tengwar-numeral-dir">
            <option value="ltr">Left to right</option>
            <option value="rtl" selected="selected">Right to left</option>
          </select>
        </div>
      </div>
    </div>
    <div id="footer">
      Copyright &copy; 2014 Darren M. Struthers - <a href="https://github.com/dstruthers/tolkien-transliterator">Check out the code on GitHub</a>
    </div>
  </body>
</html>
