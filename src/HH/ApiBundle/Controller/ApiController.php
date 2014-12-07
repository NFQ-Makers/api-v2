<?php

namespace HH\ApiBundle\Controller;

use HH\ApiBundle\Entity\EventsLog;
use HH\ApiBundle\Service\EventsLogService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \DateTime as DateTime;

/**
 * @Route("/api/v2")
 */
class ApiController extends Controller
{
    /**
     * @Route ("/")
     * @Method ("GET")
     *
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
     * @Route ("/event")
     * @Method ("POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function eventAction(Request $request)
    {
        if (!$data = $request->request->all()) {
            return new JsonResponse(array("status" => "error", "message" => "bad request"), 400);
        }
        date_default_timezone_set('Europe/Vilnius');
        $timestamp = new DateTime('now');
        $time = $request->get('time');

        $deviceId = $request->get('deviceId');
        $type = $request->get('type');
        $data = $request->get('data');
        $event = new EventsLog();

        //@todo: set processed on kernel.terminate
        $event->setDeviceId($deviceId)
            ->setData($data)
            ->setDeviceTime($time['sec'])
            ->setProcessed(false)
            ->setTimestamp($timestamp)
            ->setType($type);

        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();
        /** @var EventsLogService $eventService */
        $eventService = $this->container->get('api.events_log_service');
        $eventService->setLastEvent($event);

        $responseData = array("status" => "ok");
        $headers = array("X-TableEventStored" => "1");
        return new JsonResponse($responseData, 200, $headers);
    }
}
