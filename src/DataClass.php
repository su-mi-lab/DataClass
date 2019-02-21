<?php

namespace DataClass;

use DataClass\Exception\AssignException;
use DataClass\Exception\FinalClassException;
use DataClass\Exception\PropertyException;


abstract class DataClass
{
    /**
     * @var array
     */
    private $properties = [];

    /**
     * @var array
     */
    private $types = [];

    /**
     * DataClass constructor.
     *
     * @param array $arg
     *
     * @throws PropertyException
     * @throws FinalClassException
     * @throws \Exception
     */
    final public function __construct(array $arg = [])
    {
        $reflection = new \ReflectionClass(static::class);

        if ($reflection->isFinal() === false) {
            throw new FinalClassException('final class only');
        }

        if ((bool)$reflection->getProperties()) {
            throw new PropertyException('can not use property');
        }

        $this->setTypes($reflection->getDocComment());
        $this->setProperties($arg);
    }

    final public function __get(string $name)
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws AssignException
     */
    final public function __set($name, $value)
    {
        throw new AssignException('can not assign');
    }

    /**
     * @param array $updateParams
     *
     * @return DataClass
     * @throws FinalClassException
     * @throws PropertyException
     */
    final public function copy(array $updateParams): DataClass
    {
        $params = [];
        foreach ($this->properties as $key => $value) {
            $params[$key] = (isset($updateParams[$key])) ? $updateParams[$key] : $value;
        }

        return new static($params);
    }

    final private function setTypes(string $docs): void
    {
        preg_match_all('/@property *(\w+) *\$(\w+)/', $docs, $match);

        if (!empty($match[1]) && !empty($match[2])) {
            foreach ($match[1] as $index => $type) {
                $key = $match[2][$index];
                $this->types[$key] = $type;
            }
        }
    }

    final private function setProperties(array $arg): void
    {
        foreach ($arg as $key => $value) {

            if (empty($this->types[$key])) {
                continue;
            }

            $type = 'type' . ucfirst($this->types[$key]);
            $this->set($key, (method_exists($this, $type)) ? $this->$type($value) : $value);
        }
    }

    final private function set($name, $value): void
    {
        $this->properties[$name] = $value;
    }

    protected function typeArray(array $list): array
    {
        return $list;
    }

    protected function typeBool(bool $bool): bool
    {
        return $bool;
    }

    protected function typeFloat(float $float): float
    {
        return $float;
    }

    protected function typeInt(int $value): int
    {
        return $value;
    }
}