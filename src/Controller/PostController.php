<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController {

  #[Route('/post/create', name: 'post_create', methods: ['GET', 'POST'])]
  public function create(Request $request, EntityManagerInterface $entityManager): Response {
    // Create form
    $form = $this->createForm(PostType::class);

    // Se maneja la solicitud para ver si el formulario ha sido enviado
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      // Obtiene toda la infomación del formulario
      $entityManager->persist($form->getData());

      // Guardamos
      $entityManager->flush();

      // Generar mensaje de exito y redireccionar
      $this->addFlash('success', 'Publicación guardada con exito');
      return $this->redirectToRoute('post_create');
    }
    return $this->render('post/create.html.twig', [
      'form_create_post' => $form->createView(),
    ]);
  }

  #[Route('/post/{id}/edit', name: 'post_edit', methods: ['GET', 'POST'])]
  public function edit(Post $post, Request $request, EntityManagerInterface $entityManager): Response {
    // Create form
    $form = $this->createForm(PostType::class, $post);

    // Se maneja la solicitud para ver si el formulario ha sido enviado
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      // Obtiene toda la infomación del formulario
      //$entityManager->persist($form->getData()); linea opcional

      // Guardamos
      $entityManager->flush();

      // Generar mensaje de exito y redireccionar
      $this->addFlash('success', 'Publicación editada con exito');
      return $this->redirectToRoute('post_edit', [
        'id' => $post->getId()
      ]);
    }
    return $this->render('post/edit.html.twig', [
      'form_edit_post' => $form->createView(),
    ]);
  }
}
