<?php

class TengwarCodec {
  public function __construct ($mode = 'en') {
    $this->mode = $mode;
    $this->map = self::map_en();
  }

  public function encode ($text) {
  }

  public function decode ($text) {
  }

  private static function map_en () {
    return array('ch' => '\ue002',
                 'dh' => '\ue00c',
                 'sh' => '\ue00a',
                 'th' => '\ue008',
                 'wh' => '\ue029',
                 'zh' => '\ue00e',
                 'a'  => '\ue040',
                 'b'  => '\ue005',
                 'd'  => '\ue004',
                 'e'  => '\ue046',
                 'f'  => '\ue009',
                 'g'  => '\ue00f',
                 'h'  => '\ue028',
                 'i'  => '\ue044',
                 'j'  => '\ue006',
                 'k'  => '\ue003',
                 'l'  => '\ue022',
                 'm'  => '\ue011',
                 'n'  => '\ue010',
                 'o'  => '\ue04a',
                 'p'  => '\ue001',
                 'r'  => '\ue014',
                 's'  => '\ue024',
                 't'  => '\ue000',
                 'u'  => '\ue04c',
                 'v'  => '\ue00d',
                 'w'  => '\ue015',
                 'y'  => '\ue035',
                 'z'  => '\ue026'
                 );
  }

  private static function encode_en ($text) {

  }

  private $mode;
}

?>
