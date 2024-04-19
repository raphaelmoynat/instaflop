<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Like;
use App\Entity\Post;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LikeController extends AbstractController
{
    #[Route('/like/post/{id}', name: 'app_like')]
    #[Route('/like/comment/{id}', name: 'comment_like')]
    public function index(Request $request, EntityManagerInterface $manager, LikeRepository $likeRepository, Post $post = null, Comment $comment = null ): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json("no user connected", 400);
        }

        if ($post !== null) {
            $entity = $post;
        } elseif ($comment !== null) {
            $entity = $comment;
        } else {
            return $this->json("No post or comment find", 400);
        }

        if ($entity->isLikedBy($user)) {
            $like = $likeRepository->findOneBy([
                'author' => $this->getUser(),
                'post' => $post,
                'comment' => $comment
            ]);
            $manager->remove($like);
            $isLiked = false;
        } else {
            $like = new Like();
            if ($post !== null) {
                $like->setPost($post);
            } elseif ($comment !== null) {
                $like->setComment($comment);
            }
            $like->setAuthor($user);
            $manager->persist($like);
            $isLiked = true;
        }

        $manager->flush();

        $data = [
            'liked' => $isLiked,
            'count' => $likeRepository->count(['post' => $post, 'comment' => $comment])
        ];

        return $this->json($data, 200);
    }
}
