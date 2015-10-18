<?php

#Loader for xAuth, loads up everything.
namespace xFlare\FlareHub;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\Chest;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\math\Vector3;
use pocketmine\Server;
use pocketmine\command\CommandExecuter;
use pocketmine\entity\Entity;
use pocketmine\level\Level;
use pocketmine\tile\Sign;
public function onEnable(){
  public $loginmanager=array(); //Idividual player login statuses using arrays.
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->getServer()->getLogger()->info("§7> §3Starting up §ex§dAuth§7...§6Loading §edata§7.");
      $this->provider =  //Config get
      $this->status = //Config get
  }
}
    

