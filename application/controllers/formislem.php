<?php
class Formislem extends CI_Controller
{
    public function index()
    {
        $this->load->view("form");
    }
    public function kaydet(){
        $isim = $this->input->get("isim");
        $email = $this->input->get("email");
        $cinsiyet = $this->input->get("cinsiyet");
        echo "isim: " . $isim . " - email: ". $email . " - Cinsiyet: " . $cinsiyet;
    }
}
