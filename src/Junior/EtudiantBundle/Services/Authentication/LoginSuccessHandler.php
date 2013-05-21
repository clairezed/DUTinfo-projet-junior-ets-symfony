<?php

namespace Junior\EtudiantBundle\Services\Authentication;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $security;

//    public function __construct(RouterInterface $router) {
//        $this->router = $router;
//    }
    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
//        if ($token->getUser()->isSuperAdmin()) {
//        if ($token->isGranted('ROLE_ETUDIANT')) {
//            return new RedirectResponse($this->router->generate('etudiant_dashboard'));
//        } else {
//            return new RedirectResponse($this->router->generate('gestion_dashboard'));
//        }
        if ($this->security->isGranted('ROLE_ETUDIANT'))
        {
            $response = new RedirectResponse($this->router->generate('junior_etudiant_dashboard'));            
        }
        elseif ($this->security->isGranted('ROLE_GESTION'))
        {
            $response = new RedirectResponse($this->router->generate('junior_gestion_dashboard'));
        } 
//        elseif ($this->security->isGranted('ROLE_USER'))
//        {
//            // redirect the user to where they were before the login process begun.
//            $referer_url = $request->headers->get('referer');
//                        
//            $response = new RedirectResponse($referer_url);
//        }
            
        return $response;
  
    }

}