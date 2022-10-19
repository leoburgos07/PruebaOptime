<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class ProductController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/products/create', name: 'create_product')]
    public function index(Request $request): Response
    {

        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            return $this->redirectToRoute('list_products');
        }

        return $this->render('product/createProducts.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/products', name: 'list_products')]
    public function listProducts(){
        $repository = $this->entityManager->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }
    #[Route('/product/delete/{id}', name: 'delete_product')]
   /**
     * @Method("DELETE")
     */
    public function delete(Product $product)
    {
        $product = $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $this->redirectToRoute('list_products');
    }

    #[Route('/product/{id}', name: 'product')]
    /**
      * @Method("GET")
      */
    public function edit(Product $product, Request $request){

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            return $this->redirectToRoute('list_products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
