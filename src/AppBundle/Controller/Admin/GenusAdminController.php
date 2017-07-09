<?php
/**
 * Created by PhpStorm.
 * User: BaTryXaaa
 * Date: 7/8/2017
 * Time: 19:28
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Form\GenusFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class GenusAdminController extends Controller
{
    /**
     * @Route("/genus", name="admin_genus_list")
     */
    public function indexAction() {
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

            $this->addFlash('success', 'Genus created - you are amazing');

            return $this->redirectToRoute('admin_genus_list');

        }

        return $this->render('admin/genus/new.html.twig',[
            'genus_form' => $form->createView()
        ]);
    }
}