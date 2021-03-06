<?php

namespace BoSearch\Hook;

use BoSearch\BoSearch;
use Symfony\Component\Routing\RouterInterface;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\SecurityContext;

/**
 * Class BoSearchHook
 * @package BoSearch\Hook
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class BoSearchHook extends BaseHook
{
    /** @var RouterInterface */
    protected $router;

    /** @var  SecurityContext */
    protected $securityContext;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router, SecurityContext $securityContext)
    {
        $this->router = $router;
        $this->securityContext = $securityContext;
    }

    public function onMainTopMenuTools(HookRenderEvent $event)
    {
        $isGranted = $this->securityContext->isGranted(
            ["ADMIN"],
            [],
            [BoSearch::getModuleCode()],
            [AccessManager::VIEW]
        );

        if ($isGranted) {
            $event->add($this->render("menu-hook.html", $event->getArguments()));
        }
    }
}
