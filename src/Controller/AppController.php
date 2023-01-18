<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends BaseController
{

    /**
     * @Route(
     *     methods={"GET"},
     *     path="/",
     * )
     */
    public function index(Request $request)
    {
        return new Response();
    }

    /**
     * @Route(
     *     methods={"GET"},
     *     path="/healthcheck",
     * )
     */
    public function healthcheck(Request $request)
    {
        return new Response('OK');
    }

}