<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juego extends CI_Controller {


	public function index()
	{
		$this->load->model("Persona","P");
		$data["persona"] = new stdClass();
		if(isset($this->session->idUsuario)){
			$data["persona"] = ($this->P->obtenerDatosPersona());
		}
		$this->load->view('welcome_message',$data);
	}

	public function registro(){
		$this->load->model("Persona","P");
		$data  = ($this->input->post("usuario"));
		if(isset($data)){
			echo  json_encode($this->P->registrarDatosPersona($data));
		}else{
			echo json_encode(array("estado"=>false));
		}
	}

	function iniciarSession(){
		$this->load->model("Persona","P");
		$data = ($this->input->post("usuario"));
		if(isset($data)){
			echo  json_encode($this->P->iniciarSession($data));
		}else{
			echo json_encode(array("estado"=>false));
		}
	}

	public function obtenerPreguntas(){
		$this->load->model("Persona","P");
		$cont = count($this->P->obtenerPreguntas())-1;
		$cont = rand(0,$cont);
		echo json_encode($this->P->obtenerPreguntas()[$cont]);
	}

	function cerrarSession(){
		$this->session->sess_destroy();
		redirect("");
	}

	function registrarProgreso(){
		$this->load->model("Persona","P");
		$idPregunta = $this->input->post("idPregunta");
		$data = array("idUsuario"=>$this->session->idUsuario,"idPregunta"=>$idPregunta,"estado" =>  $this->input->post("estado"));
		echo json_encode($this->P->registrarProgreso($data));
	}

	public function verEstados(){
		$this->load->model("Persona","P");
		echo json_encode($this->P->verEstados());
	}

	public function registrarPregunta(){
		$this->load->model("Persona","P");
		$data = array("pregunta"=>$this->input->post("pregunta"),"repuesta"=>$this->input->post("repuesta"),"idTema"=>1);
		echo json_encode($this->P->registrarPregunta($data));
	}

	public function guardarFoto(){
		$this->load->model("Persona","P");
		$config['upload_path'] = 'uploads';
		$config['allowed_types'] = '*';
		$config['max_filename'] = '255';
		$config['encrypt_name'] = TRUE;
		$config['max_size'] = '1024'; //1 MB

		$this->load->library('upload', $config);
		if($this->upload->do_upload('foto')){
			echo json_encode($this->P->actualizarFoto($this->upload->data('file_name')));
		}else{
			echo json_encode(false);
		}
	}

}
