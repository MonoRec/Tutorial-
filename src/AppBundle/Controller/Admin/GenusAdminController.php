<?php
/**
 * Created by PhpStorm.
 * User: BaTryXaaa
 * Date: 7/8/2017
 * Time: 19:28
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Genus;

use AppBundle\Form\GenusFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_MANAGE_GENUS')")
 * @Route("/admin")
 */
class GenusAdminController extends Controller
{
    /**
     * @Route("/genus", name="admin_genus_list")
     */
    public function indexAction() {

        // Trow a exception that user is not a admin
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $genuses = $this->getDoctrine()
            ->getRepository('AppBundle:Genus')
            ->findAll();

        return $this->render('admin/genus/list.html.twig', array(
           'genuses' => $genuses
        ));
    }

    /**
     * @Route("/genus/new", name="admin_genus_new")
     */
    public function newAction(Request $request) {

        $form = $this->createForm(GenusFormType::class);

        //only handle data on POST
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $genus = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($genus);
            $em->flush();

            $this->addFlash(
                'success',
                sprintf('Genus created - you (%s) are amazing!', $this->getUser()->getEmail())
            );

            return $this->redirectToRoute('admin_genus_list');

        }

        return $this->render('admin/genus/new.html.twig',[
            'genus_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/genus/{id}/edit", name="admin_genus_edit")
     */
    public function editAction(Request $request, Genus $genus) {

        $form = $this->createForm(GenusFormType::class, $genus);

        //only handle data on POST
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $genus = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($genus);
            $em->flush();
            $this->addFlash('success', 'Genus updated - you are amazing');

            return $this->redirectToRoute('admin_genus_list');

        }

        return $this->render('admin/genus/edit.html.twig',[
            'genus_form' => $form->createView()
        ]);
    }
}