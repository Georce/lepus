
<div class="header">
            
            <h1 class="page-title"><?php echo $this->lang->line('license'); ?></h1>
</div>
        


<div class="container-fluid">
<div class="row-fluid">    

    <div class="http-error">
        <h1><?php echo $this->lang->line('license'); ?></h1>
        <table class="table table-bordered">
        	<tr class="warning">
        	<td style="width:200px"><?php echo $this->lang->line('company_name'); ?></td><td><?php echo $license_data['company_name']; ?></td>
        </tr>
        <tr class="warning">
        	<td style="width:200px"><?php echo $this->lang->line('license_user'); ?></td><td><?php echo $license_data['license_user']; ?></td>
        </tr>
        <tr class="warning">
        	<td style="width:200px"><?php echo $this->lang->line('license_key'); ?></td><td><?php echo $license_data['license_key']; ?></td>
        </tr>
        <tr class="warning">
        	<td style="width:200px"><?php echo $this->lang->line('license_type'); ?></td><td><?php echo $license_data['license_type']; ?></td>
        </tr>
        <tr class="warning">
                <td style="width:200px"><?php echo $this->lang->line('license_version'); ?></td><td><?php echo $license_data['license_version']; ?></td>
        </tr>
        <tr class="warning">
        	<td style="width:200px"><?php echo $this->lang->line('license_server_count'); ?></td><td><?php echo $license_data['license_server_count']; ?></td>
        </tr>
        <tr class="warning">
        	<td style="width:200px"><?php echo $this->lang->line('license_expire_date'); ?></td><td><?php echo $license_data['license_expire_date']; ?></td>
        </tr>
        <tr class="warning">
        	<td style="width:200px"><?php echo $this->lang->line('license_mac_addr'); ?></td><td><?php echo $license_data['license_mac_addr']; ?></td>
        </tr>
         </tr>
        <tr class="success">
        	<td style="width:200px"><?php echo $this->lang->line('my_server_mac_addr'); ?></td><td><?php echo $my_server_mac_addr; ?> &nbsp;&nbsp;<a href="http://www.lepus.cc" target="_blank" ><?php echo $this->lang->line('license_support'); ?></a></td>
        </tr>
        </table>
       
    </div>


