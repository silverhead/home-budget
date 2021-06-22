<?php

namespace App\Adapter;

use Silverhead\PageCallback\Adapter\StoragePageCallbackInterface;
use Silverhead\PageCallback\Entity\PageCallback;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StorageSessionPageCallbackAdapter implements StoragePageCallbackInterface
{
    private SessionInterface $session;
    private string $sessionName = 'pagecallback';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    function storePageCallback(PageCallback $pageCallback): void
    {
        $this->session->set($this->sessionName .'_'.$pageCallback->getKeyCalledPage(), serialize($pageCallback));
    }

    function unStorePageCallback(string $keyCalledPage): ?PageCallback
    {
        $pageCallbackSerialized = $this->session->get($this->sessionName .'_'. $keyCalledPage);
        if (null !== $pageCallbackSerialized){
            return unserialize($pageCallbackSerialized);
        }

        return null;
    }
}
