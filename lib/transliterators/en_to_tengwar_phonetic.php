<?php
function en_to_tengwar_phonetic ($src) {
  require_once 'lib/pronounce.php';

  $map = array('AA' => '\ue04a',
               'AE' => '\ue040',
               'AH' => '\ue041',
               'AO' => '\ue04a',
               'AW' => '\ue015\ue040',
               'AY' => '\ue044',
               'B'  => '\ue005',
               'CH' => '\ue002',
               'D'  => '\ue004',
               'DH' => '\ue00c',
               'EH' => '\ue046',
               'ER' => '\ue045', // need special logic
               'EY' => '\ue040',
               'F'  => '\ue009',
               'G'  => '\ue007',
               'HH' => '\ue028',
               'IH' => '\ue044',
               'IY' => '\ue048',
               'JH' => '\ue006',
               'K'  => '\ue003',
               'L'  => '\ue022',
               'M'  => '\ue011',
               'N'  => '\ue010',
               'NG' => '\ue013',
               'OW' => '\ue04a\ue04a',
               'OY' => '\ue02a\ue04a',
               'P'  => '\ue001',
               'R'  => '\ue014',
               'S'  => '\ue024',
               'SH' => '\ue00a',
               'T'  => '\ue000',
               'TH' => '\ue008',
               'UH' => '\ue04c',
               'UW' => '\ue04c',
               'V'  => '\ue00d',
               'W'  => '\ue015',
               'Y'  => '\ue016',
               'Z'  => '\ue026',
               'ZH' => '\ue00e'
               );

  $words = preg_split('/\b/', strtoupper($src));
  $output = array();
  foreach ($words as $word) {
    if ($word == ' ') {
      $output[] = ' ';
    }
    elseif ($word == '.') {
      $output[] = '\ue060';
    }
    elseif ($word == ',') {
      $output[] = ','; // TODO: figure out how a comma works
    }
    else {
      $p = new Pronunciation($word);
      if (!$p->pronunciation) {
        $output[] = $word;
        continue;
      }
      $phonemes = explode(' ', $p->pronunciation);
      for ($i = 0; $i < count($phonemes); $i++) {
        if (preg_match('/^([A-Z]+)[0-9]+$/', $phonemes[$i], $matches)) {
          $phonemes[$i] = $matches[1];
        }
      }
      $o = '';
      $diacritic = '';
      for ($i = 0; $i < count($phonemes); $i++) {
        $nextIsVowel = $i < count($phonemes) - 1 && preg_match('/^[AEIOU]/', $phonemes[$i + 1]);
        if (preg_match('/^[AEIOU]/', $phonemes[$i])) {
          if ($phonemes[$i] == 'ER') {
            if ($i == count($phonemes) - 1 || !preg_match('/^[AEIOU]/', $phonemes[$i + 1])) {
              $o .= '\ue014\ue046';
            }
            else {
              $o .= '\ue020\ue046';
            }
          }
          elseif ($i == count($phonemes) - 1) {
            switch ($phonemes[$i]) {
            case 'AY':
              $o .= '\ue02c\ue044';
              break;
            case 'EY':
              $o .= '\ue02c\ue040';
              break;
            case 'IY':
              $o .= '\ue02c\ue046';
              break;
            case 'OW':
              $o .= '\ue02c\ue04a';
              break;
            case 'UW':
              $o .= '\ue02c\ue04c';
              break;
            default:
              $o .= '\ue02e' . $map[$phonemes[$i]];
              break;
            }
          }
          elseif (in_array($phonemes[$i], array('AW', 'OY'))) {
            $o .= $map[$phonemes[$i]];
          }
          else {
            $diacritic = $map[$phonemes[$i]];
          }
        }
        else {
          if ($phonemes[$i] == 'S') {
            if ($i == count($phonemes) - 1) {
              $tengwa = '';
              $diacritic .= '\ue058';
            }
            elseif ($diacritic && $diacritic != '\ue041') {
              $tengwa = '\ue025';
            }
            else {
              $tengwa = '\ue024';
            }
          }
          elseif ($phonemes[$i] == 'Z') {
            if ($diacritic) {
              $tengwa = '\ue027';
            }
            else {
              $tengwa = '\ue026';
            }
          }
          elseif ($phonemes[$i] == 'R') {
            if ($nextIsVowel) {
              $tengwa = '\ue020';
            }
            else {
              $tengwa = '\ue014';
            }
          }
          else {
            $tengwa = $map[$phonemes[$i]];
          }
          $o .= $tengwa;
          if ($diacritic) {
            $o .= $diacritic;
            $diacritic = '';
          }
        }
      }
      if (preg_match('/E$/', $word) && !preg_match('/^[AEIOU]/', $phonemes[count($phonemes) - 1])) {
        $o .= '\ue045';
      }
      $output[] = $o;
    }
  }
  return json_decode('"' . implode('', $output) . '"');
}

Transliteration::registerTransliterator('en', 'tengwar_phonetic', 'en_to_tengwar_phonetic');
?>
