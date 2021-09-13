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

use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\lang\TranslationContainer;
use pocketmine\utils\TextFormat;
use jojoe77777\FormAPI\ModalForm;
use function array_map;
use function count;
use function implode;
use function sort;
use const SORT_STRING;

class PluginUICommand extends Command
{
	public $plugins;
	public function __construct(string $name) {
		parent::__construct(
			$name,
			"%pocketmine.command.plugins.description"." as UI",
			"%pocketmine.command.plugins.usage",
			["pl"]
		);
	}
	/**
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		$list = array_map(function(Plugin $plugin): string{
			return ($plugin->isEnabled() ? TextFormat::GREEN : TextFormat::RED) . $plugin->getDescription()->getFullName();
		}, $sender->getServer()->getPluginManager()->getPlugins());
		sort($list, SORT_STRING);

		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(new TranslationContainer("pocketmine.command.plugins.success", [count($list), implode(TextFormat::WHITE . ", ", $list)]));
			return true;
		}

		$this->plugins = array_map(function(Plugin $plugin): string{
			return $plugin->getDescription()->getName();
		}, $sender->getServer()->getPluginManager()->getPlugins());
		sort($this->plugins, SORT_STRING);

		$this->getForm($list)->sendToPlayer($sender);
		return true;
	}

	/** @return PluginForm */
	private function getForm(array $plugins): PluginForm {
		$form = new PluginForm(function(Player $player, $data) {
			$pluginForm = new PluginInfoForm(null, (!is_null($this->plugins[$data])?$this->plugins[$data]:"PluginUI"));
			$pluginForm->sendToPlayer($player);
		}, $plugins);
		return $form;
	}
}