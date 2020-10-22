# TehlaExtensionBundle :

## Installation :
`composer require tehla/sf-extension`


## Components :

### schema_filter :

Prevent doctrine modifications with `doctrine:schema:update` command on tables defined in `doctrine.dbal.schema_filter`

See https://symfony.com/doc/current/bundles/DoctrineBundle/configuration.html#doctrine-dbal-configuration

Example: 
````
doctrine:
    dbal:
        schema_filter: '/^((?!view_).)*$/'
````

To enable this feature in `services.yaml` : 
```
tehla_extension:
    component:
        schema_filter: true

```
### maker_twig:

Use twig templates with symfony maker :
 
```
tehla_extension:
    component:
        maker_twig: true
```

> Warning should appear during the making from your twig templates. You can ignore them.

### maker_generator:

The symfony maker bundle only generates classes into `src` folder with unwanted `App\` namespace.
You can now make your code anywhere in your project, 
by declaring the namespaces you want to host your generated code :

```
tehla_extension:
    component:
        maker_generator: 
            - My\NameSpace\Out\Of\Src
            - Other\Namespace
```

> This feature should only work with `Generator::generateFile()`, 
where you can specify the destination path of your generated code.  

> Warning should appear during the making from your twig templates. You can ignore them.
