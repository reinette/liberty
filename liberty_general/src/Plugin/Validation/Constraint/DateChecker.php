<?php

namespace Drupal\liberty_general\Plugin\Validation\Constraint;

use Drupal\Core\Entity\Plugin\Validation\Constraint\CompositeConstraintBase;

/**
 * Checks if a value is a valid entity type.
 *
 * This uses the 'CompositeConstraintBase' class because it's running on the
 * entity, not just a single field, because we want to compare multiple things.
 *
 * @Constraint(
 *   id = "DateChecker",
 *   label = @Translation("Date Checker", context = "Validation"),
 *   type = "entity:node"
 * )
 */
class DateChecker extends CompositeConstraintBase {

  /**
   * The message to show if the dates don't make sense.
   *
   * @var string
   */
  public $illogicalDate = '%end_label of %end_date must be after %start_label of %start_date.';

  /**
   * The message to show if the date range is weird.
   *
   * @var string
   */
  public $rangeIssue = '%field must be within the date range of %fieldBetween1 and %fieldBetween2.';

  /**
   * {@inheritdoc}
   */
  public function coversFields() {
    return ['field_offer_start_date',
    		'field_offer_end_date',
    		'field_offer_expiration_date',
    		'field_offer_publish_date',
    		'field_departure_date',
    		'field_return_date'];
  }

}