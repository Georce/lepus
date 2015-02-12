<?php 
class Auth_model extends CI_Model{


	protected $table_user_role='admin_user_role';
    protected $table_role_privilege='admin_role_privilege';
    protected $table_menu='admin_menu';
    protected $table_privilege='admin_privilege';
	
	
    /*
    * 检查用户是否有权限
    */
	function check_user_privilege($username, $action)
	{
		$sql = "select * from admin_user , admin_role role, admin_privilege privilege, admin_user_role user_role, admin_role_privilege role_privilege
				where 
                admin_user.username = ? and
                admin_user.user_id = user_role.user_id and
				user_role.role_id = role.role_id and
				role.role_id = role_privilege.role_id and
				role_privilege.privilege_id = privilege.privilege_id and
				privilege.action = ? ;";
		
		$query = $this->db->query($sql, array($username, $action));
		if($query->num_rows() > 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
    
    /*
    * 角色授权
    */
    public function update_role_privilege($role_id,$privilege_ids){
        if($role_id){
            if($privilege_ids){
                $this->db->delete($this->table_role_privilege, array('role_id' => $role_id));
                foreach($privilege_ids as $privilege_id){
                    $this->db->insert($this->table_role_privilege, array('role_id' => $role_id,'privilege_id' => $privilege_id));
                }
            }
            else{
                $this->db->delete($this->table_role_privilege, array('role_id' => $role_id));
            }
            return true; 
        }

    }
    
     /*
    * 用户授权
    */
    public function update_user_role($user_id,$role_ids){
        if($user_id){
            if($role_ids){
                $this->db->delete($this->table_user_role, array('user_id' => $user_id));
                foreach($role_ids as $role_id){
                    $this->db->insert($this->table_user_role, array('user_id' => $user_id,'role_id' => $role_id));
                }
            }
            else{
                $this->db->delete($this->table_user_role, array('user_id' => $user_id));
            }
            return true; 
        }

    }
    
    /*
    *获取当前角色拥有的权限ID
    */
    public function get_role_privilege($role_id){
        if($role_id){
            $query = $this->db->get_where($this->table_role_privilege, array('role_id' =>$role_id));
            if ($query->num_rows() > 0)
		    {
			   $result = $query->result_array();
                foreach($result as $item){
                    $role_privilege_ids[]=$item['privilege_id'];
                }
                //$role_privilege_ids = implode(',',$role_privilege_ids);
            }
            else{
                $role_privilege_ids[]='';
            }
            return $role_privilege_ids;
        }
    }
    
     /*
    *获取当前用户拥有的角色ID
    */
    public function get_user_role($user_id){
        if($user_id){
            $query = $this->db->get_where($this->table_user_role, array('user_id' =>$user_id));
            if ($query->num_rows() > 0)
		    {
			   $result = $query->result_array();
                foreach($result as $item){
                    $user_role_ids[]=$item['role_id'];
                }
            }
            else{
                $user_role_ids[]='';
            }
            return $user_role_ids;
        }
    }
    
    function get_submenus_by_username($username)
	{
		$sql = "select admin_menu.* from admin_user, admin_role,admin_user_role,admin_privilege,admin_role_privilege,admin_menu 
				where admin_user.username= ? and 
				admin_user.user_id= admin_user_role.user_id and
				admin_user_role.role_id = admin_role.role_id and 
				admin_role.role_id = admin_role_privilege.role_id and 
				admin_role_privilege.privilege_id = admin_privilege.privilege_id and 
				admin_privilege.menu_id = admin_menu.menu_id and
                admin_menu.status = 1 
                group by admin_menu.menu_id
                order by admin_menu.display_order asc;";
		
		$query = $this->db->query($sql, array($username));
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $menu)
			{
				$menus[] = $menu;
			}
			return $menus;
		}
		else 
		{
			return false;
		}
		
	}
	

	function get_parent_menus_by_submenu_id($menu_id)
	{
		$this->db->where('menu_id', $menu_id);
		$this->db->where('status', 1);
		$parent = $this->db->get($this->table_menu);
		if($parent->num_rows() > 0)
		{
			$parent_id = $parent->first_row()->parent_id;
			
			$this->db->where('menu_id', $parent_id);
			$menu = $this->db->get($this->table_menu);
			
			return $menu->first_row();
		}
	}
    
    function get_action_by_menu_id($menu_id)
	{
		$this->db->where('menu_id', $menu_id);
		$query = $this->db->get($this->table_privilege);
		if($query->num_rows() > 0)
		{
			$action_str='';
            $result = $query->result_array();
            foreach($result as $item){
                $action =  $item['action'];
                $action_str = $action."|".$action_str;
            }
            return $action_str;	
		}
        else
        {
            return false;
        }
        
	}
    
    function get_parent_action_by_menu_id($menu_id)
	{
		$sql="select action from admin_privilege where menu_id in (select menu_id from admin_menu where parent_id=? );";
        $query = $this->db->query($sql, array($menu_id));
		if($query->num_rows() > 0)
		{
			$action_str='';
            $result = $query->result_array();
            foreach($result as $item){
                $action =  $item['action'];
                $action_str = $action."|".$action_str;
            }
            return $action_str;	
		}
		else 
		{
			return false;
		}
	}
    
    function get_user_menus_by_username($username)
	{
		$sub_menus = $this->get_submenus_by_username($username);		
		
		foreach($sub_menus as $sub_menu)
		{
			$parent_menu = $this->get_parent_menus_by_submenu_id($sub_menu->menu_id);
            //父节点有可能被删除
            if(!$parent_menu)
            {
                continue; 
            }
			if(!isset($all_menu[$parent_menu->menu_id]))
			{
				$all_menu[$parent_menu->menu_id] = array('parent_title' => $parent_menu->menu_title,
                                                         'parent_url' => $parent_menu->menu_url,
                                                         'parent_icon' => $parent_menu->menu_icon,
                                                         'parent_sort' => $parent_menu->display_order,
                                                         'parent_action' => $this->get_parent_action_by_menu_id($parent_menu->menu_id)
                                                         );
			}
            
			$all_menu[$parent_menu->menu_id][] = array('id' => $sub_menu->menu_id,
                                                       'title' => $sub_menu->menu_title,
													   'url' => $sub_menu->menu_url,
                                                       'icon' => $sub_menu->menu_icon,
                                                       'action' => $this->get_action_by_menu_id($sub_menu->menu_id)
			                                           );
		}
        
        //按父类显示顺序排序
        foreach ($all_menu as $key => $value) {
            $sort[$key] = $value['parent_sort'];
        }
		array_multisort($sort, SORT_ASC, $all_menu);
        
		return $all_menu;
	}
    
    

    
    
	
		/*
	 * 添加信息
	 */
	public function insert($data){		
		$this->db->insert($this->table, $data);
	}
	
	/*
	 * 更新信息
	*/
	public function update($data,$id){
		$this->db->where('role_id', $id);
		$this->db->update($this->table, $data);
	}
    
    /*
	 * 删除信息
	*/
	public function delete($id){
		$this->db->where('role_id', $id);
		$this->db->delete($this->table);
	}
    
    public function get_user_menus()
	{
		return "admin";
	}
	

}

/* End of file auth_model.php */
/* Location: ./application/models/auth_model.php */
