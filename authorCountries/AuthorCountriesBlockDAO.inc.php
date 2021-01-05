<?php

/**
 * @file plugins/blocks/authorCountries/AuthorCountriesBlockDAO.inc.php
 *
 * Copyright (c) 2019 Gunali Rezqi Mauludi
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AuthorCountriesBlockDAO
 * @ingroup plugins_blocks_authorCountries
 *
 * @brief Class for country selector block plugin
 */

import('lib.pkp.classes.db.DBRowIterator');
class AuthorCountriesBlockDAO extends DAO {
	/**
	 * Get the author countries data.
	 * @param $contextId int Context ID
	 * @return array
	 */
	function getSummary($issueIdSegment) {
		$result = new DBRowIterator($this->retrieve(
			'SELECT
				authors.country AS country,
				COUNT(authors.country) AS author_total
			FROM
				published_submissions
			JOIN authors ON authors.submission_id = published_submissions.submission_id
			WHERE published_submissions.issue_id = '.$issueIdSegment.' AND authors.country != ""
			GROUP BY authors.country;'
		));

		$countryNames = json_decode(file_get_contents("http://country.io/names.json"), true);

		$author_total = 0;
		$data = array();
		while ($row = $result->next()) {
			$data[strtolower($row['country'])][0] = $countryNames[$row['country']];
			$data[strtolower($row['country'])][1] = $row['author_total'];
			$author_total = $author_total + $row['author_total'];
		}

		$result = array();
		$result['author_total'] = $author_total;
		$result['data'] = $data;

		return $result;
	}
}
