<?php

if (!function_exists('encode_where'))
{
  function encode_where(array $where)
  {
    $parameters = [];
    foreach ($where as $key => $value)
      $parameters[] = sprintf('%s:%s', $key, $value);

    return implode(',', $parameters);
  }
}

if (!function_exists('decode_where'))
{
  function decode_where(array $where)
  {
    $where = explode(',', $where);
    $clauses = [];
    foreach ($where as $clause)
    {
      list($key, $value) = explode(':', $clause);
      $clauses[$key] = $value;
    }

    return $clauses;
  }
}

if (!function_exists('route_where'))
{
  function route_where($name, $where = [], $absolute = true, $route = null)
  {
    $where = encode_where($where);

    $url = route($name, [], $absolute, $route);
    $url = sprintf('%s?where=%s', $url, $where);

    return $url;
  }
}

if (!function_exists('class_method_exists'))
{
  function class_method_exists($className, $methodName)
  {
    $methods = get_class_methods($className);
    return in_array($methodName, $methods);
  }
}

if (!function_exists('array_filter_keys'))
{
  function array_filter_keys(array $array, \Closure $callback)
  {
    return array_flip(array_filter(array_flip($array), $callback));
  }
}

if (!function_exists('array_map_keys'))
{
  function array_map_keys(\Closure $callback, array $array)
  {
    return array_flip(array_map($callback, array_flip($array)));
  }
}

if (!function_exists('str_hashcode'))
{
  function str_hashcode($str)
  {
    $code = 0;
    $len  = mb_strlen($str);
    for ($i = 0; $i < $len; $i++)
    {
      $code += ord($str[$i]) * pow(31, $len - 1 - $i) % 2147483648;
    }

    return $code;
  }
}

if (!function_exists('hash_filename'))
{
  function hash_filename($filename)
  {
    $hashCode = str_hashcode($filename);

    $fb = sprintf('%02x', $hashCode & 0x000000FF);
    $sb = sprintf('%02x', ($hashCode << 2) & 0x000000FF);


    return str_replace('/', DIRECTORY_SEPARATOR, sprintf('%s/%s/%s', $fb, $sb, $filename));
  }
}
