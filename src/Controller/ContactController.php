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
     #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function index( Request $request, MailerInterface $mailer): Response
    {
        //$contact = new Contact();

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
       

        if ($form->isSubmitted() && $form->isValid()) {

                $data = $form->getData();
                 
                $name = $data['name'];
                $adress = $data['email'];
                $message = $data['message'];
                
            $email = (new Email())
            ->from($adress)
            ->to('you@example.com')
            ->subject('objet')
            ->text($name.$message);

            $mailer->send($email);
         
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        
}
