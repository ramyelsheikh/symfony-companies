<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Validation\ValidationErrorsHandler;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;
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

        return $companies;
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

        //Validate Company Entity
        $validator = $this->get('validator');
        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new View(['status' => false, 'errors'    => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View($data, Response::HTTP_CREATED);
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
            return new View(['status' => false, 'errors'    => 'company not found'], Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * Edit an existing company entity.
     *
     * @Route("/{id}", name="companies_edit")
     * @Method("PUT")
     */
    public function editAction(int $id, Request $request)
    {
        $sn = $this->getDoctrine()->getManager();
        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->find($id);
        if (empty($company)) {
            return new View(['status' => false, 'msg' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }

        $company->setName($request->get('name'));
        $company->setAddress($request->get('address'));

        $validator = $this->get('validator');
        $errors = $validator->validate($company);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new View(['status' => false, 'errors'    => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $sn->flush();

        return $company;
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
            return new View(['status' => false, 'msg'    => 'Company Not Found'], Response::HTTP_NOT_FOUND);
        }
        else {
            try {
                $sn->remove($company);
                $sn->flush();
            } catch (ForeignKeyConstraintViolationException $e) {
                return new View(['status' => false, 'msg'    => 'Company is related to some data and cannot be deleted']);
            }
        }

        return new View(['status' => true, 'msg'    => 'Company Deleted Successfully'], Response::HTTP_OK);
    }
}
