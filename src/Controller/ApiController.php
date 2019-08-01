<?php
namespace Drupal\api_module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;

class ApiController extends ControllerBase{
//Return the json representation of a node
  function content($node_id){
    $node =  Node::load($node_id)->toArray();
    return new JsonResponse($node);
  } 

//check whether the siteapikey and node is valid or not 
 function accessOwnOrders($key,$node_id){
    $node =  Node::load($node_id);
    $siteapi = \Drupal::configFactory()->getEditable('api_module.settings')->get('siteapikey'); 
    if(!empty($node) && $node->getType() == 'page' && $siteapi == $key){
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }
}
