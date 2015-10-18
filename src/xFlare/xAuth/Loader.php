<?php

#Loader for xAuth, loads up everything.
namespace xFlare\FlareHub;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
public function onEnable(){
    public $loginmanager=array(); //Idividual player login statuses using arrays (sessions).
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getServer()->getLogger()->info("§7> §3Starting up §ex§dAuth§7...§6Loading §edata§7.");
    $this->saveDefaultConfig();
    $this->provider = strtolower($this->getConfig()->get("autentication-type"));
    $this->status = null; //Keeps track of auth status.
    $this->debug = $this->getConfig()->get("debug-mode");
  }
}
    

