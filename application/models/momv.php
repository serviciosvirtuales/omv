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

        $query = $this->db->select('id_institucion_ed')->where('id', $id_usuario)->get('users');

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

        $query = $this->db->where('institution', $id_institucion)->get('patients');
        
        //$str = $this->db->last_query();
        //log_message('ERROR', 'Seguimiento a pacientes en creacion de evento ' . $str);		

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $key)
            {
                $data[$key->id_number] = $key->last_name . ' - ' . $key->first_name;
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
    
    function paciente_evento_responde()
    {
        $this->db->trans_start();

        $user = $this->ion_auth->user()->row();
        $id_institucion = $user->id_institucion_ed;

        //$query = $this->db->where('institution', $id_institucion)->get('patients');
        $query = $this->db->get('patients');
        //$str = $this->db->last_query();
        //log_message('ERROR', 'Seguimiento a pacientes en creacion de evento ' . $str);		

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $key)
            {
                $data[$key->id_number] = $key->last_name . ' - ' . $key->first_name;
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

    function cie10()
    {  //consulto los codigos de cie10 de la base de datos
        $this->db->trans_start();

        //log_message('ERROR', 'mdchat total_pendientes() Aqui estoy 0');
        $query = $this->db->select('cie10_descripcion')->from('cie10')->order_by("cie10_descripcion", "asc")->get();

        //$str = $this->db->last_query();
        //log_message('ERROR', 'error CIE10 ' . $str);		

        if ($query->num_rows() > 0)
        {
            //log_message('ERROR', 'mdchat total_pendientes() Aqui estoy 2');
            foreach ($query->result() as $key)
            {

                //$data[$key->cie10_cie2]=word_limiter($key->cie10_descripcion,5);
                $data[$key->cie10_descripcion] = $key->cie10_descripcion;
            }
            $this->db->trans_complete();
            return $data;
        } 
        else
        {
            $this->db->trans_complete();
            return FALSE;
        }

        //return $query;

        $this->db->trans_complete();
    }
    
    function detalle_evento($id)
    {
        $this->db->trans_start();
        
        $query = $this->db->select('e.*, p.* ')
                ->from('evento e, patients p')
                ->where('e.id_evento',$id)
                ->where('e.paciente_id = p.id_number')
                ->get('');
        
        if($query->num_rows() > 0)
        {
            $this->db->trans_complete();
            return $query;
        }
        else
        {
            $this->db->trans_complete();
            return FALSE;
        }
                
        $this->db->trans_complete();
    }
    
    function actualizo_evento($id) 
    {
        $this->db->trans_start(); // manejo transacciones inicio

        $estado = 'Finalizado';

        $data = array('estado' => $estado);

        $this->db->where('id_evento', $id);

        $this->db->update('evento', $data);

        $this->db->trans_complete(); // manejo transacciones fin
    }
    
    /*
    function consulta_historica() //se comenta
    {
        $this->db->trans_start();
        
        $user = $this->ion_auth->user()->row();
        $admin = $user->id;
        
        $query = $this->db->select('e.id_evento, e.paciente_id, e.descripcion, e.fecha_evento, e.adjunto1 as eadj1, e.adjunto2 as eadj2, e.adjunto3 as eadj3, e.adjunto4 as eadj4,
                                    e.adjunto5 as eadj5, e.estado, r.respuesta, r.cie10, r.adjunto1 as radj1, r.adjunto2 as radj2, r.adjunto3 as radj3, r.adjunto4 as radj4,
                                    r.adjunto5 as radj5, r.fecha_respuesta, r.registrado_por as responde')
                ->from('evento e, respuesta r')
                ->where('e.estado = "Finalizado"')
                ->where('e.id_evento = r.id_evento')
                ->where('e.registrado_por',$admin)
                ->get('');
        
        if($query->num_rows() > 0)
        {
            $this->db->trans_complete();
            return $query;
        }
        else
        {
            $this->db->trans_complete();
            return NULL;
        }
        
        
        $this->db->trans_complete();
    }      
     */
    
    function historia_paciente($id)
    {
        $this->db->trans_start();
        
        /*
        select e.id_evento, e.descripcion, e.fecha_evento, e.institucion_edu_id, e.estado,
        e.adjunto1 as eadj1, e.adjunto2 as eadj2, e.adjunto3 as eadj3, e.adjunto4 as eadj4, e.adjunto5 as eadj5,
        r.respuesta, r.cie10, r.fecha_respuesta, r.registrado_por,
        r.adjunto1 as radj1, r.adjunto2 as radj2, r.adjunto3 as radj3, r.adjunto4 as radj4, r.adjunto5 as radj5
        from evento e, respuesta r 
        where e.paciente_id = (select id_number from patients where id=2)
        and e.estado = 'Finalizado'
        and r.id_evento = e.id_evento

        */
        $this->db->select('e.id_evento, e.descripcion, e.fecha_evento, e.institucion_edu_id, e.estado,
                            e.adjunto1 as eadj1, e.adjunto2 as eadj2, e.adjunto3 as eadj3, e.adjunto4 as eadj4, e.adjunto5 as eadj5,
                            r.respuesta, r.cie10, r.fecha_respuesta, r.registrado_por,
                            r.adjunto1 as radj1, r.adjunto2 as radj2, r.adjunto3 as radj3, r.adjunto4 as radj4, r.adjunto5 as radj5, p.*')
                ->from('evento e, respuesta r, patients p')
                ->where('paciente_id = p.id_number')
                ->where('p.id',$id)
                ->where('e.estado = "Finalizado"')
                ->where('r.id_evento = e.id_evento')
                ->order_by('e.fecha_evento', 'DESC');
        
        $query = $this->db->get('');
        
        if($query->num_rows() > 0)
        {
            $this->db->trans_complete();
            return $query;
        }
        else
        {
            $this->db->trans_complete();
            return FALSE;
        }
        
        $this->db->trans_complete();
    }
}
