<?php

class Dbislem extends CI_Controller{
    public function index(){
        //"rows", "result", "get", "viewData" gönderimi...
        //! view'de get metotu kullanıldı ise veri burada da get ile çağırılmalıdır, bu durumun tersi de geçerlidir. !

        //Tüm sonuçları getirmek için kullanılacak metot.
        $rows = $this->db->get("personel")->result();

        //Tek sonuç getirmek için kullanılacak metot.
        //$rows = $this->db->get("personel")->row();

        $viewData = array("rows" => $rows);
        $this->load->view("dbislem", $viewData);
    }
    public function where(){
        //"where", "or_where", "where_in", "or_where_in", "where_not_in", "or_where_not_in", "last_query" kullanımları...

        //1. where (veya or_where) kullanımı:
        /*
        $rows = $this
            ->db
            ->where("id >",1)
            ->where("id <",4)
            ->where("detail !=","")
            ->get("personel")
            ->result();
        */

        //2. where (veya or_where) kullanımı:
        /*
        $where = array(
            "id <="      => 1,
            "id >="      => 4,
            "detail =" => ""
        );

        $rows = $this
            ->db
            ->or_where($where)
            ->get("personel")
            ->result();
        */

        //where_in kullanımı:
        /*
        $rows = $this
            ->db
            ->where("id >", 1)
            ->where_in("title",array("kablosuzkedi","ibrahim"))
            ->get("personel")
            ->result();
        */

        /*
        //or_where_in kullanımı: !!!"where" ile "or_where_in" yerini değiştirirsek kodun anlam değişir!!!
        $rows = $this
            ->db
            ->where("id =", 1)
            ->or_where_in("title",array("felakettin","ibrahim"))
            ->get("personel")
            ->result();
        */

        /*
        //where_not_in kullanımı:
        $rows = $this
            ->db
            ->where("id >", 1)
            ->where("id <", 4)
            ->where_not_in("title",array("kablosuzkedi","ibrahim"))
            ->get("personel")
            ->result();
        */


        //or_where_not_in kullanımı: !!!"where_not_in" ile "or_where_not_in" yerini değiştirirsek kodun anlamı değişir!!!
        $rows = $this
            ->db
            ->where("id >", 1)
            ->where("id <", 4)
            ->or_where_not_in("title",array("kablosuzkedi","ibrahim"))
            ->get("personel")
            ->result();

        //last_query: Son sorguyu bize gösteriyor. (Olayı daha iyi kavramak için güzel oluyor.)
        echo $this->db->last_query();

        //viewData'yı array tipinde oluşturup, view'in içindeki dbislem.php'ye yolluyoruz.
        $viewData = array("rows" => $rows);
        $this->load->view("dbislem", $viewData);
    }
    public function like(){
        //"like", "or_like", "not_like", "or_not_like" kullanımları...
        //"or_like", "not_like", "or_not_like" kullanımları aynı "where" metot'unda olduğu gibidir gibidir.

        //like kullanımları:
        /*
        $rows = array("title" => "ettin", "detail" => "yo");
        $rows = $this->db->like($rows)->get("personel")->result();
        */

        $rows = $this->db->like("title", "ettin")->like("title", "felak")->get("personel")->result();

        echo $this->db->last_query() , "<br>";
        print_r($rows);
    }
    public function orderby(){
        //order_by: Sıralama metotunun kullanımlarını ("asc", "desc", "random") gördük.

        $rows = $this->db->order_by("title","random")->get("personel")->result();
        print_r($rows);
    }
    public function limit(){
        //Database'ten çekilen sorgu limitini belirler.

        $rows = $this->db->limit(3)->get("personel")->result();
        echo $this->db->last_query() . "<br>";
        print_r($rows);
    }
    public function query(){
        //Gördüğümüz metotlar ile karışık bir sorgu almayı öğreniyoruz.

        //select * from personel WHERE id > 1 AND title LIKE "%etti%" ORDER BY id DESC LIMIT 1
        $rows = $this
            ->db
            ->where("id >", 1)
            ->like("title", "etti")
            ->order_by("id", "desc")
            ->limit("1")
            ->get("personel")
            ->result();

        echo $this->db->last_query() . "<br>";
        print_r($rows);
    }
    public function customQuery(){
        //query metotu kullanarak SQL cümlesi ile sorgu alabiliyoruz.

        $rows = $this->db->query("select * from personel WHERE id > 1 AND title LIKE \"%etti%\" ORDER BY id DESC LIMIT 1")->result();

        echo $this->db->last_query() . "<br>";
        print_r($rows);
    }
    public function insertPage(){
        //insert görünüm sayfasına yönlendiren fonksiyon...

        $this->load->view("insert");
    }
    public function insert(){
        //insert işleminin yapıldığı alan...

        $title  = $this->input->post("title");
        $detail = $this->input->post("detail");

        $data   = array("title" => $title, "detail" => $detail);
        $insert = $this->db->insert("personel", $data);
        echo $insert;   //insert başarılı olur ise "1", başarısız olur ise "0" döndürecek.
    }
    public function updatePage(){
        //update görünüm sayfasına yönlendiren fonksiyon...

        $this->load->view("update");
    }
    public function update(){
        //update işleminin yapıldığı alan...

        $id     = $this->input->post("id");
        $title  = $this->input->post("title");
        $detail = $this->input->post("detail");
        $data   = array("id" => $id, "title" => $title, "detail" => $detail);

        //Veriyi güncellemenin 1. yolu:
        //$insert = $this->db->replace("personel", $data);

        //Veriyi güncellemenin 2. yolu:
        $update = $this->db->where("id", $id)->update("personel", $data);

        echo $update;
    }
    public function delete($id){
        //delete işleminin yapıldığı alan...

        //Veriyi silmenin 1. yolu:
        //$delete = $this->db->delete("personel", array("id" => $id));

        //Veriyi silmenin 2. yolu:
        $delete = $this->db->where("id", $id)->delete("personel");

        echo $delete;
    }
}