<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Post;
use App\Entity\ReplyComment;
use App\Entity\User;
use App\Form\ImageType;
use App\Form\ReplyCommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\ReplyCommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReplyCommentController extends AbstractController
{
    #[Route('/reply/comment/{id}', name: 'app_reply_comment')]
    public function index($id, Request $request, EntityManagerInterface $manager, CommentRepository $commentRepository): Response
    {
        //determiner la route utilisée
        $route = $request->attributes->get("_route");

        //en fonction de la route, récuperer la bonne entité

        switch ($route){

            case 'app_reply_comment':
                $entity = ReplyComment::class;
                $setter = "setComment";
                $redirectRoute = "app_post";
                break;


        }


        $toBeReply= $commentRepository->find($id);
        $existingReply = $toBeReply->getReplyComments();



        $reply = new ReplyComment();
        $formReply = $this->createForm(ReplyCommentType::class, $reply);
        $formReply->handleRequest($request);
        if($formReply->isSubmitted() && $formReply->isValid())
        {
            if($existingReply->count() > 0){
                return $this->redirectToRoute($redirectRoute);

            }else{
                $reply->$setter($toBeReply);
                $manager->persist($reply);
                $manager->flush();

            }



        }



        return $this->redirectToRoute($redirectRoute);
    }




}
