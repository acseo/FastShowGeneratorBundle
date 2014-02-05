<?php

namespace ACSEO\Bundle\FastShowGeneratorBundle\Annotations\Driver;
 
class Driver
{
    protected $entity;
    protected $classMetadata;
    protected $group;
 
    public function __construct()
    {
        $this->group = 'default';
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    public function setClassMetadata($classMetadata)
    {
        $this->classMetadata = $classMetadata;
    }

    public function setGroup($group)
    {
        $this->group = $group;
    }
}
