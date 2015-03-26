<?php

if (!function_exists('route_where'))
{
  function route_where($name, $where = [], $absolute = true, $route = null)
  {
    $parameters = [];
    foreach ($where as $key => $value)
      $parameters[] = sprintf('%s:%s', $key, $value);


    $url = route($name, [], $absolute, $route);
    $url = sprintf('%s?where=%s', $url, implode(',', $parameters));

    return $url;
  }
}

if (!function_exists('decode_where'))
{
  function decode_where($where)
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