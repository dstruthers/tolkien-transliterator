<?php
function en_to_tengwar_orthographic ($src) {
  $consonantMap = array('CH' => '\ue002',
                        'GH' => '\ue00f',
                        'NG' => '\ue013',
                        'PH' => '\ue019',
                        'QU' => '\ue003\ue015',
                        'SH' => '\ue00a',
                        'TH' => '\ue008',
                        'WH' => '\ue029',
                        'B'  => '\ue005',
                        'C'  => '\ue003',
                        'D'  => '\ue004',
                        'F'  => '\ue009',
                        'G'  => '\ue007',
                        'H'  => '\ue028',
                        'J'  => '\ue006',
                        'K'  => '\ue003',
                        'L'  => '\ue022',
                        'M'  => '\ue011',
                        'N'  => '\ue010',
                        'P'  => '\ue001',
                        'Q'  => '\ue003',
                        'R'  => '', // R rule
                        'S'  => '', // S rule
                        'T'  => '\ue000',
                        'V'  => '\ue00d',
                        'W'  => '\ue015',
                        'X'  => '\ue003\ue059',
                        'Y'  => '\ue016',
                        'Z'  => '\ue026'
                        );
  $vowelMap = array('A' => '\ue040',
                    'E' => '\ue046',
                    'I' => '\ue044',
                    'O' => '\ue04a',
                    'U' => '\ue04c'
                    );
  
  $words = preg_split('/\b/', strtoupper($src));
  $output = '';

  for ($i = 0; $i < count($words); $i++) {
    $word = $words[$i];

    switch ($word) {
    case 'THE':
      $output[] = '\ue01c';
      break;

    case 'OF':
      if ($i < count($words) - 1 && $words[$i + 2] == 'THE') {
        $output[] = '\ue01d\ue051';
        $output[] = $words[$i + 1];
        $i += 2;
      }
      else {
        $output[] = '\ue01d';
      }
      break;

    default:
      $tengwar = '';
      $lastTengwa = '';
      $lastTehtar = '';
      $nextTehtar = '';
      $parsed = '';
      while ($word) {
        $preParseWord = $word;
        if (preg_match('/^([AEIOU]+)/', $word, $matches)) {
          $vowels = $matches[1];
          $parsed .= $vowels;
          $word = substr($word, strlen($vowels));
          do {
            $vowel = $vowels{0};
            $vowels = substr($vowels, 1);

            if ($vowels && $vowels{0} == $vowel) {
              $tengwar .= '\ue02c' . $vowelMap[$vowel];
              $lastTengwa = '\ue02c';
              $vowels = substr($vowels, 1);
            }
            else {
              if ($tengwar && ($vowels || !$word)) {
                if ($vowel == 'E' && !$word) {
                  $tengwar .= '\ue045';
                }
                else {
                  $tengwar .= '\ue02e' . $vowelMap[$vowel];
                  $lastTengwa = '\ue02e';
                }
              }
              elseif (!$tengwar && !$word) {
                $tengwar .= '\ue02e' . $vowelMap[$vowel];
                $lastTengwa = '\ue02e';
              }
              else {
                $tehtar .= $vowelMap[$vowel];
              }
            }
          } while($vowels);
        }
        else {
          foreach ($consonantMap as $graph => $tengwa) {
            if (preg_match("/^$graph/", $word)) {
              $parsed .= $graph;
              $word = substr($word, strlen($graph));

              if ($graph == 'M' || $graph == 'N') {
                if ($word && !preg_match('/^[AEIOU]/', $word)) {
                  if (!preg_match("/^$graph/", $word)) {
                    $nextTehtar .= '\ue050';
                    break;
                  }
                }
              }
              if ($graph == 'QU') {
                $tengwa = '\ue003';
                $nextTengwa = '\ue015';
              }
              if ($graph == 'R') {
                if ($word{0} == 'R') {
                  $tehtar .= '\ue051';
                  $parsed .= substr($word, 0, 1);
                  $word = substr($word, 1);
                }
                if (preg_match('/^[AEIOU]/', $word)) {
                  $tengwa = '\ue020';
                }
                else {
                  $tengwa = '\ue014';
                }
              }
              elseif ($graph == 'S') {
                if ($word || (!$word && !$tengwar)) {
                  if ($lastTengwa == '\ue024' || $lastTengwa == '\ue025') {
                    $tehtar .= '\ue051';
                  }
                  else {
                    if ($tehtar) {
                      $tengwa = '\ue025';
                    }
                    else {
                      $tengwa = '\ue024';
                    }
                  }
                }
                else {
                  if ($tehtar) {
                    $tengwa = '\ue025';
                  }
                  else {
                    if ($lastTengwa == '\ue024' || $lastTengwa == '\ue025') {
                      $tehtar .= '\ue051';
                    }
                    else {
                      $tehtar .= '\ue058';
                    }
                  }
                }
              }
              elseif ($graph == 'Z') {
                if ($tehtar) {
                  $tengwa = '\ue027';
                }
              }
              if ($tengwa == $lastTengwa && !preg_match('/[AEIOU].$/', $parsed)) {
                $tehtar .= '\ue051';
                $tengwa = '';
              }
              $tengwar .= $tengwa . $nextTehtar . $tehtar . $nextTengwa;
              if ($tengwa) {
                $lastTengwa = $tengwa;
              }
              $lastTehtar = $nextTehtar . $tehtar;
              $tengwa = '';
              $tehtar = '';
              $nextTehtar = '';
              $nextTengwa = '';
              break;
            }
          }
        }
        if ($word == $preParseWord) {
          $char = $word{0};
          if ($char != "\n") {
            $tengwar .= $char;
          }
          else {
            $tengwar .= '\n';
          }
          $word = substr($word, 1);
        }
      } // while
      $output[] = $tengwar;
    } // switch
  } // for 
  //return implode(' ', $output);
  return json_decode('"' . implode('', $output) . '"');
} // function
Transliteration::registerTransliterator('en', 'tengwar_orthographic', 'en_to_tengwar_orthographic');
?>
