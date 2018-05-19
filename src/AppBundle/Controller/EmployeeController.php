<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use AppBundle\Validation\ValidationErrorsHandler;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Route;
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

        return $employees;
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

        //Validate Employee Entity
        $validator = $this->get('validator');
        $errors = $validator->validate($data);

        if (count($errors) > 0) {
            $validationErrors = ValidationErrorsHandler::violationsToArray($errors);
            return new View(['status' => false, 'errors'    => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->find($request->get('company_id'));
        if($company === NULL) {
            return new View(['status' => false, 'errors'    => 'Company Not Found'], Response::HTTP_BAD_REQUEST);
        }
        $data->setCompany($company);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View($data, Response::HTTP_CREATED);
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
            return new View(['status' => false, 'errors'    => 'employee not found'], Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * Edit an existing employee entity.
     *
     * @Route("/{id}", name="employees_edit")
     * @Method("PUT")
     */
    public function editAction(int $id, Request $request)
    {
        $sn = $this->getDoctrine()->getManager();
        $employee = $this->getDoctrine()->getRepository('AppBundle:Employee')->find($id);
        if (empty($employee)) {
            return new View(['status' => false, 'msg' => 'employee not found'], Response::HTTP_NOT_FOUND);
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
            return new View(['status' => false, 'errors'    => $validationErrors], Response::HTTP_BAD_REQUEST);
        }

        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->find($request->get('company_id'));
        if($company === NULL) {
            return new View(['status' => false, 'msg' => 'company not found'], Response::HTTP_BAD_REQUEST);
        }
        $employee->setCompany($company);

        $sn->flush();

        return $employee;
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
            return new View(['status' => false, 'msg'    => 'employee not found'], Response::HTTP_NOT_FOUND);
        }
        else {
            try {
                $sn->remove($employee);
                $sn->flush();
            } catch (ForeignKeyConstraintViolationException $e) {
                return new View(['status' => false, 'msg'    => 'Employee is related to some data and cannot be deleted']);
            }
        }

        return new View(['status' => true, 'msg'    => 'Employee Deleted Successfully'], Response::HTTP_OK);
    }

}
