<?php 
namespace Drupal\custom_node\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
Class CustomnodeCreation extends Controllerbase{
	public function finalcontent(){
	 $node = Node::create(['type' => 'article']);
	 $node->set('title','test node');
	 $node->set('uid',1);
	 $node->status = 1;
	 $node->save();
      
     return [
         $this->messenger()->addMessage($this->t('Node Created succesfully'), 'status',TRUE)
        
     ];
	} 
 }