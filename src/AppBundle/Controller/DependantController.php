<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dependant;
use AppBundle\Entity\Relation;
use AppBundle\Validation\ValidationErrorsHandler;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dependant controller.
 *
 * @Route("/dependants")
 */
class DependantController extends FOSRestController
{
    /**
     * Lists all dependant entities.
     *
     * @Route("", name="dependant_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dependants = $em->getRepository('AppBundle:Dependant')->findAll();

        return $dependants;
    }

    /**
     * Creates a new dependant entity.
     *
     * @Route("", name="dependant_new")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $data = new Dependant();
        $data->setName($request->get('name'));
        $data->setPhoneNumber($request->get('phone_number'));
        $data->setGender($request->get('gender'));
        $data->setDateOfBirth(\DateTime::createFromFormat('Y-m-d', $request->get('date_of_birth')));
        $data->setRelationId($request->get('relation_id'));
        $data->setemployeeId($request->get('employee_id'));

        //Validate Dependant Entity
        $validator = $this->get('validator');
        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new View(['status' => false, 'errors'    => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $relation = $this->getDoctrine()->getRepository('AppBundle:Relation')->find($request->get('relation_id'));
        if($relation === NULL) {
            return new View(['status' => false, 'errors'    => 'Relation Not Found'], Response::HTTP_BAD_REQUEST);
        }
        $data->setRelation($relation);

        $employee = $this->getDoctrine()->getRepository('AppBundle:Employee')->find($request->get('employee_id'));
        if($employee === NULL) {
            return new View(['status' => false, 'errors'    => 'Employee Not Found'], Response::HTTP_BAD_REQUEST);
        }
        $data->setEmployee($employee);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View($data, Response::HTTP_CREATED);
    }

    /**
     * Finds and displays a dependant entity.
     *
     * @Route("/{id}", name="dependant_show")
     * @Method("GET")
     */
    public function getAction(int $id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Dependant')->find($id);
        if ($singleresult === null) {
            return new View(['status' => false, 'errors'    => 'dependant not found'], Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * Edit an existing dependant entity.
     *
     * @Route("/{id}", name="dependant_edit")
     * @Method("PUT")
     */
    public function editAction(int $id, Request $request)
    {
        $sn = $this->getDoctrine()->getManager();
        $dependant = $this->getDoctrine()->getRepository('AppBundle:Dependant')->find($id);
        if (empty($dependant)) {
            return new View(['status' => false, 'msg' => 'dependant not found'], Response::HTTP_NOT_FOUND);
        }

        $dependant->setName($request->get('name'));
        $dependant->setPhoneNumber($request->get('phone_number'));
        $dependant->setGender($request->get('gender'));
        $dependant->setDateOfBirth(\DateTime::createFromFormat('Y-m-d', $request->get('date_of_birth')));
        $dependant->setRelationId($request->get('relation_id'));
        $dependant->setemployeeId($request->get('employee_id'));

        $validator = $this->get('validator');
        $errors = $validator->validate($dependant);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new View(['status' => false, 'errors'    => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $relation = $this->getDoctrine()->getRepository('AppBundle:Relation')->find($request->get('relation_id'));
        if($relation === NULL) {
            return new View(['status' => false, 'msg' => 'relation not found'], Response::HTTP_BAD_REQUEST);
        }
        $dependant->setRelation($relation);

        $employee = $this->getDoctrine()->getRepository('AppBundle:Employee')->find($request->get('employee_id'));
        if($employee === NULL) {
            return new View(['status' => false, 'msg' => 'employee not found'], Response::HTTP_BAD_REQUEST);
        }
        $dependant->setEmployee($employee);

        $sn->flush();

        return $dependant;
    }

    /**
     * Deletes a dependant entity.
     *
     * @Route("/{id}", name="dependant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(int $id)
    {
        $sn = $this->getDoctrine()->getManager();
        $dependant = $this->getDoctrine()->getRepository('AppBundle:Dependant')->find($id);
        if (empty($dependant)) {
            return new View(['status' => false, 'msg'    => 'dependant not found'], Response::HTTP_NOT_FOUND);
        }
        else {
            try {
                $sn->remove($dependant);
                $sn->flush();
            } catch (ForeignKeyConstraintViolationException $e) {
                return new View(['status' => false, 'msg'    => 'Dependant is related to some data and cannot be deleted']);
            }
        }

        return new View(['status' => true, 'msg'    => 'Dependant Deleted Successfully'], Response::HTTP_OK);
    }

}
