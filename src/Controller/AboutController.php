<?php

namespace App\Controller;

use App\Entity\About;
use App\Form\AboutType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AboutController extends AbstractController
{
    /**
     * @Route("/admin/about", name="admin_about")
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $aboutData = $em->getRepository(About::class)->find(1);
        if ($aboutData == Null) {
            $aboutData = new About();
        }
        $form = $this->createForm(AboutType::class, $aboutData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $pictureFileName = $form->get('fileNamePhoto')->getData();
            if ($pictureFileName) {
                try {
                    $oryginalFileName = pathinfo($pictureFileName->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $oryginalFileName);
                    $newFileNamePhoto = $safeFileName . '-' . uniqid() . '.' . $pictureFileName->guessExtension();
                    $pictureFileName->move('download/', $newFileNamePhoto);

                    $aboutData->setFileNamePhoto($newFileNamePhoto);
                    $em->persist($aboutData);
                    $em->flush();
                    $this->addFlash('success', 'Dodano zdjęcie');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
                }
            }

            $cvFileName = $form->get('fileNameCv')->getData();
            if ($cvFileName) {
                try {
                    $oryginalFileName = pathinfo($cvFileName->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $oryginalFileName);
                    $newFileNameCv = $safeFileName . '-' . uniqid() . '.' . $cvFileName->guessExtension();
                    $cvFileName->move('download/', $newFileNameCv);

                    $aboutData->setFileNameCv($newFileNameCv);
                    $em->persist($aboutData);
                    $em->flush();
                    $this->addFlash('success', 'Dodano zdjęcie');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
                }
            }
        }

        return $this->render('about/index.html.twig', [
            'aboutForm' => $form->createView(),
            'aboutData' => $aboutData,
        ]);
    }
}
