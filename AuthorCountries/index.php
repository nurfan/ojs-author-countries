<?php
/**
 * @defgroup plugins_blocks_authorCountries Author Countries Block Plugin
 */

/**
 * @file plugins/blocks/authorCountries/index.php
 *
 * Copyright (c) 2019 Gunali Rezqi Mauludi
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_blocks_authorCountries
 * @brief Wrapper for country selector block plugin.
 *
 */

require_once('AuthorCountriesBlockPlugin.inc.php');

return new AuthorCountriesBlockPlugin();

?>
