<?php
header('Content-type: text/xml; charset=UTF-8');
require_once 'lib/transliteration.php';

$sourceLang = $_GET['source-lang'];
$source = urldecode($_GET['source']);
$resultLang = $_GET['result-lang'];

$options = new TransliterationOptions();
if (isset($_GET['ws']) && $_GET['ws'] == '0') {
  $options->spaceChar = "\xE2\x80\x8B";
}
if (isset($_GET['nb'])) {
  $options->numeralBase = (int)$_GET['nb'];
}
if (isset($_GET['nd']) && in_array($_GET['nd'], array('ltr', 'rtl'))) {
  $options->numeralDir = $_GET['nd'];
}

$t = new Transliteration($source, $sourceLang, $resultLang, $options);
$r = $t->result;

?>
<trans>
  <time><?=time()?></time>
  <source>
    <lang><?=$sourceLang?></lang>
    <text><?=$source?></text>
  </source>

  <result>
    <success><?=$r->success ? '1' : '0'?></success>
    <message><?=$r->message?></message>
    <lang><?=$r->resultLang?></lang>
    <text><?=$r->result?></text>
  </result>
</trans>