<?php

class Login_M extends CI_Model {

	function validate(){            
            
            $this -> db -> select('*');
            $this -> db -> from('profile');
            $this -> db -> where('email', $this->input->post('username')); 
            $this->db->where('password', $this->input->post('password'));
           // $this -> db -> where('activation_status = 1');
            $this -> db -> limit(1);
            //echo md5($password);
            //exit();
            $query = $this -> db -> get();      

            if($query -> num_rows() == 1)
            {                 
                   return $query->result();
            }
            else
            {
                    return false;
            }
	}

	function validate_user(){            
            
            $this -> db -> select('*');
            $this -> db -> from('students');
            $this -> db -> where('student_id', $this->input->post('student_id')); 
            $this->db->where('password', md5($this->input->post('password')));
            $this -> db -> where('verified', 1); 
           // $this -> db -> where('activation_status = 1');
            $this -> db -> limit(1);
            //echo md5($password);
            //exit();
            $query = $this -> db -> get();      

            if($query -> num_rows() == 1)
            {                 
                   return $query->result();
            }
            else
            {
                    return false;
            }
	}
        
        
        
        
        function get_pass(){
            
            $this -> db -> select('*');
            $this -> db -> from('students');
            $this -> db -> where('email', $this->input->post('email')); 
           // $this -> db -> where('activation_status = 1');
            $this -> db -> limit(1);
            //echo md5($password);
            //exit();
            $query = $this -> db -> get();

            if($query -> num_rows() == 1)
            {                 
                   return $query->result();
            }
            else
            {
                    return false;
            }
            
	}
        
        function validate_admin(){            
            
            $this -> db -> select('*');
            $this -> db -> from('admin');
            $this -> db -> where('user', $this->input->post('username')); 
            $this->db->where('password', md5($this->input->post('password')));
           // $this -> db -> where('activation_status = 1');
            $this -> db -> limit(1);
            //echo md5($password);
            //exit();
            $query = $this -> db -> get();   
            
            if($query -> num_rows() == 1)
            {                 
                   return $query->result();
            }
            else
            {
                    return false;
            }
	}
        
        public function updatePassword($email,$new_password){
            $this->db->set('password',$new_password);
            $this->db->where('email',$email);
            $this->db->update('students');
        }
        
        
        
	
}