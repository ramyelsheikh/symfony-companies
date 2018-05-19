<?php

namespace AppBundle\Controller;

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
 * Relation controller.
 *
 * @Route("/relations")
 */
class RelationController extends FOSRestController
{
    /**
     * Lists all relation entities.
     *
     * @Route("", name="relation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $relations = $em->getRepository('AppBundle:Relation')->findAll();

        return $relations;
    }

    /**
     * Creates a new relation entity.
     *
     * @Route("", name="relation_new")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $data = new Relation();
        $data->setName($request->get('name'));

        //Validate Relation Entity
        $validator = $this->get('validator');
        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new View(['status' => false, 'errors' => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View($data, Response::HTTP_CREATED);
    }

    /**
     * Finds and displays a relation entity.
     *
     * @Route("/{id}", name="relation_show")
     * @Method("GET")
     */
    public function getAction(int $id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Relation')->find($id);
        if ($singleresult === null) {
            return new View(['status' => false, 'errors'    => 'relation not found'], Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * Edit an existing relation entity.
     *
     * @Route("/{id}", name="relation_edit")
     * @Method("PUT")
     */
    public function editAction(int $id, Request $request)
    {
        $sn = $this->getDoctrine()->getManager();
        $relation = $this->getDoctrine()->getRepository('AppBundle:Relation')->find($id);
        if (empty($relation)) {
            return new View(['status' => false, 'msg' => 'relation not found'], Response::HTTP_NOT_FOUND);
        }

        $relation->setName($request->get('name'));

        $validator = $this->get('validator');
        $errors = $validator->validate($relation);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new View(['status' => false, 'errors'    => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $sn->flush();

        return $relation;
    }

    /**
     * Deletes a relation entity.
     *
     * @Route("/{id}", name="relation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(int $id)
    {
        $sn = $this->getDoctrine()->getManager();
        $relation = $this->getDoctrine()->getRepository('AppBundle:Relation')->find($id);
        if (empty($relation)) {
            return new View(['status' => false, 'msg' => 'relation not found'], Response::HTTP_NOT_FOUND);
        }
        else {
            try {
                $sn->remove($relation);
                $sn->flush();
            } catch (ForeignKeyConstraintViolationException $e) {
                return new View(['status' => false, 'msg'    => 'Relation is related to some data and cannot be deleted']);
            }
        }

        return new View(['status' => true, 'msg'    => 'Relation Deleted Successfully'], Response::HTTP_OK);
    }

}
