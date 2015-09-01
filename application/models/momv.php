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
}

