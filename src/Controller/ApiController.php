<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Entity;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class UserController
 * @package App\Controller
 *
 * @RouteResource("api")
 */
class ApiController extends FOSRestController implements ClassResourceInterface {

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * OrderController constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory) {
        $this->formFactory = $formFactory;
    }

    /**
     * Create user
     *
     * @Rest\Post("/createUser")
     * @Rest\View(serializerGroups={"response"}, statusCode="201")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returns instance of the user with additional information after processing",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=User::class, groups={"response"})
     *     )
     * )
     * @SWG\Parameter(
     *     name="user_create",
     *     in="body",
     *     description="Process payment for given order",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=User::class, groups={"request"})
     *     )
     * )
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws FormValidationException
     */
    public function createUserAction(Request $request) {
        $repository = $this->getRepository(User::class);
        $form = $this->formFactory->create(UserType::class);
        $form->handleRequest($request);


        if (!$form->isSubmitted() || !$form->isValid()) {
            throw new FormValidationException($form, 'Invalid user', 1000, []);
        }

        $user = $form->getData();
        $repository->createOrder($user);

        $view = $this->view($user);

        return $view;
    }

    /**
     * Remove user
     *
     * @Rest\Post("/removeUser")
     * @Rest\View(serializerGroups={"response"}, statusCode="201")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returns whether the user was removed successfully",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=User::class, groups={"response"})
     *     )
     * )
     * @SWG\Parameter(
     *     name="user_delete",
     *     in="body",
     *     description="Process payment for given order",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=Order::class, groups={"request"})
     *     )
     * )
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws FormValidationException
     */
    public function removeUserAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getRepository(User::class);
        $id = $request->query->get('id');
        $user = $repository->find($id);
        if($user){
            $entityManager->remove($user);
            $entityManager->flush();
        }
        $view = $this->view($user);

        return $view;
    }

    /**
     * Create group
     *
     * @Rest\Post("/createGroup")
     * @Rest\View(serializerGroups={"response"}, statusCode="201")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returns whether the user was removed successfully",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=Group::class, groups={"response"})
     *     )
     * )
     * @SWG\Parameter(
     *     name="user_delete",
     *     in="body",
     *     description="Process payment for given order",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=Group::class, groups={"request"})
     *     )
     * )
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws FormValidationException
     */
    public function createGroupAction() {

    }

    /**
     * Remove group
     *
     * @Rest\Post("/removeGroup")
     * @Rest\View(serializerGroups={"response"}, statusCode="201")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returns whether the group was removed successfully",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=Group::class, groups={"response"})
     *     )
     * )
     * @SWG\Parameter(
     *     name="user_delete",
     *     in="body",
     *     description="Process payment for given order",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=Group::class, groups={"request"})
     *     )
     * )
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws FormValidationException
     */
    public function removeGroupAction() {

    }

    /**
     * Remove user
     *
     * @Rest\Post("/addGroupUser")
     * @Rest\View(serializerGroups={"response"}, statusCode="201")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returns whether the user was add to group successfully",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=User::class, groups={"response"})
     *     )
     * )
     * @SWG\Parameter(
     *     name="user_delete",
     *     in="body",
     *     description="Process payment for given order",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=Order::class, groups={"request"})
     *     )
     * )
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws FormValidationException
     */
    public function addGroupUserAction() {

    }

    /**
     * Remove user
     *
     * @Rest\Post("/removeGroupUser")
     * @Rest\View(serializerGroups={"response"}, statusCode="201")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returns whether the user was removed from the group successfully",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=User::class, groups={"response"})
     *     )
     * )
     * @SWG\Parameter(
     *     name="user_delete",
     *     in="body",
     *     description="Process payment for given order",
     *     @SWG\Schema(
     *         ref=@Nelmio\Model(type=Order::class, groups={"request"})
     *     )
     * )
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\Form\FormInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws FormValidationException
     */
    public function removeGroupUserAction() {

    }

    /**
     * @return UserRepository
     */
    private function getRepository($entityClass) {
        return $this->getDoctrine()->getRepository($entityClass);
    }
}