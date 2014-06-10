<?php

define('DICTFILE', 'lib/cmudict.0.7a');

class Pronunciation {
  public function __construct ($word) {
    if (!self::$dictionary) {
      self::$dictionary = preg_split('/[\n\r]+/', file_get_contents(DICTFILE));
    }
    $this->word = strtoupper($word);
    foreach (self::$dictionary as $line) {
      if (strpos($line, "$this->word  ") === 0) {
        $this->pronunciation = substr($line, strlen($this->word) + 2);
      }
    }
  }
  private static $dictionary = NULL;
  public $word;
  public $pronunciation;
}
?>