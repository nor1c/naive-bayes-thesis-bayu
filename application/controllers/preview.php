<?php

class Preview extends MY_Controller {
    private $searchableFields = ['no_job', 'kode', 'judul', 'penulis'];

	public function __construct() {
		parent::__construct();
		$this->load->model('Preview_model');
	}

	/**
	 * Step 1
	 * Pada step 1 hanya menampilkan data awal peserta
	 * Belum ada pengolahan apapun pada step ini, hanya bersifat starting point sebagai overview
	 */
	public function pengumpulan() {
		$data['page'] = 'preview/pengumpulan';

		// get propinsi
		$propinsi = $this->db->select('DISTINCT(propinsi) as propinsi')->from('mapping')->order_by('propinsi', 'ASC')->get()->result_array();
		$data['propinsi'] = $propinsi;

		// get mapel
		$mapel = $this->db->select('DISTINCT(mapel) as mapel')->from('data')->where('mapel !=', '')->order_by('mapel', 'ASC')->get()->result_array();
		$data['mapel'] = $mapel;

		$this->load->view('templates', $data);
	}

	/**
	 * Step 2
	 * Penyaringan Data
	 * Pada step ini, dilakukan proses data cleansing
	 * Dengan kriteria:
	 * - Menghapus NIK != 16 digit
	 * - Menghapus No. UKG != 12 digit
	 * - Menghapus duplikasi data
	 * - Menghapus data yang tidak memiliki NPSN
	 * - Pengecekan batas usia dengan mencocokkan tanggal lahir
	 * - Menghapus mata pelajaran selain: Akuntansi, Administrati Profesional/OTKP, Bisnis Daring Pemasaran, Tata Boga, Perhotelan, Tata Busana, Usaha Perjalanan Wisata, Kecantikan, Pekerjaan Sosial
	 * - Menghapus yang tidak memiliki instansi, no. handphone dan alamat email
	 */
	public function penyaringan() {
		$data['page'] = 'preview/penyaringan';

		// get propinsi
		$propinsi = $this->db->select('DISTINCT(propinsi) as propinsi')->from('mapping')->order_by('propinsi', 'ASC')->get()->result_array();
		$data['propinsi'] = $propinsi;

		// get mapel
		$mapel = $this->db->select('DISTINCT(mapel) as mapel')->from('data')->where('mapel !=', '')->order_by('mapel', 'ASC')->get()->result_array();
		$data['mapel'] = $mapel;

		$this->load->view('templates', $data);
	}

	/**
	 * Step 3
	 * SIMPKB Mapel
	 * Pada step ini dilakukan proses pengecekan apakah Mata Pelajaran masing-masing peserta sesuai dengan yang ada pada data SIMPKB
	 */
	public function penggabungan_dapodik() {
		$data['page'] = 'preview/penggabungan_dapodik';

		// get propinsi
		$propinsi = $this->db->select('DISTINCT(propinsi) as propinsi')->from('mapping')->order_by('propinsi', 'ASC')->get()->result_array();
		$data['propinsi'] = $propinsi;

		// get mapel
		$mapel = $this->db->select('DISTINCT(mapel) as mapel')->from('data')->where('mapel !=', '')->order_by('mapel', 'ASC')->get()->result_array();
		$data['mapel'] = $mapel;

		$this->load->view('templates', $data);
	}

	/**
	 * Step 4 (final)
	 * Ini merupakan step final, yang mana telah dilakukan proses mapping berdasarkan Propinsi dan Mata Pelajaran sesuai persyaratan kualifikasi pada file pemetaan
	 */
	public function index() {
		$data['page'] = 'preview/index';

		// get propinsi
		$propinsi = $this->db->select('DISTINCT(propinsi) as propinsi')->from('mapping')->order_by('propinsi', 'ASC')->get()->result_array();
		$data['propinsi'] = $propinsi;

		// get mapel
		$mapel = $this->db->select('DISTINCT(mapel) as mapel')->from('data')->where('mapel !=', '')->order_by('mapel', 'ASC')->get()->result_array();
		$data['mapel'] = $mapel;

		$this->load->view('templates', $data);
	}

	public function data_step_1() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getDataStep1($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [$item['no'], $item['nama'], $item['nik'], $item['no_ukg'], $item['nuptk'], $item['npsn'], $item['mapel'], $item['no_hp'], $item['email'], $item['status']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function data_step_2() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getDataStep2($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [$item['no'], $item['nama'], $item['nik'], $item['no_ukg'], $item['nuptk'], $item['npsn'], $item['mapel'], $item['no_hp'], $item['email'], $item['status']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function data_step_3() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getDataStep3($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [$item['no'], $item['nama'], $item['nik'], $item['no_ukg'], $item['nuptk'], $item['npsn'], $item['mapel'], $item['no_hp'], $item['email'], $item['usia'], $item['propinsi'], $item['status']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function data() {
		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getData($this->searchableFields, $pagination, $propinsi, $mapel);

        $formattedData = array_map(function ($item) {
			return ['', $item['nama'], $item['nik'], $item['no_ukg'], $item['nuptk'], $item['npsn'], $item['propinsi'], /*$item['instansi'],*/ $item['mapel'], $item['status']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function pemecahan_mapel_dapodik() {
		$data['page'] = 'preview/pemecahan_mapel_dapodik';

		// get propinsi
		$propinsi = $this->db->select('DISTINCT(propinsi) as propinsi')->from('mapping')->order_by('propinsi', 'ASC')->get()->result_array();
		$data['propinsi'] = $propinsi;

		// get mapel
		$mapel = $this->db->select('DISTINCT(mapel) as mapel')->from('data')->where('mapel !=', '')->order_by('mapel', 'ASC')->get()->result_array();
		$data['mapel'] = $mapel;

		$this->load->view('templates', $data);
	}

	public function data_pemecahan_mapel_dapodik() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getDataPemecahanMapelDapodik($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [$item['no'], $item['nama'], $item['nik'], $item['no_ukg'], $item['nuptk'], $item['npsn'], $item['mapel'], $item['no_hp'], $item['email'], $item['usia'], $item['propinsi']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function pengecekan_mapel_dapodik() {
		$data['page'] = 'preview/pengecekan_mapel_dapodik';

		// get propinsi
		$propinsi = $this->db->select('DISTINCT(propinsi) as propinsi')->from('mapping')->order_by('propinsi', 'ASC')->get()->result_array();
		$data['propinsi'] = $propinsi;

		// get mapel
		$mapel = $this->db->select('DISTINCT(mapel) as mapel')->from('data')->where('mapel !=', '')->order_by('mapel', 'ASC')->get()->result_array();
		$data['mapel'] = $mapel;

		$this->load->view('templates', $data);
	}

	public function data_pengecekan_mapel_dapodik() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getDataPengecekanMapelDapodik($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [$item['no'], $item['nama'], $item['nik'], $item['no_ukg'], $item['nuptk'], $item['npsn'], $item['mapel'], $item['mapel_bispar'], $item['no_hp'], $item['email'], $item['usia'], $item['propinsi'], $item['mapel'] == trim($item['mapel_bispar']) ? '1' : '0'];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function hasil_pengecekan_mapel_dapodik() {
		$data['page'] = 'preview/hasil_pengecekan_mapel_dapodik';

		// get propinsi
		$propinsi = $this->db->select('DISTINCT(propinsi) as propinsi')->from('mapping')->order_by('propinsi', 'ASC')->get()->result_array();
		$data['propinsi'] = $propinsi;

		// get mapel
		$mapel = $this->db->select('DISTINCT(mapel) as mapel')->from('data')->where('mapel !=', '')->order_by('mapel', 'ASC')->get()->result_array();
		$data['mapel'] = $mapel;

		$this->load->view('templates', $data);
	}

	public function data_hasil_pengecekan_mapel_dapodik() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getDataHasilPengecekanMapelDapodik($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [$item['no'], $item['nama'], $item['nik'], $item['no_ukg'], $item['nuptk'], $item['npsn'], $item['mapel'], $item['no_hp'], $item['email'], $item['usia'], $item['propinsi']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function penggabungan_data_after_mapel() {
		$data['page'] = 'preview/penggabungan_data_after_mapel';

		// get propinsi
		$propinsi = $this->db->select('DISTINCT(propinsi) as propinsi')->from('mapping')->order_by('propinsi', 'ASC')->get()->result_array();
		$data['propinsi'] = $propinsi;

		// get mapel
		$mapel = $this->db->select('DISTINCT(mapel) as mapel')->from('data')->where('mapel !=', '')->order_by('mapel', 'ASC')->get()->result_array();
		$data['mapel'] = $mapel;

		$this->load->view('templates', $data);
	}

	public function data_penggabungan_data_after_mapel() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getDataPenggabunganDataAfterMapel($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [$item['no'], $item['nama'], $item['nik'], $item['no_ukg'], $item['nuptk'], $item['npsn'], $item['mapel'], $item['no_hp'], $item['email'], $item['usia'], $item['propinsi']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function pemetaan() {
		$data['page'] = 'preview/pemetaan';

		// get propinsi
		$propinsi = $this->db->select('DISTINCT(propinsi) as propinsi')->from('mapping')->order_by('propinsi', 'ASC')->get()->result_array();
		$data['propinsi'] = $propinsi;

		// get mapel
		$mapel = $this->db->select('DISTINCT(mapel) as mapel')->from('data')->where('mapel !=', '')->order_by('mapel', 'ASC')->get()->result_array();
		$data['mapel'] = $mapel;

		$this->load->view('templates', $data);
	}

	public function data_pemetaan() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getDataPemetaan($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [$item['no'], $item['nama'], $item['nik'], $item['no_ukg'], $item['nuptk'], $item['npsn'], $item['mapel'], $item['no_hp'], $item['email'], $item['usia'], $item['propinsi']];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}
}
