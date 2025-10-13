<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


final class ContactController extends AbstractController
{
     #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function index( Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        
        

        if ($form->isSubmitted() && $form->isValid()) {
            //Sauvegarder les données dans la base de données
            $entityManager->persist($contact);
            $entityManager->flush();
            //$contactrepo->findOneBySomeField($contact, true);
            $adress  = $contact->getEmail();
            $username = $contact->getName();
            // Envoi de l'email
            $email = (new Email())
                ->from('toto@example.com')
                ->to($adress)
                ->subject('Nouveau message de contact')
                ->text($username . 'Nous avons bien reçu votre message et nous vous contacterons sous peu.');

            $mailer->send($email);

            // Message de succès
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
