<?php

namespace Drupal\liberty_general\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Hex Colors constraint.
 *
 * Verifies that the input hex value is valid.
 *
 * @Constraint(
 *   id = "ColorHex",
 *   label = @Translation("Hex color is formatted properly", context = "Validation")
 * )
 */
class ColorHex extends Constraint {
  /**
   * The violation message.
   *
   * @var string
   */
  public $badHex = "The color %hex isn't a valid value, which should be limited to numbers 0-9 and letters from A-F.";


  // Below is an example of adding options you can pass into a validator from your hook function.
  // You might want to include, for example, a range to validate against, or a list of correct values that may change
  // between the field's implementations on different content types.
  //
  // Can delete anything below this line if you don't want to pass in options, tho.
  // ---------------------------------------------------------

  /**
   * ColorHex constructor.
   *
   * Usage: $fields['field_example']->addConstraint('ColorHex', ['someOptions' => ['A','B','C']]);
   *
   * @param mixed $options
   */
  public function __construct($options = null)
  {
      if (null !== $options && !is_array($options)) {
          $options = array(
              'someOptions' => $options
          );
      }
      parent::__construct($options);

      /* To enforce required options:
      if (null === $this->options) {
          throw new MissingOptionsException(sprintf('The option "someOptions" must be given for constraint %s', __CLASS__), ['someOptions']);
      }
      */
  }

}