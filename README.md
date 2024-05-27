<!-- PROJECT BADGES -->
<div align="center">

[![Poggit CI][poggit-ci-badge]][poggit-ci-url]
[![Stars][stars-badge]][stars-url]
[![License][license-badge]][license-url]

</div>

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <img src="https://raw.githubusercontent.com/presentkim-pm/await-sleep/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  <h3>await-sleep</h3>
  <p align="center">
    Provides a fake asleep() function for await-generator!

[View in Poggit][poggit-ci-url] · [Report a bug][issues-url] · [Request a feature][issues-url]

  </p>
</div>


<!-- ABOUT THE PROJECT -->

## About The Project

:heavy_check_mark: Register plugin to virion

- `kim\present\awaitsleep\AwaitCommand`

:heavy_check_mark: Provides implementation versions of PluginOwned!

- `kim\present\awaitsleep\AwaitPluginCommand`

-----

## Installation

See [Official Poggit Virion Documentation](https://github.com/poggit/support/blob/master/virion.md)

-----

## How to use?

First. register the plugin to virion for using task handler.

```php
use kim\present\awaitsleep\AwaitSleep;
use pocketmine\plugin\PluginBase;

class TestPlugin extends PluginBase {
    public function onLoad() : void{
        AwaitSleep::register($this);
    }
}
```

Second. use `AwaitSleep::sleep(int $ticks)`!

```php
use kim\present\awaitsleep\AwaitSleep;
use pocketmine\plugin\PluginBase;
use SOFe\AwaitGenerator\Await;

class TestPlugin extends PluginBase {
    public function onLoad() : void{
        AwaitSleep::register($this);
    }
    
    public function onEnable() : void{
        Await::g2c($this->test());
    }
    
    public function test() : \Generator{
        $this->getLogger()->info("Start");
        yield from AwaitSleep::sleep(20);
        $this->getLogger()->info("End");
    }
}
```

Third. use `asleep(int $ticks)` instead of `Await::sleep(int $ticks)`!

```php
use kim\present\awaitsleep\AwaitSleep;
use pocketmine\plugin\PluginBase;
use SOFe\AwaitGenerator\Await;

use function kim\present\awaitsleep\asleep;

class TestPlugin extends PluginBase {
    public function onLoad() : void{
        AwaitSleep::register($this);
    }
    
    public function onEnable() : void{
        Await::g2c($this->test());
    }
    
    public function test() : \Generator{
        $this->getLogger()->info("Start");
        yield from asleep(20);
        $this->getLogger()->info("End");
    }
}
```

-----

## License

Distributed under the **MIT**. See [LICENSE][license-url] for more information


[poggit-ci-badge]: https://poggit.pmmp.io/ci.shield/presentkim-pm/await-sleep/await-sleep?style=for-the-badge

[stars-badge]: https://img.shields.io/github/stars/presentkim-pm/await-sleep.svg?style=for-the-badge

[license-badge]: https://img.shields.io/github/license/presentkim-pm/await-sleep.svg?style=for-the-badge

[poggit-ci-url]: https://poggit.pmmp.io/ci/presentkim-pm/await-sleep/await-sleep

[stars-url]: https://github.com/presentkim-pm/await-sleep/stargazers

[issues-url]: https://github.com/presentkim-pm/await-sleep/issues

[license-url]: https://github.com/presentkim-pm/await-sleep/blob/main/LICENSE

[project-icon]: https://raw.githubusercontent.com/presentkim-pm/await-sleep/main/assets/icon.png
