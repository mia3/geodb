<?php
namespace Mia3\GeoDb;

class GeoDb {
	/**
	 * @var \SQLite3
	 */
	protected static $connection;

	public static function initialize() {
		if (static::$connection !== NULL) {
			return;
		}
		static::$connection = new \SQLite3(__DIR__ . '/../geodb.sqlite');
	}

	public static function findByPostalCode($postalCode, $countryCode) {
		static::initialize();
		$query = 'SELECT * FROM geodb WHERE postalCode = "' . $postalCode . '"';
		if ($countryCode !== NULL) {
			$query.= ' AND countryCode = "' . $countryCode . '"';
		}

		$result = static::$connection->query($query);
		if ($result instanceof \SQLite3Result) {
			return $result->fetchArray(SQLITE3_ASSOC);
		}

		return array();
	}
}
