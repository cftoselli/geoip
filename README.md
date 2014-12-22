Opinaia GeoIp Bundle Install
============================

1) Modify composer.json:

    [...]
    "require" : {
        [...]
        "opinaia/geoipbundle": "dev-master"
    },
    "repositories" : [{
        "type" : "vcs",
        "url" : "git@github.com:cftoselli/geoip.git"
    }],
    [...]


2) Execute update on composer:

php composer.phar update company/demobundle


3) Modify app/AppKernel to use the bundle:

        [...]
        $bundles = array(
            [...]
            new Opinaia\GeoIpBundle\OpinaiaGeoIpBundle(),
        );
        [...]

4) Append to config.yml to use the user id and the api key provided by Maxmind:

[...]
opinaia_geo_ip:
    user_id: 12345
    api_key: 'xZxZxZxZxZxZ'

5) Enjoy!

Example:
--------

From a controller:

$geoipService = $this->get('opinaia_geo_ip');

$geoipService->translateIsoCode2to3("AR");
(Returns: "ARG")

$result = $geoipService->getInfoFromIp("200.110.219.82");

$result->getCountryIsoCode2();  --> "AR"

$result->getCountryIsoCode3();  --> "ARG"

$result->getCityName();         --> "Vicente Lopez"

$result->getRegionName();       --> "Buenos Aires"

$result->getCountryName();      --> "Argentina"

$result->getQueriesRemain();    --> 53433 (How many consults to Maxmind are left)
