<?php

namespace Regions\Model;

class Regions{
    public $region_id;
    public $region_name;
    
    public function exchangeArray($data) {
        $this->region_id = (!empty($data['region_id'])) ? $data['region_id'] : null;
        $this->region_name = (!empty($data['region_name'])) ? $data['region_name'] : null;
    }
    
}
