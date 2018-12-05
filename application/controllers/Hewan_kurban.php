<?php
	defined('BASEPATH') or exit('ERROR');

	class Hewan_kurban extends CI_controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('Lap_kurban_model');

		}
		public function index(){
			if(isset($_SESSION['username'])){
            if($this->input->post('t1')=="" && $this->input->post('t2')==""){
                $data['t1'] = date("01-F-Y");
                $data['t2'] = date("t-F-Y");
                $date1 = date_create($data['t1']);
                $date2 = date_create($data['t2']);
                $t1 = date_format($date1, "Ymd");
                $t2 = date_format($date2, "Ymd");
                $data['data'] = $this->Lap_kurban_model->sel_date($t1,$t2)->result();
                $this->load->view('lap_hewan_kurban_view',$data);
            }
            else{
                $data['t1'] = $this->input->post('t1');
                $data['t2'] = $this->input->post('t2');
                $date1 = date_create($data['t1']);
                $date2 = date_create($data['t2']);
                $t1 = date_format($date1, "Ymd");
                $t2 = date_format($date2, "Ymd");
                $data['data'] = $this->Lap_kurban_model->sel_date($t1,$t2)->result();
                $this->load->view('lap_hewan_kurban_view',$data);
            }
   
        }
        else{
            redirect(site_url().'/Auth/logout');
        }
    }
     
    public function laporan_print($t1,$t2)
    {
        $c1 = date_create($t1);
        $c2 = date_create($t2);
        $tgl1 = date_format($c1, "Ymd");
        $tgl2 = date_format($c2, "Ymd");
        $data['t1'] = $t1;
        $data['t2'] = $t2;
        $data['data'] = $this->Lap_kurban_model->sel_date($tgl1,$tgl2)->result();
        $this->load->view('prints/hewan_print',$data);
    }

    public function aksi()
    {
        $action = $this->input->post('action');
        $nomor = $this->input->post('idKurban');
        $id = $this->input->post('id_admin');
        $penyumbang = $this->input->post('penyumbang');
        $alamat = $this->input->post('alamat');
        $jenisHewan = $this->input->post('jenisHewan');
        $jumlah = $this->input->post('jumlah');
        $log_time = date('Y-m-d H:i:s');
        $tanggal = date('Y-m-d');
        
        if($action == 'add'){
            $data = array(
                'id_admin' => $_SESSION['id_admin'],
                'tanggal' => $tanggal,
                'penyumbang' => htmlsspecialchars($penyumbang),
                'alamat' => htmlsspecialchars($alamat),
                'jenis' => $jenisHewan,
                'jumlah' => htmlsspecialchars($jumlah),
                'log_time' => $log_time
            );

            $this->Lap_kurban_model->insert_data('hewan_kurban',$data);
            redirect(site_url('Hewan_kurban'));
        }else{
            $id = $nomor;
            $data = array(
                'penyumbang' => htmlsspecialchars($penyumbang),
                'alamat' => htmlsspecialchars($alamat),
                'jenis' => $jenisHewan,
                'jumlah' => htmlsspecialchars($jumlah)
            );
            $this->Lap_kurban_model->update_data('hewan_kurban',$data,$nomor);
            redirect(site_url('Hewan_kurban'));
        }
    }
    
    public function hapus($id)
    {
        $this->Lap_kurban_model->delete_data('hewan_kurban',$id);
        redirect(site_url('Hewan_kurban'));
    }
 }
?>