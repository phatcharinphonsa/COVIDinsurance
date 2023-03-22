<?php
class login extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('form','url');
        $this->load->library('form_validation');
        $this->load->model('m_login');//
    }
    public function home(){
        $this->load->view('home');
    }
    public function history(){
        $this->load->view('history');
    }
    
    public function authen(){
        $this->form_validation->set_rules('username','Username','required');
        $this->form_validation->set_rules('password','Password','required');
        if($this->form_validation->run()==FALSE){
            $this->load->view('form_login');
        }
        else{
            $get_data['username'] = $_REQUEST['username'];
            $get_data['password'] = $_REQUEST['password'];
            //$this->load->view('msg_login',$data);
            //******* */
            $data = $this->m_login->login($get_data);
            if($data){//ตรวจสอบว่าพบข้อมูล username password
                foreach($data as $row){
                    $userdata = array(
                        'username'=>$row->username,
                       // 'name'=>$row->name
                    );
                    $this->session->set_userdata($userdata);
                }
                $this->load->view('home');
            }
            else{//ไม่พบข้อมูลใน database
                $data['error'] = "username or password incorrect";
                $this->load->view('form_login',$data);
            }
            /**** */
        }
    }
    
    public function logout(){
        $userdata = array('username','password');
        $this->session->unset_userdata($userdata);
        $this->load->view('form_login');
    }
}
?>