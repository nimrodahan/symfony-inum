<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
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
     * @var OrderRepository
     */
    private $repository;

    /**
     * OrderController constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory) {
        $this->formFactory = $formFactory;
    }

    /**
     * Add user
     *
     * @Rest\Post("/addUser")
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
        $repository = $this->getRepository();
        $form = $this->formFactory->create(UserType::class);
        $form->handleRequest($request);


        if (!$form->isSubmitted() || !$form->isValid()) {
            throw new FormValidationException($form, 'Invalid order', 1000, []);
        }

        $user = $form->getData();
        $repository->createOrder($user);

        $view = $this->view($user);

        return $view;
    }

    /**
     * Remove user
     *
     * @Rest\Post("/addUser")
     * @Rest\View(serializerGroups={"response"}, statusCode="201")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Returns whether the user was removed or not",
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
        $form = $this->formFactory->create(UserType::class);
        $form->handleRequest($request);


        if (!$form->isSubmitted() || !$form->isValid()) {
            throw new FormValidationException($form, 'Invalid order', 1000, []);
        }

        $order = $form->getData();
        $this->repository->createOrder($order);

        $view = $this->view($order);

        return $view;
    }

    public function createGroupAction() {

    }

    public function removeGroupAction() {

    }

    public function addGroupUserAction() {

    }

    public function removeGroupUserAction() {

    }

    /**
     * @return UserRepository
     */
    private function getRepository() {
        return $this->getDoctrine()->getRepository(User::class);
    }
}