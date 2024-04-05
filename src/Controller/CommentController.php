<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/comment/create/{id}', name: 'app_comment_create')]
    public function create(Request $request, EntityManagerInterface $manager, Post $post):Response
    {


        $comment= new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $comment->setCreatedAt(new \DateTime());


            $comment->setPost($post);
            $manager->persist($comment);
            $manager->flush();

        }

        return $this->redirectToRoute("app_show",["id"=>$post->getId()]);


    }

    #[Route('/comment/delete/{id}', name: 'delete_comment')]
    public function delete(Comment $comment, EntityManagerInterface $manager): Response
    {

            $post = $comment->getPost();

            $manager->remove($comment);
            $manager->flush();

            return $this->redirectToRoute('app_show', ["id" => $post->getId()]);


    }

    #[Route('/comment/edit/{id}', name: 'edit_comment')]
    public function edit(Request $request, EntityManagerInterface $manager, Comment $comment):Response
    {
        $post = $comment->getPost();
        $form = $this->createForm(CommentType::class, $comment);




            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $comment->setCreatedAt(new \DateTime());

                $manager->persist($comment);
                $manager->flush();

                return $this->redirectToRoute("app_show", ["id" => $post->getId()]);
            }



        return $this->render('comment/edit.html.twig', [

            "form"=>$form->createView(),
        ]);

    }
}
