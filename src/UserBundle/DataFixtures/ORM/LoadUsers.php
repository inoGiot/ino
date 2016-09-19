<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerAwareInterface
     */
    private $container;

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setPassword('userpass');
        $manager->persist($user);

        // the queries aren't done until now
        $manager->flush();
    }

    private function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.password_encoder')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($user, $plainPassword);
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
