<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Company controller.
 *
 * @Route("/companies")
 */
class CompanyController extends Controller
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

        return new Response($response);
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
        $name = $request->get('name');
        $address = $request->get('address');
        if(empty($name) || empty($address))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setName($name);
        $data->setAddress($address);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new View('Company Created Successfully', Response::HTTP_ACCEPTED);
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
        return $singleresult;
    }

    /**
     * Displays a form to edit an existing company entity.
     *
     * @Route("/{id}", name="companies_edit")
     * @Method("PUT")
     */
    public function editAction(int $id, Request $request)
    {
        $name = $request->get('name');
        $address = $request->get('address');
        $sn = $this->getDoctrine()->getManager();
        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->find($id);
        if (empty($company)) {
            return new View("company not found", Response::HTTP_NOT_FOUND);
        }

        if(!empty($name)) {
            $company->setName($name);
        }
        if(!empty($address)) {
            $company->setAddress($address);
        }

        $sn->flush();

        return new View("Company Updated Successfully", Response::HTTP_OK);
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
        return new View("Company deleted successfully", Response::HTTP_OK);
    }
}
