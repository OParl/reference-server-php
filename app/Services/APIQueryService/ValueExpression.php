<?php namespace App\Services\APIQueryService;

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
          $this->value = substr($valueExpression, strlen($expression));

          return;
        }
      }
    }

    // default to "equal to"
    $this->expression = '=';
    $this->value      = $valueExpression;
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
}