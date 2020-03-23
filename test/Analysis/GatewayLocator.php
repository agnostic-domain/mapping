<?php

declare(strict_types=1);

namespace ADM\Test\Analysis;

use LogicException;
use PHPStan\Type\Type;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ObjectType;
use PHPStan\Reflection\MethodReflection as Method;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PhpParser\Node\Name as ClassName;
use PhpParser\Node\Expr\MethodCall as Call;
use PhpParser\Node\Expr\ClassConstFetch as ClassConstant;
use Doctrine\ORM\EntityRepository;
use ADM\UseCase\Infrastructure\Locator;

final class GatewayLocator implements DynamicMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return Locator\Gateway::class;
    }

    public function isMethodSupported(Method $method): bool
    {
        return $method->getName() === 'get';
    }

    public function getTypeFromMethodCall(Method $method, Call $call, Scope $scope): Type
    {
        $classConstant = $call->args[0]->value;
        if (!$classConstant instanceof ClassConstant) {
            throw new LogicException(sprintf('Expected %s got %s', ClassConstant::class, get_class($classConstant)));
        }

        $className = $classConstant->class;
        if (!$className instanceof ClassName) {
            throw new LogicException(sprintf('Expected %s got %s', ClassName::class, get_class($className)));
        }

        $fqn = $className->parts;
        $class = array_pop($fqn);
        $class = implode('\\', $fqn) . '\Gateway\\' . $class;

        return new ObjectType(class_exists($class) ? $class : EntityRepository::class);
    }
}
