<?php

namespace ACSEO\FastShowGeneratorBundle\Annotations\Driver;
 
use Doctrine\Common\Annotations\Reader;

class Annotation extends Driver
{
    private $reader;
 
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;

        parent::__construct();
    }

    public function getShowableData()
    {
        $reflectionClass = new \ReflectionClass($this->classMetadata->name);

        $data = array();

        foreach ($reflectionClass->getProperties() as $property) {
            $propertyAnnotation = $this->reader->getPropertyAnnotation($property, 'ACSEO\FastShowGeneratorBundle\Annotations\Show');

            if (null != $propertyAnnotation) {
                $propertyAnnotationOptions = $propertyAnnotation->getOptions();

                if (
                    !array_key_exists('show', $propertyAnnotationOptions) || (true == $propertyAnnotationOptions['show'])
                    && in_array($this->group, $propertyAnnotation->getGroups())
                ) {
                    $label = array_key_exists('label', $propertyAnnotationOptions) ? $propertyAnnotationOptions['label'] : ucfirst($property->name);

                    $data[$label] = $this->entity->{'get'.ucfirst($property->name)}();
                }
            }
        }

        return $data;
    }
}
