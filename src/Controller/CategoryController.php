<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController {

  #[Route('/category', name: 'category_index')]
  public function index(EntityManagerInterface $entityManager): Response {
    return $this->render('category/index.html.twig', [
      'categories' => $entityManager->getRepository(Category::class)->findAll()
    ]);
  }

  #[Route('/category/create', name: 'category_create', methods: ['GET', 'POST'])]
  public function create(Request $request, EntityManagerInterface $entityManager): Response {
    // Create form
    $form = $this->createForm(CategoryType::class);

    // Se maneja la solicitud para ver si el formulario ha sido enviado
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      // Obtiene toda la infomación del formulario
      $entityManager->persist($form->getData());

      // Guardamos
      $entityManager->flush();

      // Generar mensaje de exito y redireccionar
      $this->addFlash('success', 'Categoria guardada con exito');
      return $this->redirectToRoute('category_create');
    }
    return $this->render('category/create.html.twig', [
      'form_create_category' => $form->createView(),
    ]);
  }

  #[Route('/category/{id}/edit', name: 'category_edit', methods: ['GET', 'POST'])]
  public function edit(Category $category, Request $request, EntityManagerInterface $entityManager): Response {
    // Create form
    $form = $this->createForm(CategoryType::class, $category);

    // Se maneja la solicitud para ver si el formulario ha sido enviado
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      // Guardamos
      $entityManager->flush();

      // Generar mensaje de exito y redireccionar
      $this->addFlash('success', 'Publicación editada con exito');
      return $this->redirectToRoute('category_edit', [
        'id' => $category->getId()
      ]);
    }
    return $this->render('category/edit.html.twig', [
      'form_edit_category' => $form->createView(),
    ]);
  }
}
