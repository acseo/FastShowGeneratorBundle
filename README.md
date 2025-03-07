ACSEOFastShowGeneratorBundle
----------------------------

ACSEOFastShowGeneratorBundle allows to quickly generate show actions based on annotation or yaml
This bundle was initiated by Nicolas Kern ([ACSEO](http://www.acseo-conseil.fr)).

**Version**: 2.0
**Compatibility**: Symfony ^5.0 || ^6.0

## Installation using Composer

``` bash
$ composer install acseo/fast-show-generator-bundle
```

Composer will install the bundle to your project's `vendor/ACSEO` directory.

## How To Use

#### Annotation

In entity :
```php
use ACSEO\FastShowGeneratorBundle\Annotations as ACSEOFastShowGeneratorBundle;
```

For each property :
```php
* @ACSEOFastShowGenerator\Show(label="My Property 1", show=true, groups={"default"})
```

In controller :
```php
$fastShow = $this->get('acseo_fast_show_generator.driver.annotation');

$fastShow->setEntity(new MyEntity());
$fastShow->setGroup('default');
$fastShow->setClassMetadata($em->getClassMetadata("ACSEOMyBundle:MyEntity"));

$fastShowData = $fastShow->getShowableData();
```

#### YAML :

Create the a file in your bundle for each entity :
```js
#ACSEO/Bundle/MyBundle/Resources/config/fastshowgenerator/MyEntity.default.fastshowgenerator.yml

ACSEO\Bundle\MyBundle\Entity\MyEntity:
    Columns:
        myProperty:
            label: My Property 1
            show: true
            groups: {"default"}
        myProperty2:
            label: My Property 2
            show: true
            groups: {"default"}
```
In controller :
```php
        $fastShow = $this->get('acseo_fast_show_generator.driver.yaml');

        $fastShow->setEntity($entity);
        $fastShow->setGroup('default');
        $fastShow->setClassMetadata($em->getClassMetadata($this->getEntityName()));

        $fastShowData = $fastShow->getShowableData();
```

## Available options :
    label : string - optional - if not set, uses the property name capitalized
    show : boolean - optional - if not set, value is assumed to be true
    groups : array - optional - if not set, group name is "default"

## Template

Now, in your twig file, something like that :
```html
    <table class="table table-striped">
      <tbody>
        {% for propertyName, propertyValue in data %}
            <tr><td>{{ propertyName }}</td><td>{{ propertyValue }}</td></tr>
        {% endfor %}
      </tbody>
    </table>
```
