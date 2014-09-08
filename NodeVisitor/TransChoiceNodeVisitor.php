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
        parent::leaveNode($node, 0, 3);
    }
}
