<?php

namespace Locations\Model;

class Locations{
    public $location_id;
    public $street_address;
    public $city;
    public $country_id;
    
    public function exchangeArray($data){
        $this->location_id = (!empty($data['location_id']))  ? $data['location_id'] : null;
        $this->street_address = (!empty($data['street_address'])) ? $data['street_address'] : null;
        $this->city = (!empty($data['city'])) ? $data['city'] : null;
        $this->country_id = (!empty($data['country_id'])) ? $data['country_id'] : null;
    }
}
