<?php
/*
                            _     _     
            /\             | |   | |    
 __  __    /  \     _   _  | |_  | |__  
 \ \/ /   / /\ \   | | | | | __| | '_ \ 
  >  <   / ____ \  | |_| | | |_  | | | |
 /_/\_\ /_/    \_\  \__,_|  \__| |_| |_|
                                        
                                        */


#Loader for xAuth, loads up everything.
namespace xFlare\xAuth;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;

class Loader extends PluginBase implements Listener{
  public $loginmanager = []; //Idividual player login statuses using arrays (sessions).
  public $chatprotection = [];
  public $proccessmanager = [];
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->version = "1.0.0";
    $this->codename = "xFlaze";
    $this->getServer()->getLogger()->info("§7[§axAuth§7] §6Starting up §axAuth $this->version ($this->codename)§7.");
    $this->saveDefaultConfig();
    $this->provider = strtolower($this->getConfig()->get("autentication-type"));
    $this->status = null; //Keeps track of auth status.
    $this->memorymanagerdata = 0;
    $this->debug = true; //$this->getConfig()->get("debug-mode");
    $this->totalerrors = 0;
    $this->checkForConfigErrors(0);
    $this->async = $this->getConfig()->get("use-async");
    if($this->debug === true){
      $this->getServer()->getLogger()->info("§7[§axAuth§7] §3Logger file has been created.");
      $this->xauthlogger = new Config($this->getDataFolder() . "authlogger.txt", Config::ENUM, array()); //Log errors
    }
    if($this->async !== true || $this->async !== false){
      $this->totalerrors++;
      $this->async = false;
    }
    if($this->async !== true && $this->status !== "enabled" && $this->provider === "mysql"){
    // $this->database = mysql; Later.
    }
  }
  /*
  - Status "failed" means plugin is disabled.
  - Status "enabled" means plugin has successfuly started, and is running.
  - Status "null" means that plugin is starting up.
  */
  public function onDisable(){
    if($this->status === "enabled" && $this->debug === true && $this->totalerrors !== 0){
      $this->getServer()->getLogger()->info("§7[§axAuth§7] §3Total errors during session§7:§c $this->totalerrors");
    }
    if($this->safemode === true){
      //Set config data.
      if($this->status === "enabled" && $this->safemode === true){
        //Insert all data to config
      }
    }
  }
  public function checkForConfigErrors($status){ //Will try to fix errors, and repair config to prevent erros further down.
    $errors = 0;
    if($this->getConfig()->get("version") !== $this->version){
      $this->status = "failed";
      $this->getServer()->getLogger()->info("§7[§eException§7] §3Updating config...xAuth will be enabled soon...§7.");
      $myoptions=array();
      array_push($myoptions, $this->provider); //Push old data so it can be inserted in new config.
      $this->updateConfig($myoptions);
      return;
    }
    if($this->provider !== "mysql" && $this->provider !== "yml"){
      $this->status = "failed";
      $this->getServer()->getLogger()->info("§7[§cError§7] §3Invaild §ax§dAuth §3provider§7!");
      $this->getServer()->shutdown();
    }
    if($this->getConfig()->get("database-checks") === true && $this->provider !== "mysql"){
      $this->getConfig()->set("data-checks", false);
      $this->getConfig()->save();
      $errors++;
    }
    $this->registerConfigOptions();
    $this->getServer()->getPluginManager()->registerEvents(new LoginTasks($this), $this);
    $this->getServer()->getPluginManager()->registerEvents(new LoginAndRegister($this), $this);
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new MemoryStatus($this), 60*20);
    if($this->getConfig()->get("database-checks") === true){
      $this->getServer()->getScheduler()->scheduleRepeatingTask(new ErrorChecks($this), 30*20);
    }
    if($this->provider === "yml"){
      $this->registered = new Config($this->getDataFolder() . "registered.txt", Config::ENUM, array());
    }
    if($this->getConfig()->get("hotbar-message") === true){
      $this->getServer()->getScheduler()->scheduleRepeatingTask(new AuthMessage($this), 20);
    }
    if($this->api === true){ //Register API :)
      $this->getServer()->getPluginManager()->registerEvents(new API($this), $this);
    }
    if($status === 1){
      $this->getServer()->getLogger()->info("§7> §ax§dAuth §3config has been updated too $this->version§7.");
    }
    if($this->logger !== true && $this->debug !== false){
      $this->getConfig()->set("log-xauth", true);
      $this->getConfig()->save();
      $errors++;
    }
    $this->totalerrors = $this->totalerrors + $errors;
    if($errors !== 0 || $this->totalerrors !== 0){
        $this->getConfig()->reload();
        $this->getServer()->getLogger()->info("§7[§ax§dAuth§7] " . $this->totalerrors . " §cerrors have been found§7.\n§3We tried to fix it§7, §3but just in case review your config settings§7!");
    }
    if($this->status === null){
      $this->status = "enabled";
      $this->getServer()->getLogger()->info("§7> §axAuth §3has been §aenabled§7.");
    }
    elseif($this->status !== null){
      $this->status = "failed";
      $this->getServer()->getLogger()->info("§7> §axAuth §3has failed to start up§7. (§c Error: $this->status §7)");
    }
  }
  public function updateConfig($myoptions){
    if($this->debug){
      var_dump($myoptions);
    }
    if($this->version !== $this->getConfig()->get("version")){
      $this->getServer()->getLogger()->info("§7[§axAuth§7] §3Updating xAuth config to $this->version...");
      $this->getConfig()->set("version", $this->version);
      $this->getConfig()->save();
      $this->checkForConfigErrors(1); //Recheck for errors since the proccess was stoped to update it.
    }
    else{
      $this->getServer()->getLogger()->info("§7[§cError§7] §3xAuth called config update on null.");
      $this->totalerrors++;
    }
  }
  public function registerConfigOptions(){ //Config -> Object for less lag.
    $this->allowMoving = $this->getConfig()->get("allow-moving");
    $this->allowPlace = $this->getConfig()->get("allow-block-placing");
    $this->allowBreak = $this->getConfig()->get("allow-block-breaking");
    $this->allowCommand = $this->getConfig()->get("allow-commands");
    $this->simplepassword = $this->getConfig()->get("simple-passcode-blocker");
    $this->safemode = $this->getConfig()->get("safe-mode");
    $this->logger = $this->getConfig()->get("log-xauth");
    $this->api = $this->getConfig()->get("enable-api");
    if($this->safemode !== true && $this->safemode !== false || $this->simplepassword !== true && $this->simplepassword !== false || $this->allowMoving !== true && $this->allowMoving !== false || $this->allowPlace !== true && $this->allowPlace !== false || $this->allowBreak !== true && $this->allowBreak !== false || $this->allowCommand !== true && $this->allowCommand !== false || $this->debug !== false && $this->debug !== true){
      $this->getServer()->getLogger()->info("§7[§axAuth§7] §3Config to object conversion failed, please make sure you configure the config properly!");
      $this->status = "failed";
      $this->totalerrors++;
    }
    if($this->logger === true){
      $this->getServer()->getLogger()->info("§7[§axAuth§7] §3Logger is enabled.");
    }
    elseif($this->debug === true){
      $this->getServer()->getLogger()->info("§7[§axAuth-Debug§7] §3Config options have been registered.");
    }
  }
}
    
