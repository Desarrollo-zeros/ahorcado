<?php
/**
 * Created by PhpStorm.
 * User: zeros
 * Date: 2/06/2018
 * Time: 10:48 PM
 */
class  Persona extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}

	public function registrarDatosPersona($data = array()){
		$usuario = new stdClass();
		$usuario->usuario = $data["usuario"];
		$usuario->contraseña = $data["pass"];
		$usuario->rol = 1;
		if($this->db->query("select *from usuario where usuario = '{$usuario->usuario}' ")->num_rows()<1){
			$r = $this->db->insert("usuario",$usuario);
		}
		if($r){
			$persona = new stdClass();
			$persona->primerNombre = $data["pNombre"];
			$persona->segundoNombre = $data["pApellido"];
			$persona->primerApellido = $data["sNombre"];
			$persona->segundoApellido = $data["sApellido"];
			$persona->semestre = $data["semestre"];
			$persona->idUsuario = $this->db->query("select idUsuario from usuario where usuario = '{$usuario->usuario}' ")->row("idUsuario");
			$this->db->insert("persona",$persona);
		}
		return $r;
	}


	public function iniciarSession($data = array()){
		$usuario = new stdClass();
		$usuario->usuario = $data["usuario"];
		$usuario->contraseña = $data["pass"];
		$query = $this->db->query("select idUsuario,usuario,rol from usuario where usuario = '{$usuario->usuario}' and contraseña = '{$usuario->contraseña}' ");
		if($query->num_rows()>0){
			$this->session->idUsuario = $query->row("idUsuario");
			$this->session->usuario = $query->row("usuario");
			$this->session->rol = $query->row("rol");
			return true;
		}
		else{
			return false;
		}
	}


	public function obtenerDatosPersona(){
		return $this->db->query("select *from persona where idUsuario = {$this->session->idUsuario} ")->row();
	}


	public function obtenerPreguntas(){
		return $this->db->query("select *from pregunta")->result();
	}

	public function registrarProgreso($data = array()){
		return $this->db->insert("up",$data);
	}

	public function verEstados(){
		return $this->db->query("select UPPER(CONCAT(p.PrimerNombre,' ',p.primerApellido)) as usuario, p.imagen, pr.pregunta, up.estado FROM usuario u
							  	 inner join up up on up.idUsuario = u.idUsuario
								 inner join persona p on p.idUsuario = u.idUsuario 
								 inner join pregunta pr on pr.idPregunta = up.idPregunta;")->result();
	}

	function registrarPregunta($data = array()){
		return $this->db->insert("pregunta",$data);
	}

	function actualizarFoto($img){

		$file = $this->db->query("select imagen from persona where idUsuario = {$this->session->idUsuario}")->row("imagen");
		if(isset($file)){
			unlink("uploads/".$file);
		}
		$this->db->where("idUsuario", $this->session->idUsuario);
		return $this->db->update("persona",array("imagen"=>$img));
	}
}
