<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dependant;
use AppBundle\Validation\ValidationErrorsHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($dependants,'json');

        return new Response($response, Response::HTTP_OK);
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
        $name = $request->get('name');
        $phoneNumber = $request->get('phone_number');
        $gender = $request->get('gender');
        $dateOfBirth = $request->get('date_of_birth');

        $validator = $this->get('validator');
        $errors = $validator->validate($data);


        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $data->setName($name);
        $data->setPhoneNumber($phoneNumber);
        $data->setGender($gender);
        $data->setDateOfBirth($dateOfBirth);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new JsonResponse($data, Response::HTTP_OK);
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
            return new View("dependant not found", Response::HTTP_NOT_FOUND);
        }

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($singleresult,'json');

        return new Response($response, Response::HTTP_OK);
    }

    /**
     * Displays a form to edit an existing dependant entity.
     *
     * @Route("/{id}", name="dependant_edit")
     * @Method("PUT")
     */
    public function editAction(int $id, Request $request)
    {
        $name = $request->get('name');
        $phoneNumber = $request->get('phone_number');
        $gender = $request->get('gender');
        $dateOfBirth = $request->get('date_of_birth');

        $sn = $this->getDoctrine()->getManager();
        $dependant = $this->getDoctrine()->getRepository('AppBundle:Dependant')->find($id);
        if (empty($dependant)) {
            return new View("dependant not found", Response::HTTP_NOT_FOUND);
        }

        if(!empty($name)) {
            $dependant->setName($name);
        }
        if(!empty($phoneNumber)) {
            $dependant->setPhoneNumber($phoneNumber);
        }
        if(!empty($gender)) {
            $dependant->setGender($gender);
        }
        if(!empty($dateOfBirth)) {
            $dependant->setPhoneNumber($dateOfBirth);
        }

        $sn->flush();

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($dependant,'json');

        return new Response($response, Response::HTTP_OK);
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
            return new View("dependant not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($dependant);
            $sn->flush();
        }

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize('Dependant Deleted Successfully','json');

        return new Response($response, Response::HTTP_OK);
    }

}
