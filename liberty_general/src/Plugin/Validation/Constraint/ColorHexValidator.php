<?php

namespace Drupal\liberty_general\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Checks if referenced entities are valid.
 */
class ColorHexValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($field, Constraint $constraint) {

    if($field->isEmpty()) {
      return;
    }

    $items = $field->getValue();

    // This field is a FieldItemList, so we iterate in case it's a multi-valued field.
    // We could use ->get() to just grab the first item, if this is a limit 1 field.
    // Could refactor this to be a bit shorter, or leave - it'll work fine as is too.
    foreach ($items as $item) {
      if (preg_match('/#([a-f0-9]{3}){1,2}$/i', $item['value']) !== 1) {
        $this->context->buildViolation($constraint->badHex, ['%hex' => $item['value']])
        ->atPath('field_color_he')
        ->addViolation();
      }
    }

  }

}