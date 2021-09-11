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

class Main extends PluginBase
{
	public function onEnable() {
		$this->unregister("plugins");
	}

	/**
	 * @param string
	 * @return void
	 */
	public function unregister(string ...$commands):void {
		$commandMap = $this->getServer()->getCommandMap();
		foreach ($commands as $command) {
			$command = $commandMap->getCommand($command);
			if (!is_null($command)) {
				$command->setLabel("§c".$command."_disabled");
				if ($commandMap->unregister($command)) {
					$this->getLogger()->notice("Disabled Command ".$command);
				}
			}
		}
	}
}
