<?php

namespace AppBundle\Controller;

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
        $name = $request->get('name');
        $phoneNumber = $request->get('phone_number');
        $gender = $request->get('gender');
        $dateOfBirth = $request->get('date_of_birth');
        $salary = $request->get('salary');

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
        $data->setSalary($salary);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new JsonResponse($data, Response::HTTP_OK);
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
        $name = $request->get('name');
        $phoneNumber = $request->get('phone_number');
        $gender = $request->get('gender');
        $dateOfBirth = $request->get('date_of_birth');
        $salary = $request->get('salary');

        $sn = $this->getDoctrine()->getManager();
        $employee = $this->getDoctrine()->getRepository('AppBundle:Employee')->find($id);
        if (empty($employee)) {
            return new View("employee not found", Response::HTTP_NOT_FOUND);
        }

        if(!empty($name)) {
            $employee->setName($name);
        }
        if(!empty($phoneNumber)) {
            $employee->setPhoneNumber($phoneNumber);
        }
        if(!empty($gender)) {
            $employee->setGender($gender);
        }
        if(!empty($dateOfBirth)) {
            $employee->setPhoneNumber($dateOfBirth);
        }
        if(!empty($salary)) {
            $employee->setSalary($salary);
        }

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
