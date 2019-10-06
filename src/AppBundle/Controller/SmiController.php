<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Smi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Smi controller.
 *
 * @Route("admin/smi")
 */
class SmiController extends Controller
{
    /**
     * Lists all smi entities.
     *
     * @Route("/", name="admin_smi_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $smis = $em->getRepository('AppBundle:Smi')->findAll();

        return $this->render('admin/smi/index.html.twig', array(
            'smis' => $smis,
        ));
    }

    /**
     * Creates a new smi entity.
     *
     * @Route("/new", name="admin_smi_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $smi = new Smi();
        $form = $this->createForm('AppBundle\Form\SmiType', $smi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($smi);
            $em->flush();

            return $this->redirectToRoute('admin_smi_show', array('id' => $smi->getId()));
        }

        return $this->render('admin/smi/new.html.twig', array(
            'smi' => $smi,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a smi entity.
     *
     * @Route("/{id}", name="admin_smi_show")
     * @Method("GET")
     */
    public function showAction(Smi $smi)
    {
        $deleteForm = $this->createDeleteForm($smi);

        return $this->render('admin/smi/show.html.twig', array(
            'smi' => $smi,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing smi entity.
     *
     * @Route("/{id}/edit", name="admin_smi_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Smi $smi)
    {
        $deleteForm = $this->createDeleteForm($smi);
        $editForm = $this->createForm('AppBundle\Form\SmiType', $smi);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('smi_edit', array('id' => $smi->getId()));
        }

        return $this->render('admin/smi/edit.html.twig', array(
            'smi' => $smi,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a smi entity.
     *
     * @Route("/{id}", name="admin_smi_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Smi $smi)
    {
        $form = $this->createDeleteForm($smi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($smi);
            $em->flush();
        }

        return $this->redirectToRoute('admin_smi_index');
    }

    /**
     * Creates a form to delete a smi entity.
     *
     * @param Smi $smi The smi entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Smi $smi)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_smi_delete', array('id' => $smi->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}