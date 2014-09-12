<?php
/**
 * This file is part of the Chorescore Application.
 *
 * (c) 2014 Chorescore.me <http://chorescore.me>
 *
 * All rights reserved. USe of this code without written permission is strictly forbidden
 *
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */

namespace T73Biz\Bundle\TranslocationBundle\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Scalar;
use PhpParser\NodeVisitor;

class TranslationNodeVisitorAbstract implements NodeVisitor
{
    /**
     * @var array $matches
     */
    protected $matches = array();

    /**
     * @param array $nodes
     * @return null|\PhpParser\Node[]
     */
    public function beforeTraverse(array $nodes)
    {
        return null;
    }

    /**
     * @param Node $node
     * @return null|Node
     */
    public function enterNode(Node $node)
    {
        return null;
    }

    /**
     * @param Node $node
     * @param int  $keyIndex
     * @param int  $domainIndex
     * @return false|null|Node|\PhpParser\Node[]|void
     */
    public function leaveNode(Node $node, $keyIndex = 0, $domainIndex = 2)
    {
        if ($node instanceof Expr\MethodCall && $node->name == 'trans') {
            $set = array();
            if (isset($node->args[$keyIndex]) && $node->args[$keyIndex]->value instanceof Scalar\String) {
                $set['key'] = $node->args[$keyIndex]->value->value;
            }
            if (isset($node->args[$domainIndex]) && $node->args[$domainIndex]->value instanceof Scalar\String) {
                $set['domain'] = $node->args[$domainIndex]->value->value;
            } else {
                $set['domain'] = 'messages';
            }
            $this->matches[] = $set;
        }
    }

    /**
     * @param array $nodes
     * @return null|\PhpParser\Node[]
     */
    public function afterTraverse(array $nodes)
    {
        return null;
    }

    /**
     * @return array
     */
    public function getMatches()
    {
        return $this->matches;
    }
}
