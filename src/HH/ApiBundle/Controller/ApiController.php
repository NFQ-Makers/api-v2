<?php

namespace HH\ApiBundle\Controller;

use HH\ApiBundle\Service\RequestManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use \DateTime as DateTime;

class ApiController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        //@todo: remove either change. Currently render index with jquery, to test api calls
        return $this->render('ApiBundle:Default:index.html.twig');
    }

    // example data
    //     [
    //         {"time":{"sec":1398619851,"usec":844563},"deviceId":"table_1","type":"TableShake","data":{}},
    //         {"time":{"sec":1398619851,"usec":846044},"deviceId":"table_1","type":"AutoGoal","data":{"team":1}},
    //         {"time":{"sec":1398619851,"usec":847409},"deviceId":"table_1","type":"CardSwipe","data":{"team":0,"player":1,"card_id":123456789}},
    //         {"time":{"sec":1398619851,"usec":844563},"deviceId":"iceCream_1","type":"IceCream","data":{"userId":123,"amount":3}}
    //     ]
    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function eventAction(Request $request)
    {
        if (!$data = $request->request->all()) {
            return new JsonResponse(array("status" => "error", "message" => "bad request"), 400);
        }
        $timestamp = new DateTime('now');

        /** @var RequestManager $manager */
        $manager = $this->container->get('api.request_manager');
        $result = $manager->processRequest($request, $timestamp);

        $headers = array("X-TableEventStored" => "1");
        return new JsonResponse($result, 200, $headers);
    }
}
