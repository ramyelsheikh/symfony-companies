<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use AppBundle\Validation\ValidationErrorsHandler;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Employee controller.
 *
 * @Route("/employees")
 */
class EmployeeController extends FOSRestController
{
    /**
     * Lists all employee entities.
     *
     * @Route("", name="employees_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $employees = $em->getRepository('AppBundle:Employee')->findAll();

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($employees,'json');

        return new Response($response, Response::HTTP_OK);
    }

    /**
     * Creates a new employee entity.
     *
     * @Route("", name="employees_new")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $data = new Employee();
        $data->setName($request->get('name'));
        $data->setPhoneNumber($request->get('phone_number'));
        $data->setGender($request->get('gender'));
        $data->setDateOfBirth(\DateTime::createFromFormat('Y-m-d', $request->get('date_of_birth')));
        $data->setSalary($request->get('salary'));
        $data->setCompanyId($request->get('company_id'));

        $validator = $this->get('validator');
        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->find($request->get('company_id'));
        if($company === NULL) {
            return new View('Company Not Found', Response::HTTP_BAD_REQUEST);
        }
        $data->setCompany($company);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View($data, Response::HTTP_OK);
    }

    /**
     * Finds and displays a employee entity.
     *
     * @Route("/{id}", name="employees_show")
     * @Method("GET")
     */
    public function getAction(int $id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Employee')->find($id);
        if ($singleresult === null) {
            return new View("employee not found", Response::HTTP_NOT_FOUND);
        }

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($singleresult,'json');

        return new Response($response, Response::HTTP_OK);
    }

    /**
     * Displays a form to edit an existing employee entity.
     *
     * @Route("/{id}", name="employees_edit")
     * @Method("PUT")
     */
    public function editAction(int $id, Request $request)
    {
        $sn = $this->getDoctrine()->getManager();
        $employee = $this->getDoctrine()->getRepository('AppBundle:Employee')->find($id);
        if (empty($employee)) {
            return new View("employee not found", Response::HTTP_NOT_FOUND);
        }

        $employee->setName($request->get('name'));
        $employee->setPhoneNumber($request->get('phone_number'));
        $employee->setGender($request->get('gender'));
        $employee->setDateOfBirth(\DateTime::createFromFormat('Y-m-d', $request->get('date_of_birth')));
        $employee->setSalary($request->get('salary'));
        $employee->setCompanyId($request->get('company_id'));

        $validator = $this->get('validator');
        $errors = $validator->validate($employee);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->find($request->get('company_id'));
        if($company === NULL) {
            return new View('Company Not Found', Response::HTTP_BAD_REQUEST);
        }
        $employee->setCompany($company);

        $sn->flush();

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($employee,'json');

        return new Response($response, Response::HTTP_OK);
    }

    /**
     * Deletes a employee entity.
     *
     * @Route("/{id}", name="employees_delete")
     * @Method("DELETE")
     */
    public function deleteAction(int $id)
    {
        $sn = $this->getDoctrine()->getManager();
        $employee = $this->getDoctrine()->getRepository('AppBundle:Employee')->find($id);
        if (empty($employee)) {
            return new View("employee not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($employee);
            $sn->flush();
        }

        $serializer = $this->get('jms_serializer');

        $response = $serializer->serialize('Employee Deleted Successfully','json');

        return new Response($response, Response::HTTP_OK);
    }

}
