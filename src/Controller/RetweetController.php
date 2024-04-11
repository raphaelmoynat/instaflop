<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Retweet;
use App\Form\RetweetType;
use App\Repository\PostRepository;
use App\Repository\RetweetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RetweetController extends AbstractController
{
    #[Route('/retweet/post/{id}', name: 'app_retweet')]
    public function retweet(Request $request, $id, PostRepository $postRepository, EntityManagerInterface $manager): Response
    {
        // Trouver le post original
        $toBeRetweet = $postRepository->find($id);

        // Créer un nouveau retweet
        $retweet = new Retweet();
        $retweet->setPost($toBeRetweet);

        // Créer le formulaire de retweet
        $form = $this->createForm(RetweetType::class, $retweet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le contenu du retweet
            $retweetContent = $retweet->getContent();

            // Créer un nouveau post avec le contenu du retweet et du post original
            $newPost = new Post();
            $newPost->setAuthor($this->getUser());
            $newPost->setRetweetContent($retweetContent);
            $newPost->setContent($toBeRetweet->getContent()); // Ajouter le contenu du post original
            $newPost->setCreatedAt(new \DateTime());

            $manager->persist($newPost);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil ou une autre page
            return $this->redirectToRoute('app_post');
        }

        return $this->render('retweet/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
