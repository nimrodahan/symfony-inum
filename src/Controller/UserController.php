<?php

namespace App\Controller;

use App\Repository\UserRepository;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class UserController
 * @package App\Controller
 *
 * @RouteResource("user")
 */
class UserController extends FOSRestController implements ClassResourceInterface {

    public function getUsersAction() {
        $repository = $this->getRepository();
        $data = $repository->findAll();
        if ($data) {
            $view = $this->view($data, Response::HTTP_OK);
        } else {
            $view = $this->view($data, Response::HTTP_BAD_REQUEST);
        }
//        $view->setTemplate('CoreBundle::index.html.twig');
        return $this->handleView($view);
    }

    /**
     * @return UserRepository
     */
    private function getRepository(){
        return $this->getDoctrine()->getRepository(User::class);
    }
}