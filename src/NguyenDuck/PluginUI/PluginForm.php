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

use pocketmine\Server;
use pocketmine\utils\TextFormat;
use libs\jojoe77777\FormAPI\Form;
use function array_map;
use function count;
use function sort;
use const SORT_STRING;

class PluginForm extends Form
{
	public function __construct(?callable $callable, array $plugins) {
		parent::__construct($callable);
		sort($plugins, SORT_STRING);
		$this->data["type"] = "form";
		$this->data["title"] = (TextFormat::BOLD).(TextFormat::RED)."Plugins(" . count($plugins) . "):";
		$this->data["content"] = "";
		for ($i=0; $i < count($plugins); $i++) {
			$plugin = Server::getInstance()->getPluginManager()->getPlugin($plugins[$i]);
			$this->data["buttons"][$i] = ["text" => (TextFormat::BOLD).($plugin && $plugin->isEnabled() ? TextFormat::BLUE : TextFormat::RED).$plugin->getDescription()->getFullName()];
		}
	}
}