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

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase
{
	public function onEnable() {
		if (!$this->getServer()->getPluginManager()->getPlugin("FormAPI")) {
			$this->getLogger()->critical(TextFormat::RED."FormAPI Plugin Not Found!");
			$this->getServer()->getPluginManager()->disablePlugin($this);
		} else {
			$this->unregister("plugins");
			$this->registerPluginCommand();
		}
	}

	/**
	 * @param string $commands
	 */
	public function unregister(string ...$commands) {
		$commandMap = $this->getServer()->getCommandMap();
		foreach ($commands as $command) {
			$command = $commandMap->getCommand($command);
			if (!is_null($command)) {
				$command->setLabel("§c".$command."_disabled");
				$commandMap->unregister($command);
			}
		}
	}

	public function registerPluginCommand() {
		$this->getServer()->getCommandMap()->register("pocketmine", new PluginUICommand("plugins"));
	}
}
