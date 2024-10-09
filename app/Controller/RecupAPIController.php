<?php

namespace Controller;

use GrahamCampbell\ResultType\Success;
use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\Service\DatabaseService;
use Studoo\EduFramework\Core\View\TwigCore;
use Symfony\Component\Console\Command\Command;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class RecupAPIController implements ControllerInterface
{
    /**
     * @param Request $request
     * @return string|null
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function execute(Request $request): string|null
    {
        $connect=DatabaseService::getConnect();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://velib-metropole-opendata.smovengo.cloud/opendata/Velib_Metropole/station_information.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_COOKIE => "ApplicationGatewayAffinityCORS=67d576648b679337ca3e5e855bcd1aa1; ApplicationGatewayAffinity=67d576648b679337ca3e5e855bcd1aa1; dtCookie=v_4_srv_5_sn_FDCA807BEE37E3E798EACC9C758DCB8F_perc_100000_ol_0_mul_1_app-3Aea7c4b59f27d43eb_1; __cf_bm=UD.51TNdIKpUCRU50d9HJ_rg2WFHMKygo89GG_SEhNk-1714998914-1.0.1.1-2tnIvXLAW1oFCcyeB16wtRmse12G7CrfH.Ycwk2JPD54WY3icjz0.wcCLTle1V8c21KmF2KwOVDdshGZjtYHWw",
            CURLOPT_HTTPHEADER => [
                "User-Agent: insomnia/8.6.1"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $velib_data = json_decode($response, true);

            foreach ($velib_data["data"]["station"] as $station) {
                var_dump($station);
                exit();

            }
            return  Command::SUCCESS;

            $curl=$connect->fetchAll();
        }

        $velib_data = json_decode($response, true);
        return TwigCore::getEnvironment()->render('api/api.html.twig',
            [
                "titre"   => 'Recup_APIController',
                'apiData' => $velib_data
            ]
        );
    }
}