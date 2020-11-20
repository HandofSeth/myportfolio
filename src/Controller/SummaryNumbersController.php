<?php

namespace App\Controller;

use App\Entity\SummaryNumbers;
use App\Form\SummaryNumbersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
            try {
                $em = $this->getDoctrine()->getManager();
                $newSummaryNumbers->setIsPublic(0);
                $newSummaryNumbers->setUploadedAt(new \DateTime());
                $newSummaryNumbers->setModificatedAt(new \DateTime());
                $em->persist($newSummaryNumbers);
                $em->flush();
                $this->addFlash('success', 'Dodano Liczbę');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
            }

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
        $summaryNumbers = $em->getRepository(SummaryNumbers::class)->find($id);
        $form = $this->createForm(SummaryNumbersType::class, $summaryNumbers);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $summaryNumbers->setModificatedAt(new \DateTime());
                $em->persist($summaryNumbers);
                $em->flush();
                $this->addFlash('success', 'Zmodyfikowano Liczbę');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
            }
            return $this->redirectToRoute('admin_summary_numbers');
        }


        return $this->render('summary_numbers/new.html.twig', [
            'summaryNumbersForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/summary_numbers/delete/{id}", name="admin_summary_numbers_delete")
     */
    public function delete($id)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $summaryNumbers = $em->getRepository(SummaryNumbers::class)->find($id);
            $em->remove($summaryNumbers);
            $em->flush();
            $this->addFlash('success', 'Usunięto Liczbę');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
        }
        return $this->redirectToRoute('admin_summary_numbers');
    }

    /**
     * @Route("/admin/summary_numbers/set_visibility/{id}{visibility}", name="admin_summary_numbers_set_visibility")
     */
    public function makeVisible($id, $visibility)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $summaryNumbers = $em->getRepository(SummaryNumbers::class)->find($id);
            $summaryNumbers->setModificatedAt(new \DateTime());
            $summaryNumbers->setIsPublic($visibility);
            $em->persist($summaryNumbers);
            $em->flush();
            $this->addFlash('success', 'Ustawiono widoczność');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
        }
        return $this->redirectToRoute('admin_summary_numbers');
    }
}
