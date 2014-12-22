<?php
namespace Opinaia\Bundle\GeoIpBundle\Entity;

use Exception;

/**
 * Class for managing the info result from the geoip web service
 */
class GeoIpInfoEntity
{
    /**
     * Contains the record returned of executing Maxmind city web service
     *
     * @var GeoIp2\Model\City
     */
    protected $cityGeoIp;

    /**
     * Contains the Code ISO 3166-1 alpha-3 of the country
     * @var String
     */
    protected $isoCode3;

    public function __construct($record, $isoCode3)
    {
    	/**
    	 * $record must be the result of executing Maxmind city web service
    	 */
    	try{
	    	if (get_class($record) !== "GeoIp2\Model\City") {
	    		throw new Exception("GeoIpInfoEntity construct - Unsupported class given: ".get_class($record));
	    	}
	        $this->cityGeoIp = $record;
	        $this->isoCode3 = $isoCode3;
        } catch (Exception $e) {
	    		throw new Exception("GeoIpInfoEntity construct - Unsupported class given: ".get_class($record));
        }
    }

    /**
     * Returns the ISO 3166-1 alpha-2 (two chars) of a country
     * @return String
     */
    public function getCountryIsoCode2(){

    	return $this->cityGeoIp->country->isoCode;
    }

    /**
     * Returns the ISO 3166-1 alpha-3 (three chars) of a country
     * @return String
     */
    public function getCountryIsoCode3(){

    	return $this->isoCode3;
    }

    /**
     * Returns the city name
     * @return String
     */
    public function getCityName(){

    	return $this->cityGeoIp->city->name;
    }

    /**
     * Returns the region name
     * @return String
     */
    public function getRegionName(){

		return $this->cityGeoIp->mostSpecificSubdivision->name;
    }

    /**
     * Returns the country name
     * @return String
     */
    public function getCountryName(){

    	return $this->cityGeoIp->country->name;
    }

    /**
     * Returns the quantity of available querys left to use
     * @return Integer
     */
    public function getQueriesRemain(){

    	return $this->cityGeoIp->maxmind->queriesRemaining;
    }
}