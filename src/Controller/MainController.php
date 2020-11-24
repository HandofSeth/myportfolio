<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\About;
use App\Entity\Skills;
use App\Entity\Projects;
use App\Entity\SummaryNumbers;
use App\Entity\Technologies;
use App\Entity\ContactForm;
use App\Form\MailerType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @param MailerInterface $mailer
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $aboutData = $em->getRepository(About::class)->find(1);
        $skillsData = $em->getRepository(Skills::class)->findBY(['is_public' => true]);
        $projectsData = $em->getRepository(Projects::class)->findBY(['is_public' => true]);
        $technologiesData = $em->getRepository(Technologies::class)->findBY(['is_public' => true]);
        $summaryNumbersData = $em->getRepository(SummaryNumbers::class)->findBY(['is_public' => true]);

        $contact = new ContactForm();
        $form = $this->createForm(MailerType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formName = $form->get('name')->getData();
            $formEmail = $form->get('email')->getData();
            $formSubject = $form->get('subject')->getData();
            $formBody = $form->get('body')->getData();
            $currentDate = new \DateTime();

            $message = (new Email())
                ->from('piotrzakrzewski@piotrzakrzewski89.pl')
                ->to('piotrzakrzewski@piotrzakrzewski89.pl')
                ->subject($formSubject)
                ->text('Sending emails is fun again!')
                ->html($currentDate->format('Y-m-d H:i:s') . '<br><br>Wiadomosc od: ' . $formName . ' : ' . $formEmail . '<br><br>' . $formBody);

            try {
                $mailer->send($message);
                $this->addFlash('success', 'Wysłano wiadomość !');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
            }
            return $this->redirectToRoute('main');
        }
        $rotateExploded = explode(",", $aboutData->getRotate());
        $rotateImploded = implode('.", "', $rotateExploded);

        return $this->render('main/index.html.twig', [
            'aboutData' => $aboutData,
            'skillsData' => $skillsData,
            'projectsData' => $projectsData,
            'technologiesData' => $technologiesData,
            'summaryNumbersData' => $summaryNumbersData,
            'rotateImploded' => $rotateImploded,
            'contactForm' => $form->createView(),
        ]);
    }
}
