<?php
header('Content-type: text/xml; charset=UTF-8');
require_once 'lib/transliteration.php';

$sourceLang = $_GET['source-lang'];
$source = $_GET['source'];
$resultLang = $_GET['result-lang'];

$t = new Transliteration($source, $sourceLang, $resultLang);
$r = $t->result;

?>
<trans>
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