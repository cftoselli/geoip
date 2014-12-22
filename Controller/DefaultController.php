<?php

namespace Opinaia\GeoIpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OpinaiaGeoIpBundle:Default:index.html.twig', array('name' => $name));
    }
}
