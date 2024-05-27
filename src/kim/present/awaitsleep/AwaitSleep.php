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
use pocketmine\scheduler\TaskScheduler;
use SOFe\AwaitGenerator\Await;

/** Task based fake sleep for a given number of ticks */
function asleep(int $ticks) : \Generator{
    if(!AwaitSleep::isRegistered()){
        throw new \RuntimeException("await-sleep is not registered");
    }

    yield from AwaitSleep::sleep($ticks);
}

final class AwaitSleep{
    private static ?TaskScheduler $scheduler = null;

    /** Register await-sleep scheduler from plugin */
    public static function register(Plugin $plugin) : void{
        self::$scheduler = $plugin->getScheduler();
    }

    /** Unregister await-sleep scheduler */
    public static function unregister() : void{
        self::$scheduler = null;
    }

    /**
     * Check if await-sleep scheduler is registered
     *
     * @return bool is await-sleep scheduler registered
     */
    public static function isRegistered() : bool{
        return self::$scheduler !== null;
    }

    /** Task based fake sleep for a given number of ticks */
    public static function sleep(int $ticks) : \Generator{
        if(self::$scheduler === null){
            throw new \RuntimeException("await-sleep is not registered");
        }

        yield from Await::promise(
            static fn($resolve) => self::$scheduler->scheduleDelayedTask(new ClosureTask($resolve), $ticks)
        );
    }
}
