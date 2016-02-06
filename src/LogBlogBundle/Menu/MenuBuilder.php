<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 06.02.16
 * Time: 19:46
 */

namespace LogBlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $menuFactory;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(FactoryInterface $menuFactory, AuthorizationCheckerInterface $authChecker, TokenStorageInterface $tokenStorage)
    {
        $this->menuFactory = $menuFactory;
        $this->authorizationChecker = $authChecker;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return FactoryInterface
     */
    public function getMenuFactory()
    {
        return $this->menuFactory;
    }

    /**
     * @return AuthorizationCheckerInterface
     */
    public function getAuthorizationChecker()
    {
        return $this->authorizationChecker;
    }

    /**
     * @return TokenStorageInterface
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * Builds the Main menu
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->getMenuFactory()->createItem('root');

        $menu->addChild('home', [
            'label' => 'Startseite',
            'route' => 'log_blog_homepage',
        ]);

        if ($this->getAuthorizationChecker()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if ($this->getAuthorizationChecker()->isGranted('ROLE_AUTHOR')) {
                $menu->addChild('new_post', [
                    'label' => 'Neuer Eintrag',
                    'route' => 'log_blog_authoring_post_write',
                ]);
                $menu->addChild('list_posts', [
                    'label' => 'Alle Posts',
                    'route' => 'log_blog_authoring_post_list',
                ]);
            }

            $menu->addChild('profile', [
                'label' => (string) $this->getTokenStorage()->getToken()->getUsername(),
                'route' => 'fos_user_profile_show',
            ]);
            $menu->addChild('logout', [
                'label' => 'Abmelden',
                'route' => 'fos_user_security_logout',
            ]);
        } else {
            $menu->addChild('login', [
                'label' => 'Anmelden',
                'route' => 'fos_user_security_login',
            ]);
        }

        return $menu;
    }
}