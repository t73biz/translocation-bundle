<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Scalar;
use T73Biz\Bundle\TranslocationBundle\NodeVisitor\TranslationNodeVisitorAbstract;

/**
 * Class TransNodeVisitor
 *
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class TransChoiceNodeVisitor extends TranslationNodeVisitorAbstract
{
    /**
     * We are only concerned with 2 items from the transChoice method; The id and the domain.
     * These are used in the extraction process to be set in the catalogue.
     *
     * @param Node $node
     * @return void
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof Expr\MethodCall && $node->name == 'transChoice') {
            $set = array();
            if (isset($node->args[0]) && $node->args[0]->value instanceof Scalar\String) {
                $set['key'] = $node->args[0]->value->value;
            }
            if (isset($node->args[3]) && $node->args[3]->value instanceof Scalar\String) {
                $set['domain'] = $node->args[3]->value->value;
            } else {
                $set['domain'] = 'messages';
            }
            $this->matches[] = $set;
        }
    }
}
