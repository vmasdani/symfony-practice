<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\User;
use App\Util;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TestController extends AbstractController
{
    #[Route('/test')]
    function allTest(): JsonResponse
    {
        return $this->json([
            'bod' => [
                [
                    'hello' => 'world!'
                ],
                [
                    'this is' => 'a symphony.'
                ],
                [
                    'some strings' => Util::getSomeString()
                ],

            ]
        ]);
    }

    #[Route('/test/template')]
    function templ(
        ManagerRegistry $doctrine,
        SerializerInterface $serializer
    ): Response
    {
        $em = $doctrine->getManager();

        return $this->render('testtemplate.html.twig', [
            'myVar' =>
            json_encode([
                'test' => 'myvar',
            ]),
            'employees' => $serializer->serialize(
                $em->getRepository(Employee::class)->findAll(),
                'json'
            )
        ]);
    }

    #[Route('/persist-employee')]
    function persisteEmployee(
        ManagerRegistry $doctrine,
        SerializerInterface $serializer,
        Request $request
    ): Response
    {
        $em = $doctrine->getManager();

        $e = new Employee();
        $e->setName("Hello " . date('c'));

        if ($request->query->get('secret_code') != $_ENV['APP_SECRET']){
            return new Response(
            'Whoops. secret_code invalid. Look your .env file for the code..',
                    Response::HTTP_UNAUTHORIZED,
               
            );
        }

        $em->persist($e);
        $em->flush();

        return new Response(
            $serializer->serialize($e, 'json'),
                Response::HTTP_OK,
            [
                'content-type' => 'application/json'
            ]
        );
    }

    #[Route('/persist-user')]
    function persistUser (
        ManagerRegistry $doctrine,
        SerializerInterface $serializer
    ): Response
    {
        $em = $doctrine->getManager();

        $u = new User();
        $u->setUsername("Hello " . date('c'));
        $u->setPassword('mypasword');

        $em->persist($u);
        $em->flush();

        return new Response(
            $serializer->serialize($u, 'json'),
                Response::HTTP_OK,
            [
                'content-type' => 'application/json'
            ]
        );
    }

    #[Route('/employees')]
    function emps(
        ManagerRegistry $d,
        SerializerInterface $serializer
    ): Response
    {
        $em = $d->getManager();
        $es = $em->getRepository(Employee::class)->findAll();

        return new Response(
            $serializer->serialize($es, 'json'),
                Response::HTTP_OK,
            [
                'content-type' => 'application/json'
            ]
        );
    }
    #[Route('/employees/{id}')]
    function emp(
        ManagerRegistry $d,
        int $id,
        SerializerInterface $serializer
    ): Response
    {
        $em = $d->getManager();
        $e = $em->getRepository(Employee::class)->find($id);

        return new Response(
            $serializer->serialize($e, 'json'),
                Response::HTTP_OK,
            [
                'content-type' => 'application/json'
            ]
        );
    }
}