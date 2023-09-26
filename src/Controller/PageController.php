<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController {

  #[Route('/', name: 'index', methods: ['GET'])]
  public function index(EntityManagerInterface $entityManager): Response {
    return $this->render('page/index.html.twig', [
      'posts' => $entityManager->getRepository(Post::class)->findAll()
    ]);
  }

  #[Route('/contactos-v1', name: 'contact-v1', methods: ['GET', 'POST'])]
  public function contactV1(Request $request): Response {
    $form = $this->createFormBuilder()
      ->add('email', TextType::class)
      ->add('message', TextareaType::class, [
        'label' => 'Comentario, sugerencia o mensaje'
      ])
      ->add('save', SubmitType::class, [
       'label' => 'Enviar'
      ])
      //->setMethod('GET')
      //->setAction('otra-url')
      ->getForm();

    $form->handleRequest($request);
    if ($form->isSubmitted()) {
      //dd($form->getData(), $request);
      $this>$this->addFlash('success', 'Prueba form #1 con exito');
      return $this->redirectToRoute('contact-v1');
    }

    return $this->render('page/contact-v1.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  #[Route('/contactos-v2', name: 'contact-v2', methods: ['GET', 'POST'])]
  public function contactV2(Request $request): Response {
    $form = $this->createForm(ContactType::class);

    $form->handleRequest($request);
    if ($form->isSubmitted()) {
      $this>$this->addFlash('success', 'Prueba form #2 con exito');
      return $this->redirectToRoute('contact-v2');
    }

    return $this->render('page/contact-v2.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  #[Route('/contactos-v3', name: 'contact-v3', methods: ['GET', 'POST'])]
  public function contactV3(Request $request): Response {
    $form = $this->createForm(ContactType::class);

    $form->handleRequest($request);
    if ($form->isSubmitted()) {
      $this>$this->addFlash('info', 'Prueba form #3 con exito');
      return $this->redirectToRoute('contact-v3');
    }

    return $this->render('page/contact-v3.html.twig', [
      'form' => $form->createView(),
    ]);
  }
}
