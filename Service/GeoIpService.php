<?php
namespace Opinaia\GeoIpBundle\Service;

use GeoIp2\WebService\Client;
use Opinaia\GeoIpBundle\Entity\GeoIpInfoEntity;
use Exception;

/**
 * The Geolocalization Service
 */
class GeoIpService {

    protected $container;

    /**
    * Constructor
    */
    public function __construct($container) {

        $this->container = $container;
        // Load the array to translate countries isoCode2 to isoCode3
        $this->IsoCodeCountries = array (
                "AD" => "AND",
                "AE" => "ARE",
                "AF" => "AFG",
                "AG" => "ATG",
                "AI" => "AIA",
                "AL" => "ALB",
                "AM" => "ARM",
                "AO" => "AGO",
                "AQ" => "ATA",
                "AR" => "ARG",
                "AS" => "ASM",
                "AT" => "AUT",
                "AU" => "AUS",
                "AW" => "ABW",
                "AX" => "ALA",
                "AZ" => "AZE",
                "BA" => "BIH",
                "BB" => "BRB",
                "BD" => "BGD",
                "BE" => "BEL",
                "BF" => "BFA",
                "BG" => "BGR",
                "BH" => "BHR",
                "BI" => "BDI",
                "BJ" => "BEN",
                "BL" => "BLM",
                "BM" => "BMU",
                "BN" => "BRN",
                "BO" => "BOL",
                "BQ" => "BES",
                "BR" => "BRA",
                "BS" => "BHS",
                "BT" => "BTN",
                "BV" => "BVT",
                "BW" => "BWA",
                "BY" => "BLR",
                "BZ" => "BLZ",
                "CA" => "CAN",
                "CC" => "CCK",
                "CD" => "COD",
                "CF" => "CAF",
                "CG" => "COG",
                "CH" => "CHE",
                "CI" => "CIV",
                "CK" => "COK",
                "CL" => "CHL",
                "CM" => "CMR",
                "CN" => "CHN",
                "CO" => "COL",
                "CR" => "CRI",
                "CU" => "CUB",
                "CV" => "CPV",
                "CW" => "CUW",
                "CX" => "CXR",
                "CY" => "CYP",
                "CZ" => "CZE",
                "DE" => "DEU",
                "DJ" => "DJI",
                "DK" => "DNK",
                "DM" => "DMA",
                "DO" => "DOM",
                "DZ" => "DZA",
                "EC" => "ECU",
                "EE" => "EST",
                "EG" => "EGY",
                "EH" => "ESH",
                "ER" => "ERI",
                "ES" => "ESP",
                "ET" => "ETH",
                "FI" => "FIN",
                "FJ" => "FJI",
                "FK" => "FLK",
                "FM" => "FSM",
                "FO" => "FRO",
                "FR" => "FRA",
                "GA" => "GAB",
                "GB" => "GBR",
                "GD" => "GRD",
                "GE" => "GEO",
                "GF" => "GUF",
                "GG" => "GGY",
                "GH" => "GHA",
                "GI" => "GIB",
                "GL" => "GRL",
                "GM" => "GMB",
                "GN" => "GIN",
                "GP" => "GLP",
                "GQ" => "GNQ",
                "GR" => "GRC",
                "GS" => "SGS",
                "GT" => "GTM",
                "GU" => "GUM",
                "GW" => "GNB",
                "GY" => "GUY",
                "HK" => "HKG",
                "HM" => "HMD",
                "HN" => "HND",
                "HR" => "HRV",
                "HT" => "HTI",
                "HU" => "HUN",
                "ID" => "IDN",
                "IE" => "IRL",
                "IL" => "ISR",
                "IM" => "IMN",
                "IN" => "IND",
                "IO" => "IOT",
                "IQ" => "IRQ",
                "IR" => "IRN",
                "IS" => "ISL",
                "IT" => "ITA",
                "JE" => "JEY",
                "JM" => "JAM",
                "JO" => "JOR",
                "JP" => "JPN",
                "KE" => "KEN",
                "KG" => "KGZ",
                "KH" => "KHM",
                "KI" => "KIR",
                "KM" => "COM",
                "KN" => "KNA",
                "KP" => "PRK",
                "KR" => "KOR",
                "XK" => "XKX",
                "KW" => "KWT",
                "KY" => "CYM",
                "KZ" => "KAZ",
                "LA" => "LAO",
                "LB" => "LBN",
                "LC" => "LCA",
                "LI" => "LIE",
                "LK" => "LKA",
                "LR" => "LBR",
                "LS" => "LSO",
                "LT" => "LTU",
                "LU" => "LUX",
                "LV" => "LVA",
                "LY" => "LBY",
                "MA" => "MAR",
                "MC" => "MCO",
                "MD" => "MDA",
                "ME" => "MNE",
                "MF" => "MAF",
                "MG" => "MDG",
                "MH" => "MHL",
                "MK" => "MKD",
                "ML" => "MLI",
                "MM" => "MMR",
                "MN" => "MNG",
                "MO" => "MAC",
                "MP" => "MNP",
                "MQ" => "MTQ",
                "MR" => "MRT",
                "MS" => "MSR",
                "MT" => "MLT",
                "MU" => "MUS",
                "MV" => "MDV",
                "MW" => "MWI",
                "MX" => "MEX",
                "MY" => "MYS",
                "MZ" => "MOZ",
                "NA" => "NAM",
                "NC" => "NCL",
                "NE" => "NER",
                "NF" => "NFK",
                "NG" => "NGA",
                "NI" => "NIC",
                "NL" => "NLD",
                "NO" => "NOR",
                "NP" => "NPL",
                "NR" => "NRU",
                "NU" => "NIU",
                "NZ" => "NZL",
                "OM" => "OMN",
                "PA" => "PAN",
                "PE" => "PER",
                "PF" => "PYF",
                "PG" => "PNG",
                "PH" => "PHL",
                "PK" => "PAK",
                "PL" => "POL",
                "PM" => "SPM",
                "PN" => "PCN",
                "PR" => "PRI",
                "PS" => "PSE",
                "PT" => "PRT",
                "PW" => "PLW",
                "PY" => "PRY",
                "QA" => "QAT",
                "RE" => "REU",
                "RO" => "ROU",
                "RS" => "SRB",
                "RU" => "RUS",
                "RW" => "RWA",
                "SA" => "SAU",
                "SB" => "SLB",
                "SC" => "SYC",
                "SD" => "SDN",
                "SS" => "SSD",
                "SE" => "SWE",
                "SG" => "SGP",
                "SH" => "SHN",
                "SI" => "SVN",
                "SJ" => "SJM",
                "SK" => "SVK",
                "SL" => "SLE",
                "SM" => "SMR",
                "SN" => "SEN",
                "SO" => "SOM",
                "SR" => "SUR",
                "ST" => "STP",
                "SV" => "SLV",
                "SX" => "SXM",
                "SY" => "SYR",
                "SZ" => "SWZ",
                "TC" => "TCA",
                "TD" => "TCD",
                "TF" => "ATF",
                "TG" => "TGO",
                "TH" => "THA",
                "TJ" => "TJK",
                "TK" => "TKL",
                "TL" => "TLS",
                "TM" => "TKM",
                "TN" => "TUN",
                "TO" => "TON",
                "TR" => "TUR",
                "TT" => "TTO",
                "TV" => "TUV",
                "TW" => "TWN",
                "TZ" => "TZA",
                "UA" => "UKR",
                "UG" => "UGA",
                "UM" => "UMI",
                "US" => "USA",
                "UY" => "URY",
                "UZ" => "UZB",
                "VA" => "VAT",
                "VC" => "VCT",
                "VE" => "VEN",
                "VG" => "VGB",
                "VI" => "VIR",
                "VN" => "VNM",
                "VU" => "VUT",
                "WF" => "WLF",
                "WS" => "WSM",
                "YE" => "YEM",
                "YT" => "MYT",
                "ZA" => "ZAF",
                "ZM" => "ZMB",
                "ZW" => "ZWE",
                "CS" => "SCG",
                "AN" => "ANT"
                );
    }


    /**
     * Finds the localization from the MaxMind GeoIp2 web service.
     * @param the ip.
     * Return Opinaia\GeoIpBundle\Entity\GeoIpInfoEntity.
     */

    public function getInfoFromIp($ip) {

        $userId = $this->container->getParameter('opinaia_geo_ip.user_id');
        if ($userId === "") {
            throw new Exception ("GeoIpService getInfoFromIP - Not opinaia_geo_ip.user_id defined. MUST be defined to be able to use Maxmind web service.");
        }
        $apiKey = $this->container->getParameter('opinaia_geo_ip.api_key');
        if ($apiKey === "") {
            throw Exception ("GeoIpService getInfoFromIP - Not opinaia_geo_ip.user_id defined. MUST be defined to be able to use Maxmind web service.");
        }

        try {
            $client = new Client($userId, $apiKey);
            $record = $client->city($ip);
            $geoipinfo = new GeoIpInfoEntity($record, $this->translateIsoCode2to3($record->country->isoCode));

            return $geoipinfo;
        } catch (Exception $e) {
            throw new Exception ("GeoIpService getInfoFromIP - ".$e->getMessage());
        }
    }

    /**
     * Translate country ISO 3166-1 alpha-2 (two chars) to ISO 3166-1 alpha-3 (3 chars)
     */
    public function translateIsoCode2to3($isoCode2){

        if (isset($this->IsoCodeCountries[$isoCode2])){
            return $this->IsoCodeCountries[$isoCode2];
        } else {
            return "";
        }
    }

    /**
     * Finds the localization from the MaxMind GeoIp legacy web service.
     * @param the ip.
     * Return Array.
     */

    public function getInfoFromIpLegacy($ip) {
        try {
            $url =self::URL.$ip;

            $curl = curl_init();

            curl_setopt_array( $curl,
                               array(
                                     CURLOPT_URL => $url,
                                     CURLOPT_USERAGENT => '',
                                     CURLOPT_RETURNTRANSFER => true,
                                     CURLOPT_SSL_VERIFYPEER => false,
                                     CURLOPT_SSL_VERIFYHOST => 2
                                     )
                               );

            $resp = curl_exec($curl);

            if (curl_errno($curl)) {
                throw new \Exception('GeoIP Request Failed');
            }

            $values = str_getcsv($resp);

            $countryCode = $values[self::COUNTRY];
            $regionCode = $values[self::REGION];
            $cityName = $values[self::CITY];

            var_dump($values);
        } catch (\Exception $e) {
            $localization = null;
        }
        return $localization;
    }
}
?>