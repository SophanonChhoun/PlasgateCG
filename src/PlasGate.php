<?php

namespace Kunlyly\PlasGate;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\RequestOptions;

class PlasGate
{
    protected $method;
    protected $params;
    protected $key_param;

    public function sendSms($text, $phone_number)
    {
        $this->params['text'] = $text;

        if (is_string($phone_number)) {
            $this->params['number'] = $phone_number;
        } elseif (is_array($phone_number)) {
            $this->params['number'] = implode(',', $phone_number);
        }

        return $this->request(true);
    }

    public function request($is_array = false)
    {
        try {
            $request = new Client([
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'http_errors' => false,
                'verify' => false,
            ]);

            $response = $request->post(config('lyly-cg-otp.url') . 'authorize', [
                RequestOptions::JSON => [
                    'username' => config('lyly-cg-otp.username'),
                    'password' => config('lyly-cg-otp.password'),
                ],
            ]);

            $response = json_decode($response->getBody(), $is_array);

            if (! isset($response['status'])) {
                return false;
            }

            $response = $request->post(config('lyly-cg-otp.url') . 'accesstoken', [
                RequestOptions::JSON => [
                    'authorization_code' => $response['data']['authorization_code'],
                ],
            ]);

            $response = json_decode($response->getBody(), $is_array);

            if (! isset($response['status'])) {
                return false;
            }

            $response = $request->post(config('lyly-cg-otp.url') . 'send', [
                RequestOptions::JSON => [
                    [
                        'number' => $this->params['number'],
                        'senderID' => config('lyly-cg-otp.sender_id'),
                        'type' => 'sms',
                        'text' => $this->params['text'],
                    ],
                ],
                'headers' => [
                    'X-Access-Token' => $response['data']['access_token'],
                ],
            ]);

            $response = json_decode($response->getBody(), $is_array);

            if (! isset($response['status'])) {
                return false;
            }

            return $response;
        } catch (ConnectException $e) {
            return $e->getMessage();
        }
    }

    public function randomOtpNumber($digit = 4)
    {
        return rand(pow(10, $digit - 1), pow(10, $digit) - 1);
    }

    public function getEnv()
    {
        return response()->json([
           'username' => config('lyly-cg-otp.username'),
           'password' => config('lyly-cg-otp.password'),
           'senderId' => config('lyly-cg-otp.sender_id'),
           'test' => config('lyly-cg-otp.test'),
        ]);
    }
}
