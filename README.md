view-model-bundle
=================

Bundle to add View Model capabilities to Symfony2

## Requirements

Requires 

* [composer](http://www.getcomposer.org/)
* `symfony/symfony >=2.3.0`

## Installation

In your project root:

```sh
composer require aequasi/view-model-bundle ~4.0.0
```

In your `app/AppKernel.php`

```php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Aequasi\Bundle\ViewModelBundle\AequasiViewModelBundle(),
    );
    // ...
}
```

## Usage

To make a view model, create a new class that implements the [`ViewModelInterface`][0]. 
There are some other classes in that namespace that make it easy to make your own view model. I heavily suggest extending the [`AbstractViewModel`][1].
There are also two classes in that namespace that extend the abstract class:

* [`HtmlViewModel`][2] - Sets a content type of `text/html` and doesnt do anything fancy to build the view
* [`JsonViewModel`][3] - Sets a content type of `application/json` and doesnt do anything fancy to build the view

Example:

```php
<?php

namespace Acme\DemoBundle\View\Index;

use Aequasi\Bundle\ViewModelBundle\View\Model\HtmlViewModel;

class IndexViewModel extends HtmlViewModel
{
  protected $template = 'AcmeDemoBundle:Index:index.html.twig';

  public function buildView($data)
  {
    // Do some stuff with data, and then return what you want in the view
    return $data; // Does this by default in the ViewModel
  }
}
```

You don't have to follow the same namespace structure, but it allows for a cleaner structure. This view model would be the view model for the IndexController's indexAction.

#### To Use the View Model

Use the [`@ViewModel`][4] Annotation in your action OR you can use the [`@ViewModelFactory`][5] Annotation:

```php

namespace Acme\DemoBundle\Controller;

use Aequasi\Bundle\ViewModelBundle\Annotation\ViewModel;
use Aequasi\Bundle\ViewModelBundle\Service\ViewModelService;
use Aequasi\Bundle\ViewModelBundle\Controller\ViewModelControllerInterface;

// Implementing thew ViewModelControllerInterface sets $this->view as an instance of the ViewModelService
class IndexController implements ViewModelControllerInterface 
{

  /**
   * @var ViewModelService
   */
  private $view;

  /**
   * @ViewModel("Acme\DemoBundle\View\Model\Index\IndexViewModel")
   * OR
   * @ViewModel("@some.service.name")
   * @ViewModelFactory("@service.id", {"argumentOne", "argumentTwo"}) // You can also use a class name. The arguments are for you to decide what view model to use
   */ 
  public function indexAction()
  {
    // Some stuff....
    // If you don't have the ViewModelControllerInterface implemented,
    // you will need to get the service
    // $this->view = $this->container->get('aequasi.view_model.service.view');
    
    $this->getView()->add('someParameter', 'someValue');
    return $this->getView()->render(/*$templatName, $response*/);
    
    // You can also not return anything and it will create the response for you
    // It will also let you return an array that gets set as your view parameters
    return array('someParameter', 'someValue');
  }
  
  public function setView(ViewModelService $service)
  {
    $this->view = $service;
  }
  
  public function getView()
  {
    return $this->view;
  }
}
```

###### A ViewModelFactory must implement [ViewModelFactoryInterface][6] and the create method must return a [ViewModelInterface][0].

[0]: https://github.com/aequasi/view-model-bundle/blob/master/src/Aequasi/Bundle/ViewModelBundle/View/Model/ViewModelInterface.php
[1]: https://github.com/aequasi/view-model-bundle/blob/master/src/Aequasi/Bundle/ViewModelBundle/View/Model/AbstractViewModel.php
[2]: https://github.com/aequasi/view-model-bundle/blob/master/src/Aequasi/Bundle/ViewModelBundle/View/Model/HtmlViewModel.php
[3]: https://github.com/aequasi/view-model-bundle/blob/master/src/Aequasi/Bundle/ViewModelBundle/View/Model/JsonViewModel.php
[4]: https://github.com/aequasi/view-model-bundle/blob/master/src/Aequasi/Bundle/ViewModelBundle/Annotation/ViewModel.php
[5]: https://github.com/aequasi/view-model-bundle/blob/master/src/Aequasi/Bundle/ViewModelBundle/Annotation/ViewModelFactory.php
[6]: https://github.com/aequasi/view-model-bundle/blob/master/src/Aequasi/Bundle/ViewModelBundle/Factory/ViewModelFactoryInterface.php
