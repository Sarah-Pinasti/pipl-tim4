<?php

class Licensing
{

    private $CI;
    private $license_code;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->config('licensing');
        $this->license_code = $this->CI->config->item('license_code');
    }

    public function check_license()
    {
        if ($this->license_code != 'OSCAR_STORE_JEPARA') {
            show_error('Invalid License Code');
        }
    }
}
