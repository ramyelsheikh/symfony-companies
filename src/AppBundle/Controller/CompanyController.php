<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Validation\ValidationErrorsHandler;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\FOSRestController;


/**
 * Company controller.
 *
 * @Route("/companies")
 */
class CompanyController extends FOSRestController
{
    /**
     * Lists all company entities.
     *
     * @Route("", name="companies_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $companies = $em->getRepository('AppBundle:Company')->findAll();

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($companies,'json');

        return new Response($response, Response::HTTP_OK);
    }

    /**
     * Create New Company.
     *
     * @Route("", name="companies_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $data = new Company();
        $data->setName($request->get('name'));
        $data->setAddress($request->get('address'));

        $validator = $this->get('validator');
        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View($data, Response::HTTP_OK);
    }

    /**
     * Finds and displays a company entity.
     *
     * @Route("/{id}", name="companies_get")
     * @Method("GET")
     */
    public function getAction(int $id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Company')->find($id);
        if ($singleresult === null) {
            return new View("company not found", Response::HTTP_NOT_FOUND);
        }

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($singleresult,'json');

        return new Response($response, Response::HTTP_OK);
    }

    /**
     * Displays a form to edit an existing company entity.
     *
     * @Route("/{id}", name="companies_edit")
     * @Method("PUT")
     */
    public function editAction(int $id, Request $request)
    {
        $sn = $this->getDoctrine()->getManager();
        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->find($id);
        if (empty($company)) {
            return new View("company not found", Response::HTTP_NOT_FOUND);
        }

        $company->setName($request->get('name'));
        $company->setAddress($request->get('address'));

        $validator = $this->get('validator');
        $errors = $validator->validate($company);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $sn->flush();

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($company,'json');

        return new Response($response, Response::HTTP_OK);
    }

    /**
     * Deletes a company entity.
     *
     * @Route("/{id}", name="companies_delete")
     * @Method("DELETE")
     */
    public function deleteAction(int $id)
    {
        $sn = $this->getDoctrine()->getManager();
        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->find($id);
        if (empty($company)) {
            return new View("company not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($company);
            $sn->flush();
        }

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize('Company Deleted Successfully','json');

        return new Response($response, Response::HTTP_OK);
    }
}
