<?php 
namespace Drupal\node_unpublished\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
Class NodeUnpublish extends ControllerBase{
	public function content(){
		$node = Node::load(21);
		$node->status = 0;
        $node->save();
		// return drupal_set_message("Node with nid " . $node->id() . " saved!\n");
		return [];
	}
} 


