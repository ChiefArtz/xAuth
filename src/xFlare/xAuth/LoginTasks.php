<?php

#Stops people from doing stuff, when not logged in.
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
class Loader extends PluginBase implements Listener{
