<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Relation;
use AppBundle\Validation\ValidationErrorsHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($relations,'json');

        return new Response($response, Response::HTTP_OK);
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
        $name = $request->get('name');

        $validator = $this->get('validator');
        $errors = $validator->validate($data);


        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $data->setName($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new JsonResponse($data, Response::HTTP_OK);
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
            return new View("relation not found", Response::HTTP_NOT_FOUND);
        }

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($singleresult,'json');

        return new Response($response, Response::HTTP_OK);
    }

    /**
     * Displays a form to edit an existing relation entity.
     *
     * @Route("/{id}", name="relation_edit")
     * @Method("PUT")
     */
    public function editAction(int $id, Request $request)
    {
        $name = $request->get('name');

        $sn = $this->getDoctrine()->getManager();
        $relation = $this->getDoctrine()->getRepository('AppBundle:Relation')->find($id);
        if (empty($relation)) {
            return new View("relation not found", Response::HTTP_NOT_FOUND);
        }

        if(!empty($name)) {
            $relation->setName($name);
        }

        $sn->flush();

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($relation,'json');

        return new Response($response, Response::HTTP_OK);
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
            return new View("relation not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($relation);
            $sn->flush();
        }

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize('Relation Deleted Successfully','json');

        return new Response($response, Response::HTTP_OK);
    }

}
