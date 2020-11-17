<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\About;
use App\Entity\Skills;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $aboutData = $em->getRepository(About::class)->find(1);
        $skillsData = $em->getRepository(Skills::class)->findAll();

        $rotateExploded = explode(",", $aboutData->getRotate());
        $rotateImploded = implode('.", "', $rotateExploded);        

        return $this->render('main/index.html.twig', [
            'aboutData' => $aboutData,
            'skillsData' => $skillsData,
            'rotateImploded' => $rotateImploded
        ]);
    }
}
