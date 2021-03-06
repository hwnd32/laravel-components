<?php
/**
 * Created by WooTeam
 * Date: 5/22/2020 4:45 PM
 */

namespace Kondratyev\LaravelComponents\Components\Reflection\Visitors;

use PhpParser;

class AddConstructorArgument extends NodeVisitor {
    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_type;

    public function __construct(string $type, string $name) {
        $this->_name = $name;
        $this->_type = $type;
    }

    public function enterNode(PhpParser\Node $node) {
        if ($node instanceof PhpParser\Node\Stmt\ClassMethod) {
            $variable = new PhpParser\Node\Expr\Variable($this->_name);
            $node->params[] = new PhpParser\Node\Param($variable, null, $this->_type);

            $assignVariable = $this->_builderFactory()->var('this->_'.$this->_name.' = $'.$this->_name.';');
            $node->stmts[] = $assignVariable;
        }
    }
}