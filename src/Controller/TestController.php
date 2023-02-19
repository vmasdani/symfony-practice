<?php

namespace App\Controller;

use App\Util;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test')]
    function allTest(): JsonResponse
    {
        return $this->json(['bod' => [
            [
                'hello' => 'world!'
            ],
            [
                'this is' => 'a symphony.'
            ],
            [
                'some strings' => Util::getSomeString()
            ],

        ]]);
    }

    #[Route('/test/template')]
    function templ(): Response
    {
        return $this->render('testtemplate.html.twig', ['myVar' => json_encode(['test' => 'myvar'])]);
    }
}
