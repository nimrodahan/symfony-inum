<?php

namespace App\Controller;

use App\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController {

    public function removeEntity($entity) {
        $id = $this->request->query->get('id');
        if($this->entity['class'] === Entity\User::class) {
            /* @var Entity\User $user */
            $user = $this->em->find($this->entity['class'], $id);
            if($user->getIsAdmin()){
                $this->addFlash('error', 'Admin users cannot be deleted.');
                return $this->redirectToRoute('easyadmin', ['action' => 'list', 'entity' => $this->entity['name']]);
            } else {
                parent::removeEntity($entity);
            }
        } else if($this->entity['class'] === Entity\Group::class){
            /* @var Entity\Group $group */
            $group = $this->em->find($this->entity['class'], $id);
            if($group->getUsers()->count() === 0){
                parent::removeEntity($entity);
            } else {
                $this->addFlash('error', 'Groups containing users cannot be deleted.');
                return $this->redirectToRoute('easyadmin', ['action' => 'list', 'entity' => $this->entity['name']]);
            }
        }
        $this->addFlash('success', 'Deleted successfully.');
    }

}