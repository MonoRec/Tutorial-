<?php
/**
 * Created by PhpStorm.
 * User: BaTryXaaa
 * Date: 7/6/2017
 * Time: 20:33
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function homepageAction() {
        return $this->render('main/homepage.html.twig');
    }
}