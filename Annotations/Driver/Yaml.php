<?php

namespace ACSEO\Bundle\FastShowGeneratorBundle\Annotations\Driver;
 
class Yaml extends Driver
{
    private $reader;
    
    public function __construct($kernel)
    {
        $this->kernel = $kernel;

        parent::__construct();
    }

    public function getShowableData()
    {
        $reflectionClass = new \ReflectionClass($this->classMetadata->name);

        if (!($content = $this->getYamlContent($reflectionClass))) {
            return;
        }

        $data = array();

        foreach ($content[$this->classMetadata->name]['Columns'] as $propertyName => $propertyValues) {
            if (!array_key_exists('show', $propertyValues) || (true == $propertyValues['show']) && in_array($this->group, $propertyValues['groups'])) {
                $data[array_key_exists('label', $propertyValues) ? $propertyValues['label'] : ucfirst($propertyName)] = $this->entity->{'get'.ucfirst($propertyName)}();
            }
        }

        return $data;
    }

    /**
     * Get The Yaml file associated to a class and a group
     * @param \ReflectionClass $instance an instance of the class
     * @return array the parsed YAML file
     */
    private function getYamlContent($instance)
    {       
        $content = false;

        if ($yamlFile = $this->locateYamlFile($instance)) {
            $yamlParser = new Parser();
            $content = $yamlParser->parse(file_get_contents($yamlFile));
        }
        
        return $content;
    }

    /**
     * Locate a YAML File based on a directory convention
     * @param \ReflectionClass $instance an instance of the class
     * @return String the file name
     */
    private function locateYamlFile($instance) {
        $fileToLocate = sprintf(
            "@%s/Resources/config/fastshowgenerator/%s.%s.fastshowgenerator.yml", $this->getBundleNameForClass($instance->getName()), basename($instance->getFileName(), ".php"), $this->group
        );

        try {
            return $this->kernel->locateResource($fileToLocate);
        }
        catch (\Exception $e) {
            // The exception is silent
            return false;
        }
    }
}
