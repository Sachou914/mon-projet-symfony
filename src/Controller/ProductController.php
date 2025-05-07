<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/admin/product/add', name: 'product_add')]
    public function add(Request $request): Response
    {
        $product = new Product();

        // Créer le formulaire
        $form = $this->createForm(ProductType::class, $product);

        // Traiter la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder le produit
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            // Redirection ou message de succès
            return $this->redirectToRoute('product_list');
        }

        // Rendre le formulaire
        return $this->render('admin/product_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
