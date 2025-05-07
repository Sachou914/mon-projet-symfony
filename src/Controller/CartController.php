<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $this->cartService->getCartWithDetails(),
            'total' => $this->cartService->getTotal()
        ]);
    }

   #[Route('/add/{id}', name: 'add')]
public function add(int $id): Response
{
    $this->cartService->addToCart($id); 
    return $this->redirectToRoute('cart_index');
}


    #[Route('/remove/{id}', name: 'remove')]
    public function remove(int $id): Response
    {
        $this->cartService->removeFromCart($id);
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(int $id): Response
    {
        $this->cartService->deleteFromCart($id);
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/clear', name: 'clear')]
    public function clear(): Response
    {
        $this->cartService->clearCart();
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/checkout', name: 'checkout')]
    public function checkout(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $cartItems = $this->cartService->getCartWithDetails();
        $total = $this->cartService->getTotal() + 15.99; // Frais de livraison

        if (!$user) {
            $this->addFlash('warning', 'Vous devez être connecté pour valider votre commande.');
            return $this->redirectToRoute('app_login');
        }

        if (empty($cartItems)) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('cart_index');
        }

        $order = new Order();
        $order->setUser($user);
        $order->setTotalPrice($total);
        $entityManager->persist($order);
        $entityManager->flush();

        foreach ($cartItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $orderItem->setProduct($item['product']);
            $orderItem->setQuantity($item['quantity']);
            $orderItem->setPrice($item['product']->getPrice());

            $entityManager->persist($orderItem);
        }

        $entityManager->flush();
        $this->cartService->clearCart();

        return $this->render('cart/confirmation.html.twig', [
            'order' => $order,
            'cartItems' => $cartItems,
            'total' => $total,
            'address' => $user->getAddress(),
        ]);
    }
}
