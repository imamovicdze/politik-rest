<?php

namespace app\models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Councillor
{
    /**
     * Return councillor details
     *
     * @param $id
     * @return mixed
     * @throws GuzzleException
     */
    public function getCouncillor($id)
    {
        $client = new Client();

        $res = $client->request('GET', $this->getCouncillorUrl($id), [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody());
        }
    }

    /**
     * Return all councillors
     *
     * @throws GuzzleException
     */
    public function getAllCouncillors()
    {
        $client = new Client();

        $res = $client->request('GET', $this->getCouncillorsUrl(), [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody());
        }
    }

    /**
     * Return councillors with pageNumber param
     *
     * @param $pageNumber
     * @return mixed
     * @throws GuzzleException
     */
    public function getCouncillorsByPageNumber($pageNumber)
    {
        $client = new Client();

        $res = $client->request('GET', $this->getCouncillorPageNumberUrl($pageNumber), [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody());
        }
    }

    /**
     * Sort By FirstName or LastName if sort param exist
     *
     * @param $order
     * @param $councillors
     * @return bool
     */
    public function sortByNameOrLastName($order, $councillors)
    {
        switch ($order) {
            case 'firstName':
                usort($councillors, array($this, "cmpFirstName"));
                return $councillors;
            case 'lastName':
                usort($councillors, array($this, "cmpLastName"));
                return $councillors;
            default:
                return $councillors;
        }
    }

    /**
     * Sort by firstName
     *
     * @param $a
     * @param $b
     * @return int
     */
    private function cmpFirstName($a, $b)
    {
        if ($a->firstName < $b->firstName) {
            return -1;
        } else if ($a->firstName > $b->firstName) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Sort by lastName
     *
     * @param $a
     * @param $b
     * @return int
     */
    private function cmpLastName($a, $b)
    {
        if ($a->lastName < $b->lastName) {
            return -1;
        } else if ($a->lastName > $b->lastName) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Return all councillors url
     *
     * @return string
     */
    private function getCouncillorsUrl()
    {
        return 'http://ws-old.parlament.ch/councillors?format=json';
    }

    /**
     * Return councillor detail url
     *
     * @param $id
     * @return string
     */
    private function getCouncillorUrl($id)
    {
        return 'http://ws-old.parlament.ch/councillors/' . $id . '?format=json';
    }

    /**
     * Return different councillors with pageNumber
     *
     * @param $pageNumber
     * @return string
     */
    private function getCouncillorPageNumberUrl($pageNumber)
    {
        return 'http://ws-old.parlament.ch/councillors?format=json&pageNumber=' . $pageNumber;
    }
}
