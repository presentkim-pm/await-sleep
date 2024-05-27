<?php

/**
 *
 *  ____                           _   _  ___
 * |  _ \ _ __ ___  ___  ___ _ __ | |_| |/ (_)_ __ ___
 * | |_) | '__/ _ \/ __|/ _ \ '_ \| __| ' /| | '_ ` _ \
 * |  __/| | |  __/\__ \  __/ | | | |_| . \| | | | | | |
 * |_|   |_|  \___||___/\___|_| |_|\__|_|\_\_|_| |_| |_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the MIT License. see <https://opensource.org/licenses/MIT>.
 *
 * @author       PresentKim (debe3721@gmail.com)
 * @link         https://github.com/PresentKim
 * @license      https://opensource.org/licenses/MIT MIT License
 *
 *   (\ /)
 *  ( . .) ♥
 *  c(")(")
 *
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace kim\present\awaitsleep;

use pocketmine\plugin\Plugin;
use pocketmine\scheduler\ClosureTask;
use SOFe\AwaitGenerator\Await;

/** Task based fake sleep for a given number of ticks */
function asleep(int $ticks) : \Generator{
    if(!AwaitSleep::isRegistered()){
        throw new \RuntimeException("await-sleep is not registered");
    }

    yield from AwaitSleep::sleep($ticks);
}

final class AwaitSleep{
    private static ?Plugin $plugin = null;

    /** Register await-sleep plugin */
    public static function register(Plugin $plugin) : void{
        self::$plugin = $plugin;
    }

    /** Unregister await-sleep plugin */
    public static function unregister() : void{
        self::$plugin = null;
    }

    /**
     * Check if await-sleep is registered
     *
     * @return bool is await-sleep registered
     */
    public static function isRegistered() : bool{
        return self::$plugin !== null;
    }

    /** Task based fake sleep for a given number of ticks */
    public static function sleep(int $ticks) : \Generator{
        if(self::$plugin === null){
            throw new \RuntimeException("await-sleep is not registered");
        }

        yield from Await::promise(static function($resolve) use ($ticks) : void{
            self::$plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(fn() => $resolve(null)), $ticks);
        });
    }
}
