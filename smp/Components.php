<?php

namespace Smp;

/**
 * Class Components
 * @package Smp
 */
class Components
{
    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return Response::i();
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return Request::i();
    }

    /**
     * @return DataBase
     */
    public function getDb(): DataBase
    {
        return new DataBase();
    }
}