<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Component\HttpFoundation\JsonResponse;

class Handler extends ExceptionHandler
{
//    public function render($request, Exception $e)
//    {
//        if ($e instanceof NotFound) {
//            return new JsonResponse($e->getMessage(), 404);
//        }
//
//        if ($e instanceof \DomainException) {
//            return new JsonResponse($e->getMessage(), 400);
//        }
//
//        if ($e instanceof InvalidUuidStringException) {
//            return new JsonResponse('invalid id format', 400);
//        }
//
////        return new JsonResponse('internal error', 500);
//        parent::render($request, $e);
//    }

}
