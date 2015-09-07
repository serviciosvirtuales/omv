<?php

class Momv extends CI_Model
{
    public function instituciones()
    {
        $this->db->trans_start();
        
        $query = $this->db->select('id_institucion, nombre_institucion')->from('institucion_educativa')->order_by("nombre_institucion", "asc")->get();

        //$str = $this->db->last_query();
        //log_message('ERROR', 'error CIE10 ' . $str);		

        if ($query->num_rows() > 0) 
        {            
            foreach ($query->result() as $key) 
            {                
                $data[$key->id_institucion] = $key->nombre_institucion;
            }
            $this->db->trans_complete();
            return $data;
        } 
        else 
        {
            $this->db->trans_complete();
            return FALSE;
        }
        $this->db->trans_complete();
    }
    
    function user_institucion() // con esta funcion consultamos a que institucion pertenece el usuario logueado.
    {
        $this->db->trans_start();
        
        $user = $this->ion_auth->user()->row();
        $id_usuario = $user->id; // aqui envio el id de la persona logueada q registra a la entidad. 
        
        $query = $this->db->select('id_institucion_ed')->where('id',$id_usuario)->get('users');

        //$str = $this->db->last_query();
        //log_message('ERROR', 'error CIE10 ' . $str);		

        if ($query->num_rows() > 0) 
        {            
            $row = $query->row(); 
            $this->db->trans_complete();            
            return $row->id_institucion_ed;
        } 
        else 
        {
            $this->db->trans_complete();
            return FALSE;
        }
        $this->db->trans_complete();
    }
    
    function paciente_evento()
    {
        $this->db->trans_start();
        
        $user = $this->ion_auth->user()->row();
        $id_institucion = $user->id_institucion_ed;
        
        $query = $this->db->where('institution',$id_institucion)->get('patients');

        //$str = $this->db->last_query();
        //log_message('ERROR', 'Seguimiento a pacientes en creacion de evento ' . $str);		

        if ($query->num_rows() > 0) 
        {            
            foreach ($query->result() as $key) 
            {                
                $data[$key->id_number] = $key->last_name.' - '.$key->first_name;
            }
            $this->db->trans_complete();
            return $data;
        } 
        else 
        {
            $this->db->trans_complete();
            return FALSE;
        }
        $this->db->trans_complete();
    }
}

