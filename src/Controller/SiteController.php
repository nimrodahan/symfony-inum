<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/Site")
 */
class SiteController {

    /**
     * @Route("/", name="index")
     */
    public function indexAction() {
        return new Response('<h1>Welcome!</h1><h3>InterNations Backend Developer coding test</h3>');
    }
}