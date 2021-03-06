<?php
namespace Bolt\Extensions\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

use Bolt\Extensions\Entity;


class ListPackages extends AbstractAction
{
    
    public function __invoke(Request $request, $params)
    {
        
        $repo = $this->em->getRepository(Entity\Package::class);
        if($search = $request->get('name')) {
            $packages = $repo->createQueryBuilder('p')
                ->where('p.approved = :status')
                ->andWhere('p.name LIKE :name')
                ->setParameter('status', true)
                ->setParameter('name', '%'.$search.'%')
                ->getQuery()
                ->getResult();
        } else {
            $packages = $repo->findBy(['approved'=>true]);
        }
        array_walk($packages, function(&$v, $k){
            $v = $v->serialize();
            unset($v['approved']);
            unset($v['account']);
            $v['versions'] = explode(",",$v['versions']);
        });

        $response = new JsonResponse(['packages'=>$packages]);
        $response->setCallback($request->get('callback'));
        return $response;
    }
}