<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_USER") 
     */
    public function index()
    {
        $phpversion = phpversion();

        return $this->render('admin/index.html.twig', [
            'phpversion' => $phpversion,
            'controller_name' => 'AdminController',
        ]);
    }
}
