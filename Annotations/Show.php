<?php

namespace ACSEO\FastShowGeneratorBundle\Annotations;
 
/**
 * @Annotation
 */
class Show
{
    protected $options;
    protected $groups;

    public function __construct($options)
    {
        $this->options = $options;
        $this->groups = isset($options['groups']) ? (array) $options['groups'] : array('default');
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getGroups()
    {
        return $this->groups;
    }
}
