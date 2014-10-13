<?php
function tengwar_to_latin_common ($src) {
  if (preg_match('/\"(.*)\"/', json_encode($src), $matches)) {
    $src = $matches[1];
  }

  $tengwaMap = array('%uE000' => 't',
                     '%uE001' => 'p',
                     '%uE002' => 'ch',
                     '%uE003%uE059' => 'x',
                     '%uE003' => 'k',
                     '%uE004' => 'd',
                     '%uE005' => 'b',
                     '%uE006' => 'j',
                     '%uE007' => 'g',
                     '%uE008' => 'th',
                     '%uE009' => 'f',
                     '%uE00C' => 'sh',
                     '%uE00B' => 'ch',
                     '%uE00C' => 'th',
                     '%uE00D' => 'v',
                     '%uE00E' => 'zh',
                     '%uE00F' => 'gh',
                     '%uE010' => 'n',
                     '%uE011' => 'm',
                     '%uE012' => 'ny',
                     '%uE013' => 'ng',
                     '%uE014' => 'r',
                     '%uE015' => 'w',
                     '%uE016' => 'y',
                     '%uE017' => 'qu',
                     // not used: '\ue018' => '',
                     '%uE019' => 'ph',
                     // not used: '\ue01a' => '',
                     // not used: '\ue01b' => '',
                     '%uE01C' => 'the',
                     '%uE01D%uE051' => 'of the',
                     '%uE01D' => 'of',
                     // not used: '\ue01e' => '',
                     '%uE01F' => 'gh',
                     '%uE020' => 'r',
                     '%uE021' => 'rd',
                     '%uE022' => 'l',
                     '%uE023' => 'ld',
                     '%uE024' => 's',
                     '%uE025' => 's',
                     '%uE026' => 'z',
                     '%uE027' => 'z',
                     '%uE028' => 'h',
                     '%uE029' => 'wh',
                     '%uE030' => 'y',
                     '%uE031' => 'w',
                     '%uE032' => 's',
                     '%uE070' => '0',
                     '%uE071' => '1',
                     '%uE072' => '2',
                     '%uE073' => '3',
                     '%uE074' => '4',
                     '%uE075' => '5',
                     '%uE076' => '6',
                     '%uE077' => '7',
                     '%uE078' => '8',
                     '%uE079' => '9',
                     '%uE07A' => 'A',
                     '%uE07B' => 'B'
                     );
  $precedingTehtaMap = array('%uE040' => 'a',
                             '%uE044' => 'i',
                             '%uE046' => 'e',
                             '%uE048' => 'ee',
                             '%uE04A' => 'o',
                             '%uE04C' => 'u',
                             '%uE04E' => 'oo',
                             '%uE04F' => 'uu',
                             //'%uE050' => 'n',
                             '%uE053' => 'y');
  $followingTehtaMap = array('%uE041' => 'a',
                             '%uE045' => 'e',
                             '%uE058' => 's');

  $output = array();
  while ($src) {
    $precedingNasal = FALSE;
    $vowelCarrier = FALSE;
    $doubleVowel = FALSE;
    $parsed = FALSE;

    // special cases
    if (strpos($src, '%uE02C') === 0) {
      $vowelCarrier = TRUE;
      $doubleVowel = TRUE;
      $src = substr($src, 6);
    }
    elseif (strpos($src, '%uE02E') === 0) {
      $vowelCarrier = TRUE;
      $src = substr($src, 6);
    }
    elseif (strpos($src, '%uE050') === 0) {
      $precedingNasal = TRUE;
      $src = substr($src, 6);
    }
    elseif (strpos($src, '%uE051') === 0) {
      $last = $output[count($output) - 1];
      $output[] = $last;
      $src = substr($src, 6);
    }

    foreach ($tengwaMap as $tengwa => $char) {
      if (strpos($src, addslashes($tengwa)) === 0) {
        $src = substr($src, strlen($tengwa));
        if ($precedingNasal) {
          $output[] = 'n';
        }
        $output[] = $char;
        $parsed = TRUE;
        break;
      }
    }
    if ($parsed) {
      continue;
    }

    $parsed = FALSE;
    foreach ($precedingTehtaMap as $tehta => $char) {
      //if (preg_match("/^$tehta/", $src)) {
      if (strpos($src, addslashes($tehta)) === 0) {
        $src = substr($src, strlen($tehta));
        if ($vowelCarrier) {
          $output[] = $char;
          if ($doubleVowel) {
            $output[] = $char;
          }
        }
        else {
          $last = array_pop($output);
          $output[] = $char;
          if ($precedingNasal) {
            $output[] = 'n';
          }
          $output[] = $last;
        }
        $parsed = TRUE;
        break;
      }
    }
    if ($parsed) {
      continue;
    }

    $parsed = FALSE;
    foreach ($followingTehtaMap as $tehta => $char) {
      //if (preg_match("/^$tehta/", $src)) {
      if (strpos($src, addslashes($tehta)) === 0) {
        $src = substr($src, strlen($tehta));
        $output[] = $char;
        $parsed = TRUE;
        break;
      }
    }

    if (!$parsed) {
      $output[] = $src{0};
      $src = substr($src, 1);
    }
  }
  return implode('', $output);
}
Transliteration::registerTransliterator('tengwar', 'latin_common', 'tengwar_to_latin_common');
?>
