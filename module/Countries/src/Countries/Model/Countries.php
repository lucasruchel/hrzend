<?php

namespace Countries\Model;

class Countries{
    public $country_id;
    public $country_name;
    public $region_id;
    
    public function exchangeArray($data){
        $this->country_id = (!empty($data['country_id'])) ? $data['country_id'] : null;
        $this->country_name = (!empty($data['country_name'])) ? $data['country_name'] : null;
        $this->region_id = (!empty($data['region_id'])) ? $data['region_id'] : null;
    }
}
