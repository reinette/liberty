<?php

namespace Drupal\liberty_general\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * Validates the DateChecker constraints.
 */
class DateCheckerValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   *
   * You can add multiple named constraints here for an entity's fields. In each case the violation takes a parameterized
   * message (fields and messages defined in DateChecker.php) and the name of field where the constraint should be triggered. 
   */
  public function validate($entity, Constraint $constraint) {

    // You *could* have this run on any bundle, which might be desired whenever there is a start/end date-pair.
    if($entity->bundle() == 'offer') {

      // List of date field names to be compared.
      $dates = array(array('field_offer_start_date', 'field_offer_end_date'),
                     array('field_offer_publish_date', 'field_offer_expiration_date'),
                     array('field_departure_date', 'field_return_date'),
              );

      // Loop through our list of dates to compare and validate.
      foreach($dates as $date) {
        if ((!$entity->{$date[0]}->isEmpty() && !$entity->{$date[1]}->isEmpty()) &&
            (strtotime($entity->{$date[1]}->value) < strtotime($entity->{$date[0]}->value))) {

          $this->context->buildViolation($constraint->illogicalDate,
            ['%start_date' => $entity->{$date[0]}->value,
            '%start_label' => $entity->{$date[0]}->getFieldDefinition()->getLabel(),
            '%end_date' => $entity->{$date[1]}->value,
            '%end_label' => $entity->{$date[1]}->getFieldDefinition()->getLabel()])
          ->atPath($date[1])
          ->addViolation();
        }
      }

      // List of date field names and range to be checked.
      $compareDates = array('field_departure_date','field_return_date');
      // Range fields to compare against.
      $dateRange = array('field_offer_start_date', 'field_offer_end_date');

      // Loop through the dates to compare against our target range.
      foreach($compareDates as $date) {
        if ((!$entity->{$date}->isEmpty() && !$entity->{$dateRange[0]}->isEmpty() && !$entity->{$dateRange[1]}->isEmpty()) &&
            ((strtotime($entity->{$date}->value) < strtotime($entity->{$dateRange[0]}->value)) || 
             (strtotime($entity->{$date}->value) > strtotime($entity->{$dateRange[1]}->value))) ) {

          $this->context->buildViolation($constraint->rangeIssue,
            ['%field' => $entity->{$date}->getFieldDefinition()->getLabel(),
            '%fieldBetween1' => $entity->{$dateRange[0]}->getFieldDefinition()->getLabel(),
            '%fieldBetween2' => $entity->{$dateRange[1]}->getFieldDefinition()->getLabel()])
          ->atPath($date)
          ->addViolation();
        }
      }
    }
  }

}