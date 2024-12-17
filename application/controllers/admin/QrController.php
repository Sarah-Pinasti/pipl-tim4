<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QrController extends CI_Controller
{

    public function index()
    {
        $this->load->library('ciqrcode');

        $params['data']     = '';
        $params['level']    = 'H';
        $params['size']     = 5;
        $params['savename'] = '';
        $this->ciqrcode->generate($params);

        echo '<img src="' . base_url('assets/qrcode/') . '';
    }
}
