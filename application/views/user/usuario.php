<div id="user">
	<?php

		$usr = $this->ion_auth->user()->row();		
		//$usr = $this->ion_auth->user();
		
		$cod = $usr->id;

		$this->db->select('c.first_name,c.last_name')
			->from('users c')
			->where('c.id',$cod);			
			$rol = $this->db->get();

		foreach($rol->result() as $role)			//local
		{ 
			echo "<h5>Bienvenido - ".$role->first_name." ".$role->last_name;
		}

	?>
</div>
<style>
#user{
	color: #003399;
	text-align: left;
	vertical-align: middle;
	margin-left: 3px;
	margin-right: 3px;
	margin-top: 3px;
	margin-bottom: 3px;

}
</style>