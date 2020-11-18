<?php

namespace App\Controller;

use App\Entity\SummaryNumbers;
use App\Form\SummaryNumbersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SummaryNumbersController extends AbstractController
{
    /**
     * @Route("/admin/summary_numbers", name="admin_summary_numbers")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();
        $summaryNumbersData = $em->getRepository(SummaryNumbers::class)->findAll();

        return $this->render('summary_numbers/index.html.twig', [
            'summaryNumbersData' => $summaryNumbersData,
        ]);
    }

    /**
     * @Route("/admin/summary_numbers/new", name="admin_summary_numbers_new")
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $newSummaryNumbers = new SummaryNumbers();
        $form = $this->createForm(SummaryNumbersType::class, $newSummaryNumbers);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($newSummaryNumbers);
            $em->flush();
            return $this->redirectToRoute('admin_summary_numbers');
        }


        return $this->render('summary_numbers/new.html.twig', [
            'summaryNumbersForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/summary_numbers/edit/{id}", name="admin_summary_numbers_edit")
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository(SummaryNumbers::class)->find($id);
        $form = $this->createForm(SummaryNumbersType::class, $skill);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($skill);
            $em->flush();
            return $this->redirectToRoute('admin_summary_numbers');
        }


        return $this->render('summary_numbers/new.html.twig', [
            'summary_numbersForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/summary_numbers/delete/{id}", name="admin_summary_numbers_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository(SummaryNumbers::class)->find($id);
        $em->remove($skill);
        $em->flush();
        return $this->redirectToRoute('admin_summary_numbers');
    }
}
