<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


final class ContactController extends AbstractController
{
     #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les données dans la base de données
            $entityManager->persist($contact);
            $entityManager->flush();

            // Envoi de l'email
            $email = (new Email())
                ->from($contact->getEmail())
                ->to('jphilippe.champion@gmail.com')
                ->subject('Nouveau message de contact')
                ->text($contact->getMessage());

            $mailer->send($email);

            // Message de succès
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
