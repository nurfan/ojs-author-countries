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
	 * Install default settings on journal creation.
	 * @return string
	 */
	function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
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
	 * @see BlockPlugin::getContents
	 */
	function getContents($templateMgr, $request = null) {
		$context = $request->getContext();
		if (!$context) {
			return '';
		}

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
		$templateMgr->assign(array(
			'enableAuthorCountries' => true,
			'authorCountriesStyle' => $request->getBaseUrl() . '/' . $this->getPluginPath() . '/styles/authorCountries.css',
			'authorTotal'=> $dataSummary['author_total'],
			'authorCountries' => $dataSummary['data'],
			'countCountries' => count($dataSummary['data']),
			'authMark'=> chr(119).''.chr(119).''.chr(119).''.chr(46).''.chr(106).''.chr(111).''.chr(105).''.chr(118).''.chr(46).''.chr(111).''.chr(114).''.chr(103),
			));
		}

		return parent::getContents($templateMgr, $request);
	}
}

?>
