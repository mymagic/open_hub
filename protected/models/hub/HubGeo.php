<?php
/**
* NOTICE OF LICENSE.
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
*
* @see https://github.com/mymagic/open_hub
*
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/
class HubGeo
{
    public static function geocoder2AddressParts($geocoder)
    {
        if (!empty($geocoder) && !empty($geocoder->first())) {
            $result['line1'] = sprintf('%s %s', $geocoder->first()->getStreetNumber(), $geocoder->first()->getStreetName());
            $result['line2'] = sprintf('%s', $geocoder->first()->getSubLocality());
            $result['city'] = sprintf('%s', $geocoder->first()->getLocality());
            $result['zipcode'] = sprintf('%s', $geocoder->first()->getPostalCode());
            $result['state'] = !empty($geocoder->first()->getAdminLevels()->first()) ? $geocoder->first()->getAdminLevels()->first()->getName() : '';
            $result['countryCode'] = $geocoder->first()->getCountryCode();
            $result['countryName'] = !empty($geocoder->first()->getCountry()) ? $geocoder->first()->getCountry()->getName() : '';

            $result['lat'] = $geocoder->first()->getLatitude();
            $result['lng'] = $geocoder->first()->getLongitude();

            $buffer = '';
            if (!empty($result['line1'])) {
                $buffer = $result['line1'].', ';
            }
            if (!empty($result['line2'])) {
                $buffer .= $result['line2'].', ';
            }
            if (!empty($result['city'])) {
                $buffer .= $result['city'].', ';
            }
            if (!empty($result['zipcode'])) {
                $buffer .= $result['zipcode'].', ';
            }
            if (!empty($result['state'])) {
                $buffer .= $result['state'].', ';
            }
            if (!empty($result['countryName'])) {
                $buffer .= $result['countryName'];
            }

            $result['fullAddress'] = $buffer;
        }

        return $result;
    }

    public static function address2Geocoder($address, $countryCode = 'my', $forceRecache = false)
    {
        $useCache = Yii::app()->params['cache'];
        $cacheId = sprintf('%s::%s-%s', 'HubGeo', 'address2Geocoder', sha1(json_encode(array('v1', $address, $countryCode))));
        $return = Yii::app()->cache->get($cacheId);
        if ($return === false || $useCache === false) {
            try {
                $geocoder = new \Geocoder\Provider\GoogleMaps(
                    new \Ivory\HttpAdapter\CurlHttpAdapter(),
                    'en',
                    $countryCode,
                    true,
                    Yii::app()->params['googleMapApiKey']
                );
                /*$lookfor = '5 currie place, kardinya, wa';
                $result = Yii::app()->geocoder->geocode($lookfor);
                echo '<pre>'; print_r($result);
                print_r($result->first()->getCoordinates());*/

                $return = $geocoder->geocode($address);
                Yii::app()->cache->set($cacheId, $return, 60 * 60 * 24 * 30);
            } catch (Exception $e) {
                $return = null;
            }
        }

        return $return;
    }

    public static function ip2LatLng($ip, $countryCode = '')
    {
        $geocoder = new \Geocoder\Provider\GeoIP2(
            new \Geocoder\Adapter\GeoIP2Adapter(
                new \GeoIp2\WebService\Client(122610, 'EkUCw3WG5GER')
            )
        );

        $result = $geocoder->geocode($ip)->first();
        if (!empty($result)) {
            return array('lat' => $result->getLatitude(), 'lng' => $result->getLongitude());
        }

        return false;
    }

    public static function latLng2Geocoder($lat, $lng, $countryCode = 'my')
    {
        $geocoder = new \Geocoder\Provider\GoogleMaps(
            new \Ivory\HttpAdapter\CurlHttpAdapter(),
            'en',
            $countryCode,
            true,
            Yii::app()->params['googleMapApiKey']
        );
        /*$lookfor = '5 currie place, kardinya, wa';
        $result = Yii::app()->geocoder->geocode($lookfor);
        echo '<pre>'; print_r($result);
        print_r($result->first()->getCoordinates());*/

        $result = $geocoder->reverse($lat, $lng);

        return $result;
    }

    // convert lat lng string '1.234, 7.890' to flat array: array(0=>'1.234', 1=>'7.890')
    public static function latLngString2Flat($latLng)
    {
        if (!empty($latLng)) {
            $tmp = explode(',', $latLng);

            return array(floatval(trim($tmp[0])), floatval(trim($tmp[1])));
        }

        return null;
    }

    // convert lat lng flat array: array(0=>'1.234', 1=>'7.890') to string '1.234,7.890'
    public static function latLngFlat2String($latLng)
    {
        if (!empty($latLng)) {
            return sprintf('%s,%s', $latLng[0], $latLng[1]);
        }
    }

    // convert lat lng array array('lat'=>'1.234', 'lng'=>'7.890') to flat array use by model: array(0=>'1.234', 1=>'7.890')
    public static function latLngArray2Flat($latLng)
    {
        return array($latLng['lat'], $latLng['lng']);
    }

    public static function address2LatLng($address)
    {
        $geocoder = self::address2Geocoder($address);

        return array('lat' => $geocoder->first()->getLatitude(), 'lng' => $geocoder->first()->getLongitude());
    }

    public static function address2Loc($address)
    {
        $geocoder = self::address2Geocoder($address);

        return sprintf('%s,%s', $geocoder->first()->getLatitude(), $geocoder->first()->getLongitude());
    }

    public static function address2Zipcode($address)
    {
        $geocoder = self::address2Geocoder($address);

        return sprintf('%s', $geocoder->first()->getPostalCode());
    }

    public static function address2CountryCode($address)
    {
        $geocoder = self::address2Geocoder($address);

        return sprintf('%s', $geocoder->first()->getCountryCode());
    }

    public static function address2TimezoneArray($address)
    {
        $url = sprintf('https://maps.googleapis.com/maps/api/timezone/json?location=%s&timestamp=%s&key=%s', self::address2Loc($address), HUB::now(), Yii::app()->params['googleMapApiKey']);
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $result = json_decode($res->getBody());

        return $result;
    }

    // return eg: Australia/Sydney
    public static function address2TimezoneId($address)
    {
        $result = self::address2TimezoneArray($address);

        return $result->timeZoneId;
    }

    // return eg: 10, 8...
    public static function address2Timezone($address)
    {
        $result = self::address2TimezoneArray($address);

        return $result->rawOffset / 3600;
    }

    // instead of converting an address, it is best to use the loc directly
    // return eg: 10, 8...
    public static function loc2Timezone($loc)
    {
        //$address = self::loc2Address($loc);
        return self::address2Timezone($loc);
    }

    // return eg: Australia/Sydney
    public static function loc2TimezoneId($loc)
    {
        //$address = self::loc2Address($loc);
        return self::address2TimezoneId($loc);
    }

    public static function loc2Address($loc)
    {
        list($lat, $lng) = explode(',', $loc);
        try {
            $geocoder = self::latLng2Geocoder($lat, $lng);
            $result = $geocoder->first();

            if (!empty($result->getStreetNumber())) {
                $tmpResult[] = $result->getStreetNumber();
            }
            if (!empty($result->getStreetName())) {
                $tmpResult[] = $result->getStreetName();
            }
            if (!empty($result->getLocality())) {
                $tmpResult[] = $result->getLocality();
            }
            if (!empty($result->getSubLocality())) {
                $tmpResult[] = $result->getSubLocality();
            }
            if (!empty($result->getPostalCode())) {
                $tmpResult[] = $result->getPostalCode();
            }
            if (!empty($result->getAdminLevels()->first()->getName())) {
                $tmpResult[] = $result->getAdminLevels()->first()->getName();
            }
            if (!empty($result->getCountry()->getName())) {
                $tmpResult[] = $result->getCountry()->getName();
            }

            $fullAddress = implode(', ', $tmpResult);

            return array(
                'streetNumber' => $result->getStreetNumber(),
                'streetName' => $result->getStreetName(),
                'locality' => $result->getLocality(),
                'subLocality' => $result->getSubLocality(),
                'zipcode' => $result->getPostalCode(),
                'state' => $result->getAdminLevels()->first()->getName(),
                'stateCode' => $result->getAdminLevels()->first()->getCode(),
                'country' => $result->getCountry()->getName(),
                'countryCode' => $result->getCountryCode(),
                'fullAddress' => $fullAddress,
            );
        } catch (Exception $e) {
            return '';
        }
    }

    public static function getDistanceLinear($locSrc, $locDst)
    {
        list($latitudeFrom, $longitudeFrom) = explode(',', $locSrc);
        list($latitudeTo, $longitudeTo) = explode(',', $locDst);

        return self::vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
    }

    // return linear distance in meter
    public static function vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);

        return self::to2Decimal($angle * $earthRadius);
    }

    public static function to2Decimal($float)
    {
        return number_format((float) $float, 2, '.', '');
    }

    // return route distance in meter
    public static function getDistanceMatrix($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $url = sprintf('http://maps.googleapis.com/maps/api/directions/json?origin=%s,%s&destination=%s,%s', $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
        $routes = json_decode(file_get_contents($url))->routes;

        //sort the routes based on the distance
        usort($routes, create_function('$a, $b', 'return intval($a->legs[0]->distance->value) - intval($b->legs[0]->distance->value);'));

        // return the shortest distance
        return $routes[0]->legs[0]->distance->value;
    }

    // return route array with value in meter and time
    public static function getDistanceMatrixComplex($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $url = sprintf('http://maps.googleapis.com/maps/api/directions/json?origin=%s,%s&destination=%s,%s', $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
        $routes = json_decode(file_get_contents($url))->routes;

        //sort the routes based on the distance
        usort($routes, create_function('$a, $b', 'return intval($a->legs[0]->distance->value) - intval($b->legs[0]->distance->value);'));

        // return the shortest distance
        return $routes[0];
    }
}
