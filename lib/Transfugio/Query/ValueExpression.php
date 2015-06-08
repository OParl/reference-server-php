<?php namespace EFrane\Transfugio\Query;

use Carbon\Carbon;

/**
 * Parse URL-compatible expressions
 *
 * @package App\Services\APIQueryService
 **/
class ValueExpression
{
  /**
   * The raw expression
   *
   * @var string
   **/
  protected $raw = '';

  /**
   * The expression's value
   *
   * @var string
   **/
  protected $value = '';

  /**
   * The parsed expression
   *
   * @var string
   **/
  protected $expression = '';

  protected static $validExpressions = [
    '=',  // equal to (may be omitted)
    '>',  // greater than
    '>=', // greater than or equal to
    '<',  // less than
    '<='  // less than or equal to
  ];

  public function __construct($valueExpression)
  {
    $this->raw = $valueExpression;

    $this->parseExpression($valueExpression);
  }

  /**
   * Split expressionValue into expression and type-checked value
   *
   * @param string $valueExpression
   **/
  protected function parseExpression($valueExpression)
  {
    // expressions are not longer than 2 characters
    $checkForExpression = substr($valueExpression, 0, 2);

    if (str_contains($checkForExpression, static::$validExpressions))
    {
      foreach (static::$validExpressions as $expression)
      {
        if (substr($valueExpression, 0, strlen($expression)) === $expression)
        {
          $this->expression = $expression;
          $this->value = $this->transformValue(substr($valueExpression, strlen($expression)));

          return;
        }
      }
    }

    // default to "equal to"
    $this->expression = '=';
    $this->value      = $this->transformValue($valueExpression);
  }

  /**
   * Get the expression's value
   *
   * @return string
   */
  public function getValue()
  {
    return $this->value;
  }

  /**
   * Get the parsed expression
   *
   * @return string
   */
  public function getExpression()
  {
    return $this->expression;
  }

  /**
   * Get the raw expression
   *
   * @return string
   */
  public function getRaw()
  {
    return $this->raw;
  }

  /**
   * Transform value into a recognized datatype:
   *
   * Processed datatypes:
   *
   * - string
   * - int
   * - float (including double)
   * - date (as Carbon instance)
   *
   * @param string $value
   * @return mixed
   **/
  protected function transformValue($value)
  {
    // first of all remove any quotation marks
    $value = preg_replace('/("|\')(.+)("|\')/', '$2', $value);

    $this->transformToDate($value);
    $this->transformToFloat($value);
    $this->transformToInt($value);

    return $value;
  }

  /**
   * @param $value
   **/
  protected function transformToDate(&$value)
  {
    // 1. try ISO 8601, this is the API default, thus it is the expected value
    try
    {
      /**
       * URL decoding leads to + being transformed into a white space.
       * This + however is important as it denotes the timezone of
       * the input string in ISO 8601.
       *
       * If thus, a whitespace is in a date string, it is assumed
       * that this is an URL decoding error and it will be replaced to a +.
       */
      $date = str_replace(' ', '+', $value, $count);
      $date = Carbon::createFromFormat(Carbon::ISO8601, $date);
    } catch (\Exception $e)
    {
      // 2. try any combination of Y(-|/)(m(-|/)(d))
      $separatorPattern = "(-|\/)?";
      $pattern = "/\d{4}({$separatorPattern}\d{2}({$separatorPattern}\d{2})?)?/";

      preg_match($pattern, $value, $matches);

      if (count($matches) > 0)
      {
        // TODO: create date from match
      }
    }

    if (isset($date) && $date instanceof Carbon)
      $value = $date;
  }

  /**
   * Transform value to floating point number if it matches \d+[.,]\d
   *
   * @param $value
   **/
  protected function transformToFloat(&$value)
  {
    // TODO: implement float transformation
  }

  /**
   * Transform a value into an integer if it only contains digits.
   *
   * @param string $value
   **/
  protected function transformToInt(&$value)
  {
    if (preg_match('/\d+/', $value) && !is_a($value, 'Carbon\Carbon'))
      $value = intval($value);
  }
}