<?php

namespace T73Biz\Bundle\TranslocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TranslateController extends Controller
{
    /**
     * @Route("/translate")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
