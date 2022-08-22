<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" />
    </a>
</p>

<h1 align="center">Avis Vérifies (NetReviews) Plugin</h1>

<p align="center">Integrate AvisVérifiés (NetReviews) into Sylius.</p>
<p align="center">/!\ Currently in alpha /!\</p>

## Quickstart


```
$ composer require ikuzostudio/avis-verifies-plugin
```

Add plugin dependencies to your `config/bundles.php` file:

```php
return [
  // ...
  Ikuzo\SyliusAvisVerifiesPlugin\IkuzoSyliusAvisVerifiesPlugin::class => ['all' => true],
];
```

Import required config in your `config/packages/_sylius.yaml` file:

```yaml
# config/packages/_sylius.yaml

imports:
  ...
  - { resource: "@IkuzoSyliusAvisVerifiesPlugin/Resources/config/app/config.yaml"}
```


Extend your Order entity
```php
// [...]
use Sylius\Component\Core\Model\Order as BaseOrder;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesOrderInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesOrderTrait;

/**
 * @ORM\Table(name="sylius_order")
 * @ORM\Entity()
 */
class Order extends BaseOrder implements AvisVerifiesOrderInterface
{
    use AvisVerifiesOrderTrait;
}
```

Extend your Channel entity
```php
// [...]
use Sylius\Component\Core\Model\Channel as BaseChannel;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesChannelInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesChannelTrait;

/**
 * @ORM\Table(name="sylius_channel")
 * @ORM\Entity()
 */
class Channel extends BaseChannel implements AvisVerifiesChannelInterface
{
  use AvisVerifiesChannelTrait;
}
```

Import routes
```yaml
# config/routes.yaml
ikuzo_avis_verifies_plugin:
 resource: "@IkuzoSyliusAvisVerifiesPlugin/Resources/config/routing.yaml"
```

Update your database

```
$ bin/console doctrine:schema:update --force
```

Then configure your new Coliship gateway 

<img src="doc/config.png" />


