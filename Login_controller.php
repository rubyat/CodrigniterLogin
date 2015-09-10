<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_controller extends CI_Controller {
    

		public function index(){            
			if($_POST){
						   
				$this->load->model('login_m');
				$query = $this->login_m->validate_admin(); 
				
				if($query){
					$data = array();
					foreach($query as $row){

						$user_type = $row->user_type;

						$data = array(
							'user' => $row->user,
							'user_type' => $row->user_type,
							'email' => $row->email,
							'is_admin' => true
						);

						$this->session->set_userdata($data); 
					}
						




						
				}else{       
					$msg['message']="    <div class=\"alert fade alert-error in\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">×</button><strong>Incorrect Username or Password</strong></div>";
					$this->session->set_userdata($msg);
					redirect(base_url().'admin');
				}
				
			}else{
				$data = array();
				$data['page'] = 'Login';
				$this->load->view('admin/login',$data);
			}
		}
		
		
		function getpass(){
            
			$this->load->model('login_m');
			$query = $this->login_m->get_pass();       

			if($query) // if the user's credentials validated...
			{
				$data = array();
				foreach($query as $row){
		
				$data = array(
				'name' => $row->name,
				'student_id' => $row->student_id,
				'email' => $row->email
				);}
				
				$new_pass = $this->generateNewPassword();
				
				$this->login_m->updatePassword($data['email'],  md5($new_pass));
				
				
				$email = $data['email'];
				$password = $new_pass;
				$user = $data['name'];
				$student_id = $data['student_id'];
				$message = "Login id : $student_id <br/> New Password : $password ";
				$subject=$data['subject']="Your New Password";
				
				$mail_info="Your New Password";
				
				
				$this->load->library('email');
				
				
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';

				$this->email->initialize($config);
				
				$this->email->from('info@atcomputer.net.bd', $mail_info);
				$this->email->to($email);
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
							
				
	//            echo $new_pass . "<br>" . $user ;
	//            
	//            exit();
				
				$str = "<div class=\"alert alert-success fade in\">
				<button class=\"close\" data-dismiss=\"alert\" type=\"button\">×</button>                 
				Your password has been sent to your mail. 
				</div>";
				echo json_encode(array('st'=>0,'msg'=>$str));  
				exit();
				   
				
			}
			else // incorrect username or password
			{
					$str = "<div class=\"alert alert-danger fade in\">
							<button class=\"close\" data-dismiss=\"alert\" type=\"button\">×</button>                 
							Sorry your mail id is not correct!!!! 
							</div>";
							echo json_encode(array('st'=>1,'msg'=>$str));  
							exit();
			}
        } 
        
        
        
        
        
        
        function generateNewPassword() {

			$alpha = array ('A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e', 'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i', 'J', 'j', '@', '1', '2', '3', '4', '5', '7', '8', '9', '0', '}', ']', '|', '(', '.', ',', '-' );

			$passwordLength = 10;
			$password = '';

			for($i = 0; $i < $passwordLength; $i ++) {
				$rand = mt_rand ( 0, 29 );
				$password .= $alpha [$rand];
			}

			return $password;
		}
		
        
        
        function logout(){
			$this->session->sess_destroy();
					$msg['message']="    <div class=\"alert fade alert-error in\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">×</button><strong>Loged Out</strong></div>";
					$this->session->set_userdata($msg); 
					redirect(base_url().'admin');
		}
		
		
		
        
}

            
