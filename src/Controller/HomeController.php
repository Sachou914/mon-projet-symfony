<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        // Récupération de toutes les catégories et produits
        $categories = $categoryRepository->findAll();
        $products = $productRepository->findAll();

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    #[Route('/category/{id}', name: 'category_show')]
    public function showCategory(Category $category): Response
    {
        return $this->render('home/category_show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/product/{id}', name: 'product_show')]
    public function showProduct(Product $product): Response
    {
        return $this->render('home/product_show.html.twig', [
            'product' => $product,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/profile', name: 'user_profile')]
    public function profile(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/redirect_if_logged_in', name: 'redirect_if_logged_in')]
    public function redirectIfLoggedIn(Security $security): Response
    {
        if ($security->getUser()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('home/not_logged_in.html.twig');
    }
}
