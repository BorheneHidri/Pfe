<?php

namespace App\Services;

use App\DTO\Exceptions\StandardExceptionDTO;
use App\Utilities\Doctrine\QueryResult;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ResponsesGenerator
{
    const ERP_ERROR_TEMPLATE = 'ERP_ERROR';
    private array|null $redirect = null ;

    public function __construct(
        private SerializerInterface $serializer,
        private RequestStack $request,
    )
    {}

    public function generateResponse($data,$status = Response::HTTP_OK,array $context = []): Response
    {
        $response = new Response();
        if($data instanceof QueryResult){
            $data = $data->getResult() ;
        }
        $defaultContext = [] ;
        if(!key_exists(AbstractObjectNormalizer::ENABLE_MAX_DEPTH,$context))
        {
            $defaultContext[AbstractObjectNormalizer::ENABLE_MAX_DEPTH] = true;
        }
        if(!key_exists(AbstractObjectNormalizer::CIRCULAR_REFERENCE_HANDLER,$context))
        {
            $defaultContext[AbstractObjectNormalizer::CIRCULAR_REFERENCE_HANDLER] = function ($object) {
                return $object->getId();
            };
        }
        $response->setContent(
            $this->serializer->serialize($data,'json',array_merge($defaultContext,$context))
        );
        $response->setStatusCode($status);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}