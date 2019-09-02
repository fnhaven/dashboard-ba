<?php

namespace App\Services;

use App\Services\Adapter\AdapterInterface;

abstract class AbstractApi
{
    /** @var AdapterInterface */
    protected $adapter;

    /** @var string */
    protected $endpoint;

    /**
     * AbstractApi constructor
     *
     * @param AdapterInterface $adapter
     * @param null $endpoint
     */
    public function __construct(AdapterInterface $adapter, $endpoint = null, $dyned_token = null)
    {
        $this->adapter = $adapter;
        $this->endpoint = $endpoint;
        $this->dyned_token = $dyned_token;
    }
}