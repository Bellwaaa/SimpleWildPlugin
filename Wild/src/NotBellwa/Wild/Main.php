<?php
declare(strict_types=1);
namespace NotBellwa\Wild;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;
use pocketmine\math\Vector3;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\entity\Entity;

class Main extends PluginBase implements Listener {

    public $noFallPlayers = [];

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($command->getName() == "wild") {
            if (!$sender instanceof Player) {
                $sender->sendMessage("You do not have permission to execute this command, Please do it in-game");
                return false;

            } else {

                if ($sender->hasPermission("wild.command")) {
                    if ($sender instanceof Player) {
                        $sender->addTitle(C::GREEN . "Teleporting....");
                        $x = rand(-1000, 1000);
                        $y = 145;
                        $z = rand(-1000, 1000);
                        $sender->teleport(new Vector3($x, $y, $z));
                        $sender->sendMessage(C::DARK_RED . "You have been teleported to " . C::DARK_RED . "$x, $y, $z");

                    }

                } else {
                    $sender->sendMessage(C::GREEN . "No Perms");
                }
                return true;
            }
        }
    }
    public function EntityDamageEvent(EntityDamageEvent $event):void {
        $entity = $event->getEntity();
        if(!$entity instanceof Player) return;
        if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
            $event->setCancelled(true);
            unset($this->noFallPlayers[$entity->getId()]);
        }
    }
}