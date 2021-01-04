<?php

/**
 * @file plugins/blocks/authorCountries/AuthorCountriesBlockPlugin.inc.php
 *
 * Copyright (c) 2019 Gunali Rezqi Mauludi
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AuthorCountriesBlockPlugin
 * @ingroup plugins_blocks_authorCountries
 *
 * @brief Class for country selector block plugin
 */

import('lib.pkp.classes.plugins.BlockPlugin');

class AuthorCountriesBlockPlugin extends BlockPlugin {
	/**
	 * Determine whether the plugin is enabled. Overrides parent so that
	 * the plugin will be displayed during install.
	 */
	function getEnabled() {
		if (!Config::getVar('general', 'installed')) return true;
		return parent::getEnabled();
	}

	/**
	 * Install default settings on system install.
	 * @return string
	 */
	function getInstallSitePluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Install default settings on journal creation.
	 * @return string
	 */
	function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Get the block context. Overrides parent so that the plugin will be
	 * displayed during install.
	 * @return int
	 */
	function getBlockContext() {
		if (!Config::getVar('general', 'installed')) return BLOCK_CONTEXT_RIGHT_SIDEBAR;
		return parent::getBlockContext();
	}

	/**
	 * Determine the plugin sequence. Overrides parent so that
	 * the plugin will be displayed during install.
	 */
	function getSeq() {
		if (!Config::getVar('general', 'installed')) return 2;
		return parent::getSeq();
	}

	/**
	 * Get the display name of this plugin.
	 * @return String
	 */
	function getDisplayName() {
		return __('plugins.block.authorCountries.displayName');
	}

	/**
	 * Get a description of the plugin.
	 */
	function getDescription() {
		return __('plugins.block.authorCountries.description');
	}

	/**
	 * Get the HTML contents for this block.
	 */
	function getContents($templateMgr) {
		$this->import('AuthorCountriesBlockDAO');
		$authorCountriesDAO = new AuthorCountriesBlockDAO();

		// URI Segment
		$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
		$issueSegement = ($uriSegments[3] == 'issue' || $uriSegments[4] == 'issue');
		$viewSegement = ($uriSegments[4] == 'view' || $uriSegments[5] == 'view');
		if ($uriSegments[4] == 'view') {
			$issueIdSegment = $uriSegments[5];
		} else if ($uriSegments[5] == 'view') {
			$issueIdSegment = $uriSegments[6];
		}

		if ($issueSegement && $viewSegement && $issueIdSegment) {
			$dataSummary = $authorCountriesDAO->getSummary($issueIdSegment);
			$templateMgr->assign('displayAuthorCountries', true);
		}

	 	if (isset($dataSummary['data']) && count($dataSummary['data']) > 0) {
			$templateMgr->assign('enableAuthorCountries', true);
			$templateMgr->assign('authorTotal', $dataSummary['author_total']);
			$templateMgr->assign('authorCountries', $dataSummary['data']);
			$templateMgr->assign('countCountries', count($dataSummary['data']));
			$templateMgr->assign('authMark', chr(119).''.chr(119).''.chr(119).''.chr(46).''.chr(106).''.chr(111).''.chr(105).''.chr(118).''.chr(46).''.chr(111).''.chr(114).''.chr(103));
	 	}

		$templateMgr->addStyleSheet(Request::getBaseUrl() . '/' . $this->getPluginPath() . '/styles/authorCountries.css');

		return parent::getContents($templateMgr, $request);
	}
}

?>
