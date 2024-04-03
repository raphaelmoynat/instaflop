<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            "posts"=>$postRepository->findAll(),
        ]);
    }

    #[Route('/create/post', name: 'app_create_post')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {


        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){




            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute("app_post");
        }




        return $this->render('post/create.html.twig', [
            "post"=>$post,
            "form"=>$form->createView(),
            "btnValue"=>"Poster"
        ]);
    }

    #[Route('/article/show/{id}', name: 'app_show')]
    public function show(Post $post): Response
    {



        return $this->render('post/show.html.twig', [
            "post"=>$post,

        ]);
    }

    #[Route('/post/delete/{id}', name: 'app_delete_post')]
    public function delete(EntityManagerInterface $manager, Post $post):Response
    {



            $manager->remove($post);
            $manager->flush();

            return $this->redirectToRoute("app_post");







    }

    #[Route('/post/edit/{id}', name: 'app_edit_post')]
    public function edit(Request $request, EntityManagerInterface $manager, Post $post):Response
    {
        $form = $this->createForm(PostType::class, $post);




            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $manager->persist($post);
                $manager->flush();

                return $this->redirectToRoute("app_show", ["id" => $post->getId()]);
            }





        return $this->render('post/create.html.twig', [
            "form"=>$form->createView(),
            "btnValue"=>"Editer"
        ]);

    }


}
