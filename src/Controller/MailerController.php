<?php

namespace App\Controller;

use App\Form\MailerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;

class MailerController extends AbstractController
{
    /**
     * @Route("/email", name="mailer")
     * @param MailerInterface $mailer
     * @return Response
     */
    public function sendEmail(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(MailerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $message = (new Email())
                ->from('piotrzakrzewski@piotrzakrzewski89.pl')
                ->to('piotrzakrzewski@piotrzakrzewski89.pl')
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            try {
                $mailer->send($message);
                $this->addFlash('success', 'Wysłano wiadomość !');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
            }

        }

        return $this->render('mailer/index.html.twig', [
            'our_form' => $form->createView()
        ]);
    }
}
