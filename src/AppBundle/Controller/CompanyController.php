<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Validation\ValidationErrorsHandler;
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

        // Validate Company entity
        $validator = $this->get('validator');
        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new View($validationErrors, Response::HTTP_BAD_REQUEST);
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
    public function getAction(Company $company)
    {
        return $company;
    }

    /**
     * Edit an existing company entity.
     *
     * @Route("/{id}", name="companies_edit")
     * @Method({"PUT", "PATCH"})
     */
    public function editAction(Request $request)
    {
        $name = $request->request->get('name');
        $address = $request->request->get('address');

        if (empty($company)) {
            return new View(
                [
                    'status' => false,
                    'msg'    => 'Company not found',
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        if (!empty($name)) {
            $company->setName($name);
        }

        if (!empty($address)) {
            $company->setAddress($address);
        }

        $sn = $this->getDoctrine()->getManager();
        $sn->flush();
        return $company;
    }

    /**
     * Deletes a company entity.
     *
     * @Route("/{id}", name="companies_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Company $company)
    {
        if (empty($company)) {
            return new View("company not found", Response::HTTP_NOT_FOUND);
        } else {
            $sn = $this->getDoctrine()->getManager();
            $sn->remove($company);
            $sn->flush();
        }

        return new View(
            [
                'status' => true,
                'msg'    => 'Company Deleted Successfully',
            ],
            Response::HTTP_OK
        );
    }
}
