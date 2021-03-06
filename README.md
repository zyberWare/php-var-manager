zyberware/var-manager
===========
VarManager provides an easy way to save variables with getter- and setter-methods.

Example
-------

```php
$vars = new \ZyberWare\VarManager();
$vars->setDay('Friday');
$vars->setConfig('main', $mainConfig);
$vars->setConfig('db', $dbConfig);

var_dump(
    $vars->getDay(),
    $vars->getConfig('main'),
    $vars->getConfig('db')
);
```

Documentation
-------------
To create the docs, just run `phpdoc` in the the project-root.
An online-version is available at [phpdoc.zyberware.org/var-manager/](http://phpdoc.zyberware.org/var-manager/).

License
-------
This software is licensed under the [Mozilla Public License v. 2.0](http://mozilla.org/MPL/2.0/). For more information, read the file `LICENSE`.