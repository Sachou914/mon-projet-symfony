<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\ProductRepository;

class CartService
{
    private RequestStack $requestStack;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    /**
     * Récupère le panier stocké en session
     */
    private function getCart(): array
    {
        return $this->requestStack->getSession()->get('cart', []);
    }

    /**
     * Sauvegarde le panier en session
     */
    private function saveCart(array $cart): void
    {
        $this->requestStack->getSession()->set('cart', $cart);
    }

    /**
     * Ajoute un produit au panier
     */
    public function addToCart(int $productId): void
    {
        $cart = $this->getCart();

        if (!isset($cart[$productId])) {
            $cart[$productId] = 1; // Si le produit n'existe pas dans le panier, l'ajouter avec une quantité de 1
        } else {
            $cart[$productId]++; // Sinon, incrémenter la quantité
        }

        $this->saveCart($cart); // Sauvegarder le panier après modification
    }

    /**
     * Supprime une unité d'un produit
     */
    public function removeFromCart(int $productId): void
    {
        $cart = $this->getCart();
    
        if (isset($cart[$productId])) {
            $cart[$productId]--;
            if ($cart[$productId] <= 0) {
                unset($cart[$productId]);
            }
        }
    
        $this->saveCart($cart);
    }

    /**
     * Supprime complètement un produit du panier
     */
    public function deleteFromCart(int $productId): void
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        $this->saveCart($cart);
    }

    /**
     * Vide complètement le panier
     */
    public function clearCart(): void
    {
        $this->saveCart([]);
    }

    /**
     * Récupère le panier avec les détails des produits
     */
    public function getCartWithDetails(): array
    {
        $cart = $this->getCart();
        $cartWithDetails = [];

        foreach ($cart as $productId => $quantity) {
            $product = $this->productRepository->find($productId);
            if ($product) {
                $cartWithDetails[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartWithDetails;
    }

    /**
     * Calcule le total du panier
     */
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getCartWithDetails() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }
}
