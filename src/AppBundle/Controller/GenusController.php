<?php
/**
 * Created by PhpStorm.
 * User: BaTryXaaa
 * Date: 7/4/2017
 * Time: 21:16
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class GenusController extends Controller
{

    /**
     * @Route("/genus/new")
     */
    public function newAction()
    {
        //Create new Object of Genus and set name
        $genus = new Genus();
        $genus->setName('Cotapus' . rand(1, 100));
        $genus->setSubFamily('Octopodinaie');
        $genus->setSpeciesCount(rand(1, 999999));

        //Create new Note
        $genusNote = new GenusNote();
        $genusNote->setUsername('Vlad');
        $genusNote->setUserAvatarFilename('ryan.jpg');
        $genusNote->setNote('dsadas sa sa');
        $genusNote->setCreatedAt(new \DateTime('-1 month'));
        $genusNote->setGenus($genus);

        //Get manager
        $em = $this->getDoctrine()->getManager();

        // Add row into db
        $em->persist($genus);
        $em->persist($genusNote);
        $em->flush();

        return new Response('<html><body>Genus created</body></html>');
    }

    /**
     * @Route("/genus");
     */
    public function listAction()
    {

        $em = $this->getDoctrine()->getManager();

        $genuses = $em->getRepository('AppBundle:Genus')
            ->findAllPublishedOrderedByRecentlyActive();

        return $this->render('genus/list.html.twig', [
            'genuses' => $genuses,
        ]);
    }

    /**
     * @Route("/genus/{genusName}", name="genus_show")
     */
    public function showAction($genusName)
    {
        $em = $this->getDoctrine()->getManager();
        $genus = $em->getRepository('AppBundle:Genus')
            ->findOneBy([
                'name' => $genusName
            ]);

        if (!$genus) {
            throw $this->createNotFoundException('No genus found');
        }

        // call our created service from container
        $transformer = $this->get('app.markdown_transformer');

        $funFact = $transformer->parse($genus->getFunFact());

        // $recentNotes = $genus->getNote()
        //     ->filter(function (GenusNote $note) {
        //     return $note->getCreatedAt() > new \DateTime('-3 months');
        //  });

        $recentNotes = $em->getRepository('AppBundle:GenusNote')
            ->findAllRecentNotesForGenus($genus);



        /*
        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        $key = md5($funFact);
        if($cache->contains($key)) {
            $funFact = $cache->fetch($key);
        } else {
            sleep(1);
            //From container we get bundle named markdown & use method called transform
            $funFact = $this->container->get('markdown.parser')->transform($funFact);
            $cache->save($key, $funFact);
        }
        */

        //return Response object (render template with response object)
        return $this->render('genus/show.html.twig', [
            'genus' => $genus,
            'funFact' => $funFact,
            'recentNoteCount' => count($recentNotes),
        ]);
    }

    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     */
    public function getNotesAction(Genus $genus)
    {
        $notes = [];
        foreach ($genus->getNote() as $note) {
            $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUsername(),
                'avatarUri' => '/images/' . $note->getUserAvatarFilename(),
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y')
            ];
        }

        $em = $this->getDoctrine()->getManager();


        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }
}