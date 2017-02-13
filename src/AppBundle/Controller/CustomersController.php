<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CustomersController extends Controller
{
    /**
     * @Route("/customers/")
     * @Method("GET")
     */
    public function getAction()
    {
        $cacheService = $this->get('cache_service');
        $customers = $cacheService->get('customers');

        if (empty($customers)) {
            $database = $this->get('database_service')->getDatabase();
            $customers = $database->customers->find();
            $customers = iterator_to_array($customers);
            $cacheService->set('customers', json_encode($customers));
        } else {
            $customers = json_decode($customers);
        }

        return new JsonResponse($customers);
    }

    /**
     * @Route("/customers/")
     * @Method("POST")
     */
    public function postAction(Request $request)
    {
        $cacheService = $this->get('cache_service');
        $database = $this->get('database_service')->getDatabase();
        $customers = json_decode($request->getContent());

        if (empty($customers)) {
            return new JsonResponse(['status' => 'No donuts for you'], 400);
        }

        foreach ($customers as $customer) {
            $database->customers->insert($customer);
        }

        $cacheService->del('customers');

        return new JsonResponse(['status' => 'Customers successfully created']);
    }

    /**
     * @Route("/customers/")
     * @Method("DELETE")
     */
    public function deleteAction()
    {
        $cacheService = $this->get('cache_service');
        $database = $this->get('database_service')->getDatabase();
        $database->customers->drop();
        $cacheService->del('customers');

        return new JsonResponse(['status' => 'Customers successfully deleted']);
    }
}
