<?php
namespace Bolt\Extensions\Action;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormError;

use Doctrine\ORM\EntityManager;
use Twig_Environment;
use Aura\Router\Router;

use Bolt\Extensions\Entity;

class AbstractAction
{
    
    public $renderer;
    public $forms;
    public $em;
    public $router;
    
    public $accountUser;
    public $request;
    

    public function __construct(Twig_Environment $renderer, FormFactory $forms, EntityManager $em = null, Router $router = null)
    {
        $this->renderer = $renderer;
        $this->em = $em;
        $this->forms = $forms;
        $this->router = $router;
    }
    
    public function checkUser()
    {
        $id = $this->request->getSession()->get("bolt.account.id");
        if (null !== $id) {
            $this->accountUser = $this->em->find(Entity\Account::class, $id);
            $this->renderer->addGlobal('isLoggedIn', true);
            $this->renderer->addGlobal('user', $this->accountUser);
            return true;
        }
    }
    
    
    public function restrictAccess($request)
    {
        
        if (null !== $this->accountUser) {
            return true;
        }
        
        $request->getSession()->set('bolt.auth.return', $request->getPathInfo());
        return false;
    }
    
    public function setRequest($request)
    {
        $this->request = $request;
        $this->checkUser();
        $this->renderer->addGlobal('session', $request->getSession());
    }
    
}