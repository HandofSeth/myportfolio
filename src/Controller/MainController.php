<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\About;
use App\Entity\Skills;
use App\Entity\Projects;
use App\Entity\SummaryNumbers;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $aboutData = $em->getRepository(About::class)->find(1);
        $skillsData = $em->getRepository(Skills::class)->findBY(['is_public' => true]);
        $projectsData = $em->getRepository(Projects::class)->findAll();
        $summaryNumbersData = $em->getRepository(SummaryNumbers::class)->findAll();

        $rotateExploded = explode(",", $aboutData->getRotate());
        $rotateImploded = implode('.", "', $rotateExploded);

        return $this->render('main/index.html.twig', [
            'aboutData' => $aboutData,
            'skillsData' => $skillsData,
            'projectsData' => $projectsData,
            'summaryNumbersData' => $summaryNumbersData,
            'rotateImploded' => $rotateImploded
        ]);
    }
}
