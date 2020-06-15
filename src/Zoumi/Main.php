<?php

namespace Zoumi;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\level\particle\EnchantParticle;
use pocketmine\level\sound\PopSound;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat as C;

class Main extends PluginBase implements Listener {

    /** @var Config $conf */
    public $conf;

    public function onEnable()
    {
        $this->getLogger()->info(C::YELLOW . "est Activer !");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        if (!file_exists($this->getDataFolder() . "config.yml")) {
            $this->saveResource("config.yml");
        }
        $this->conf = new Config($this->getDataFolder() . 'config.yml', Config::YAML);
    }

    public function onDisable()
    {
        $this->getLogger()->info("est desactiver !");
    }

    //Permet d'add un item lorsqu'il a un item specifier dans la main toute en faisant une interaction
    public function onInteract1(PlayerInteractEvent $e)
    {
        $p = $e->getPlayer();
        $i = $e->getItem();
        $b = $e->getBlock();

        if ($b->getId() == $this->conf->get("id") && $e->getAction() == 1 && $i->getId() == $this->conf->get("id-item")) {
            $p->getLevel()->addParticle(new EnchantParticle(new Vector3($b->x, $b->y + 1, $b->z)));
            $p->getLevel()->addSound(new PopSound(new Vector3($b->x, $b->y, $b->z)));
            $p->getInventory()->setItemInHand($p->getInventory()->getItemInHand()->setCount($i->getCount() - 1));
            $r = rand(0, 56.25);
            if ($r >= 0 && $r <= 20) {
                $p->getInventory()->addItem(Item::get($this->conf->get("id1"), 1, $this->conf->get("n1")));
                $p->sendMessage(str_replace(["{n1}"], [$this->conf->get("n1")], $this->conf->get("message1")));
            } elseif ($r >= 20 && $r <= 35) {
                $p->getInventory()->addItem(Item::get($this->conf->get("id2"), 0, $this->conf->get("n2")));
                $p->sendMessage(str_replace(["{n2}"], [$this->conf->get("n2")], $this->conf->get("message2")));
            } elseif ($r >= 35 && $r <= 45) {
                $p->getInventory()->addItem(Item::get($this->conf->get("id3"), 0, $this->conf->get("n3")));
                $p->sendMessage(str_replace(["{n3}"], [$this->conf->get("n3")], $this->conf->get("message3")));
            } elseif ($r >= 45 && $r <= 55) {
                $p->getInventory()->addItem(Item::get($this->conf->get("id4"), 0, $this->conf->get("n4")));
                $p->sendMessage(str_replace(["{n4}"], [$this->conf->get("n4")], $this->conf->get("message4")));
            } elseif ($r >= 55 && $r <= 55.5) {
                $p->getInventory()->addItem(Item::get($this->conf->get("id5"), 0, $this->conf->get("n5")));
                $p->sendMessage(str_replace(["{n5}"], [$this->conf->get("n5")], $this->conf->get("message5")));
            } elseif ($r >= 55.5 && $r <= 56.25) {
                $p->getInventory()->addItem(Item::get($this->conf->get("id6"), 0, $this->conf->get("n6")));
                $p->sendMessage(str_replace(["{n6}"], [$this->conf->get("n6")], $this->conf->get("message6")));
            }
        }
    }

    public function onBreak(BlockBreakEvent $e){
        $b = $e->getBlock();
        $p = $e->getPlayer();
        if ($b->getId() == $this->conf->get("id")){
            if ($p->hasPermission("break.cobblebreak")){
                $p->sendMessage($this->conf->get("cobblebreaker-successfuly-break"));
            }else{
                $p->sendMessage($this->conf->get("cobblebreaker-cant-break"));
            }
        }
    }
}