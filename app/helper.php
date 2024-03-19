<?php

// define('TO_EMAIL', 'info@innayatcro.com');
// define('TO_NAME', 'Innayat CRO');
// define('CC_EMAIL', 'studytutelage@gmail.com');
// define('CC_NAME', 'Team tutelage Study');

define('TO_EMAIL', 'farazahmad280@gmail.com');
define('TO_NAME', 'Mohd Faraz');
define('CC_EMAIL', '4hm3df4r42@gmail.com');
define('CC_NAME', 'LV Overseas');

define('BCC_EMAIL', 'farazahmad280@gmail.com');
define('BCC_NAME', 'Mohd Faraz');


if (!function_exists('printArray')) {
  function printArray($data)
  {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
  }
}
if (!function_exists('getFormattedDate')) {
  function getFormattedDate($date, $formate)
  {
    return date($formate, strtotime($date));
  }
}
if (!function_exists('slugify')) {
  function slugify($text)
  {
    // Swap out Non "Letters" with a -
    $text = preg_replace('/[^\\pL\d]+/u', '-', $text);
    // Trim out extra -'s
    $text = trim($text, '-');
    // Convert letters that we have left to the closest ASCII representation
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Make text lowercase
    $text = strtolower($text);
    // Strip out anything we haven't been able to convert
    $text = preg_replace('/[^-\w]+/', '', $text);
    return $text;
  }
}
if (!function_exists('dateDiff')) {
  function dateDiff($date1, $date2)
  {
    $date1_ts = strtotime($date1);
    $date2_ts = strtotime($date2);
    return $days_between = ceil(abs($date2_ts - $date1_ts) / 86400);
  }
}
if (!function_exists('aurl')) {
  function aurl($path = null)
  {
    $path = strtolower($path);
    if ($path != '') {
      return url('/admin/' . $path);
    } else {
      return url('/admin/');
    }
  }
}
if (!function_exists('uurl')) {
  function uurl($path = null)
  {
    $path = strtolower($path);
    if ($path != '') {
      return url('/user/' . $path);
    } else {
      return url('/user/');
    }
  }
}
if (!function_exists('j2s')) {
  function j2s($data)
  {
    if ($data != null) {
      $arr = json_decode($data);
      $output = implode(', ', $arr);
    } else {
      $output = 'N/A';
    }
    return $output;
  }
}
if (!function_exists('replaceTag')) {
  function replaceTag($string, $array)
  {
    foreach ($array as $key => $value) {
      $string = $string == null ? null : str_replace('%' . $key . '%', $value, $string);
    }
    $string = trim(preg_replace('/\s+/', ' ', $string));
    $string = ucwords($string);
    return $string;
  }
}
if (!function_exists('universityLogo')) {
  function universityLogo($path = null)
  {
    if ($path != '') {
      return asset($path);
    } else {
      return asset('default/university-logo.png');
    }
  }
}
if (!function_exists('universityBanner')) {
  function universityBanner($path = null)
  {
    if ($path != '') {
      return asset($path);
    } else {
      return asset('default/university-banner.jpeg');
    }
  }
}
if (!function_exists('getPerc')) {
  function getPerc($mult, $div)
  {
    return $result = ($mult * 100) / $div;
  }
}
if (!function_exists('userIcon')) {
  function userIcon($path = null)
  {
    if ($path != null || $path != '') {
      return asset($path);
    } else {
      return asset('default/user-icon.jpg');
    }
  }
}
if (!function_exists('json_to_string')) {
  function json_to_string($value)
  {
    $output = $value != null ? json_decode($value) : '';
    $output = $output != null ? implode(', ', $output) : '';
    return $output;
  }
}
if (!function_exists('json_to_list')) {
  function json_to_list($value)
  {
    if ($value != null) {
      $arr = json_decode($value);
      $output = '<ul>';
      foreach ($arr as $item) {
        $output .= "<li>$item</li>";
      }
      $output .= '</ul>';
    } else {
      $output = 'N/A';
    }
    return $output;
  }
}
