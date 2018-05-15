<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Company controller.
 *
 * @Route("companies")
 */
class CompanyController extends Controller
{
    /**
     * Lists all company entities.
     *
     * @Route("/", name="companies_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $companies = $em->getRepository('AppBundle:Company')->findAll();

        return $this->render('company/index.html.twig', array(
            'companies' => $companies,
        ));
    }

    /**
     * Creates a new company entity.
     *
     * @Route("/", name="companies_new")
     * @Method({"POST"})
     */
    public function newAction(Request $request)
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
        return new View("Company Added Successfully", Response::HTTP_OK);
    }

    /**
     * Finds and displays a company entity.
     *
     * @Route("/{id}", name="companies_show")
     * @Method("GET")
     */
    public function showAction(Company $company)
    {
        $deleteForm = $this->createDeleteForm($company);

        return $this->render('company/show.html.twig', array(
            'company' => $company,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing company entity.
     *
     * @Route("/{id}/edit", name="companies_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Company $company)
    {
        $deleteForm = $this->createDeleteForm($company);
        $editForm = $this->createForm('AppBundle\Form\CompanyType', $company);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('companies_edit', array('id' => $company->getId()));
        }

        return $this->render('company/edit.html.twig', array(
            'company' => $company,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a company entity.
     *
     * @Route("/{id}", name="companies_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Company $company)
    {
        $form = $this->createDeleteForm($company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($company);
            $em->flush();
        }

        return $this->redirectToRoute('companies_index');
    }

    /**
     * Creates a form to delete a company entity.
     *
     * @param Company $company The company entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Company $company)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('companies_delete', array('id' => $company->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
