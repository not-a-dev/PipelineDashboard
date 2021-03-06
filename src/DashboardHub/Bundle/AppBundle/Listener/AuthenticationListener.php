<?php

namespace DashboardHub\Bundle\AppBundle\Listener;

use DashboardHub\Bundle\AppBundle\Entity\AuthenticationAudit;
use DashboardHub\Bundle\AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Save User to system after login
 * Audit that the User has log in
 *
 * Class AuthenticationListener
 * @package DashboardHub\Bundle\AppBundle\Listener
 */
class AuthenticationListener
{

    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager   $em
     * @param SecurityContext $securityContext
     */
    public function __construct(EntityManager $em, SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
        $this->em              = $em;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $this->em
            ->getRepository('DashboardHubAppBundle:User')
            ->findOneByUsername(
                $this->securityContext->getToken()->getUser()->getUsername()
            );

        if (is_null($user)) {
            $user = new User($this->securityContext->getToken()->getUser()->getUsername());
        }

        $authenticationAudit = new AuthenticationAudit();
        $authenticationAudit->setUser($user);

        $this->em->persist($authenticationAudit);

        $this->em->persist($user);
        $this->em->flush();
    }
}
