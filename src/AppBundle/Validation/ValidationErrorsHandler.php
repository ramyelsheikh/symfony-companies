<?php
/**
 * Created by PhpStorm.
 * User: osboxes
 * Date: 5/16/18
 * Time: 6:14 AM
 */

namespace AppBundle\Validation;


use Symfony\Component\Validator\ConstraintViolationList;

class ValidationErrorsHandler
{
    /**
     * Extract, from a ConstraintViolationList object, an associative array as follow:
     * <code>
     *     array(
     *         'property1.1' => array('message1.1', 'message1.2'),
     *         'property1.2' => array('message2')
     *         ........
     *     )
     * </code>
     * with the possibility to filter a given property path.
     *
     * @param $violationsList ConstraintViolationList object
     * @param string $propertyPath The name of the property to filter
     *
     * @return array
     */
    static function violationsToArray(ConstraintViolationList $violationsList, $propertyPath = null)
    {
        $output = array();

        foreach ($violationsList as $violation) {
            $output[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        if (null !== $propertyPath) {
            if (array_key_exists($propertyPath, $output)) {
                $output = array($propertyPath => $output[$propertyPath]);
            } else {
                return array();
            }
        }

        return $output;
    }

}
