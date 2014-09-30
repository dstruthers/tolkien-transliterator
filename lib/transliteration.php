<?php
class Transliteration {
  public function __construct ($source, $sourceLang, $targetLang) {
    $result = new TransliterationResult();
    if (self::transliteratorExists($sourceLang, $targetLang)) {
      $t = self::transliteratorFor($sourceLang, $targetLang);
      $r = $t['function']($source);
      $result->source = $source;
      $result->sourceLang = $sourceLang;
      $result->result = $r;
      $result->resultLang = $targetLang;
      $result->success = TRUE;
    }
    else {
      $result->success = FALSE;
      $result->message = "No transliterator for $sourceLang to $targetLang";
    }
    $this->result = $result;
  }

  public static function registerTransliterator ($sourceLang, $targetLang, $function) {
    if (!self::transliteratorExists($sourceLang, $targetLang)) {
      self::$transliterators[] = array('sourceLang' => $sourceLang,
                                       'targetLang' => $targetLang,
                                       'function'   => $function
                                       );
    }
  }

  public static function transliteratorExists ($sourceLang, $targetLang) {
    foreach (self::$transliterators as $t) {
      if ($t['sourceLang'] == $sourceLang && $t['targetLang'] == $targetLang) {
        return TRUE;
      }
    }
    return FALSE;
  }

  public static function transliteratorFor ($sourceLang, $targetLang) {
    foreach (self::$transliterators as $t) {
      if ($t['sourceLang'] == $sourceLang && $t['targetLang'] == $targetLang) {
        return $t;
      }
    }
    return NULL; // TODO: raise exception
  }

  public $result;
  private static $transliterators = array();
}

class TransliterationResult {
  public $source;
  public $sourceLang;
  public $result;
  public $resultLang;
  public $success;
  public $message;
}

include_once 'transliterators/latin_to_tengwar_en_phonetic.php';
include_once 'transliterators/latin_to_tengwar_orthographic.php';
include_once 'transliterators/tengwar_to_latin_common.php';
?>
