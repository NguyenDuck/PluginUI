<?php
/**
███╗░░██╗░██████╗░██╗░░░██╗██╗░░░██╗███████╗███╗░░██╗██████╗░██╗░░░██╗░█████╗░██╗░░██╗
████╗░██║██╔════╝░██║░░░██║╚██╗░██╔╝██╔════╝████╗░██║██╔══██╗██║░░░██║██╔══██╗██║░██╔╝
██╔██╗██║██║░░██╗░██║░░░██║░╚████╔╝░█████╗░░██╔██╗██║██║░░██║██║░░░██║██║░░╚═╝█████═╝░
██║╚████║██║░░╚██╗██║░░░██║░░╚██╔╝░░██╔══╝░░██║╚████║██║░░██║██║░░░██║██║░░██╗██╔═██╗░
██║░╚███║╚██████╔╝╚██████╔╝░░░██║░░░███████╗██║░╚███║██████╔╝╚██████╔╝╚█████╔╝██║░╚██╗
╚═╝░░╚══╝░╚═════╝░░╚═════╝░░░░╚═╝░░░╚══════╝╚═╝░░╚══╝╚═════╝░░╚═════╝░░╚════╝░╚═╝░░╚═╝
 */
declare(strict_types=1);

namespace NguyenDuck\PluginUI;

use NguyenDuck\PluginUI\Main;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use jojoe77777\FormAPI\Form;
use function array_map;
use function count;
use function sort;
use const SORT_STRING;

class PluginForm extends Form
{
	public function __construct(?callable $callable, $sender) {
		parent::__construct($callable);
		$this->list = array_map(function(Plugin $plugin): string{
			return ($plugin->isEnabled() ? TextFormat::GREEN : TextFormat::RED) . $plugin->getDescription()->getFullName();
		}, $sender->getServer()->getPluginManager()->getPlugins());
		sort($this->list, SORT_STRING);
		$this->data["type"] = "form";
		$this->data["title"] = "Plugins(" . count($this->list) . "):";
		$this->data["content"] = "";
		for ($i=0; $i < count($this->list); $i++) { 
			$this->data["buttons"][$i] = ["text" => $this->list[$i]];
		}
	}
}