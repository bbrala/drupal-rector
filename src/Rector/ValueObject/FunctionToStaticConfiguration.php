<?php

namespace DrupalRector\Rector\ValueObject;

class FunctionToStaticConfiguration {

    protected string $deprecatedFunctionName;

    protected string $className;

    protected string $methodName;

    /**
     * @var array|int[] Reorder arguments array[old_position] = new_position
     */
    private array $argumentReorder;

    /**
     * @param string $deprecatedFunctionName Deprecated function name
     * @param string $className Class to call static method on
     * @param string $methodName Method to call statically
     * @param array|int[] $argumentReorder Reorder arguments array[old_position] = new_position
     */
    public function __construct(string $deprecatedFunctionName, string $className, string $methodName, array $argumentReorder = []) {
        $this->deprecatedFunctionName = $deprecatedFunctionName;
        $this->className = $className;
        $this->methodName = $methodName;
        $this->argumentReorder = $argumentReorder;
    }

    public function getDeprecatedFunctionName(): string {
        return $this->deprecatedFunctionName;
    }

    public function getClassName(): string {
        return $this->className;
    }

    public function getMethodName(): string {
        return $this->methodName;
    }

    /**
     * @return array|int[] Reorder arguments array[old_position] = new_position
     */
    public function getArgumentReorder(): array {
        return $this->argumentReorder;
    }

}
