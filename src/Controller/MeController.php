<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
class MeController extends AbstractController
{
    public function __invoke(): Response
    {

        return $this->json(
           $this->getUser(),
           201,
           [],
           ['groups' => 'user:read']
        );
    }
}
