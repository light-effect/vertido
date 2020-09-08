<?php


namespace App\Controller;

use App\Entity\Customer;
use App\Entity\District;
use App\Entity\Policy;
use App\Exception\ValidationException;
use App\Resource\PolicyCollection;
use App\Resource\ResourceCollection;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class PolicyController extends AbstractController
{

    /**
     * @Route ("/policies")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getPolicies(Request $request)
    {
        try {
            $policy = $this->getDoctrine()->getRepository(Policy::class)->findByRequest($request);

            return $this->json((new PolicyCollection($policy))->toArray());
        } catch (ValidationException $exception) {
            throw new HttpException(400, $exception->getMessage());
        }

    }
}
