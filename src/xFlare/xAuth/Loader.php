<?php

#Loader for xAuth, loads up everything.
namespace xFlare\xAuth;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
class Loader extends PluginBase implements Listener{
  public $loginmanager=array(); //Idividual player login statuses using arrays (sessions).
  public $chatprotection=array();
  public $proccessmanager=array();
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getServer()->getLogger()->info("§7> §3Starting up §ax§dAuth§7...§6Loading §edata§7.");
    $this->saveDefaultConfig();
    $this->provider = strtolower($this->getConfig()->get("autentication-type"));
    $this->status = null; //Keeps track of auth status.
    $this->memorymanagerdata = 0;
    $this->debug = $this->getConfig()->get("debug-mode");
    $this->checkForConfigErrors($this->getConfig()); //Will check for different config errors.
  }
  public function checkForConfigErrors($config){ //Will try to fix errors, and repair config to prevent erros further down.
    $errors = 0;
    if($this->provider !== "mysql" || $this->provider !== "yml"){
      $this->status = "failed";
      $this->getServer()->getLogger()->info("§7[§cError§7] §3Invaild §ax§dAuth §3provider§7!");
      $this->getServer()->shutdown();
    }
    if($this->getConfig()->get("database-checks") === true && $this->provider !== "mysql"){
      $this->getConfig()->set("data-checks", false);
      $this->getConfig()->save();
      $errors++;
    }
    if($this->getConfig()->get("cache-logins") === true && $this->provider !== "mysql"){
      $this->getConfig()->set("cache-logins", false);
      $this->getConfig()->save();
      $errors++;
    }
    if($this->getConfig()->get("cache-logins") === true && $this->getConfig()->get("enable-pass-changing") === true){
      $this->getConfig()->set("enable-pass-changing", false);
      $this->getConfig()->save();
      $errors++;
    }
    if($errors !== 0){
        $this->getConfig()->reload();
        $this->getServer()->getLogger()->info("§7[§cError§7] §3Invaild §ax§dAuth §3config data§7!");
        $this->getServer()->getLogger()->info("§7[§ax§dAuth§7] " . $errors . " §cerrors have been found§7.\n§3We tried to fix it§7, §3but just in case review your config settings§7!");
    }
    $this->status = "enabled"; //Assuming errors have been fixed.
    $this->getServer()->getPluginManager()->registerEvents(new LoginTasks($this), $this);
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new MemoryStatus($this), 60*20);
    if($this->getConfig()->get("database-checks") === true && $this->provider === "mysql"){
      $this->getServer()->getScheduler()->scheduleRepeatingTask(new ErrorChecks($this), 30*20);
    }
    $this->getServer()->getLogger()->info("§7> §ax§dAuth §3has been §aenabled§7.");
  }
}
    
