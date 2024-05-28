<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use Phpml\Classification\NaiveBayes;

class Preview extends MY_Controller {
    private $searchableFields = ['no_job', 'kode', 'judul', 'penulis'];
	private $mapels = array(
		'Administrasi Profesional/OTKP',
		'Akuntansi',
		'Bisnis Daring Pemasaran',
		'Caregiver',
		'Kecantikan',
		'Pekerjaan Sosial',
		'Perhotelan',
		'Tata Boga',
		'Tata Busana',
		'Usaha Perjalanan Wisata',
	);

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
        $mapel = $this->input->post('mapel');
        $pb = $this->input->post('pb');
		
		// 
		$data_pb = $this->get_pemetaan_classes_each_mapel($mapel, $pb);

		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $data_pb['take_from'],
            'length' => $data_pb['need']
        );

        $naskah = $this->Preview_model->getDataPemetaan($this->searchableFields, $pagination, $mapel, $pb, $data_pb['pb_prov'], $searchKeyword);

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

	public function data_pemetaan_cadangan() {
        $mapel = $this->input->post('mapel');
        $pb = $this->input->post('pb');
		
		// 
		$data_pb = $this->get_pemetaan_classes_each_mapel($mapel, $pb);

		$searchKeyword = $this->input->post('search')['value'];

		// echo json_encode($data_pb); die;

		$pagination = array(
            'start' => $data_pb['cadangan_from'],
            'length' => $data_pb['cadangan_need']
        );

        $naskah = $this->Preview_model->getDataPemetaan($this->searchableFields, $pagination, $mapel, $pb, $data_pb['pb_prov'], $searchKeyword);

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

	public function get_pemetaan_classes($mapel) {
		$pb_sekolah = $this->Preview_model->getPemetaanClassEachMapel($mapel);

		$classes = [];
		foreach ($pb_sekolah as $sekolah) {
			$pb_total = count(json_decode($sekolah['pb_sekolah']));
			foreach (json_decode($sekolah['pb_sekolah']) as $pb_idx => $pbs) {
				$need = $sekolah['jumlah'] / $pb_total;
				$cadangan_need = $sekolah['cadangan'] / $pb_total;
				$start = (($pb_idx)*$need)+1;
				$cadangan_start = $sekolah['jumlah']+((($pb_idx)*$cadangan_need)+1);

				if ($pb_total > 1) {
					$end = ($pb_idx+1)*$need;
					$cadangan_end = $sekolah['jumlah']+(($pb_idx+1)*$cadangan_need);
				} else {
					$end = $pb_idx+$need;
					$cadangan_end = $sekolah['jumlah']+($pb_idx+$cadangan_need);
				}

				array_push($classes, array(
					'mapel' => $mapel,
					'pb' => $pbs,
					// 'original_need' => $sekolah['jumlah'],
					'cadangan_need' => $cadangan_need,
					'need' => $need,
					// 'propinsi' => $sekolah['propinsi'],
					'pb_prov' => $sekolah['pb_prov'],
					// 'pb_idx' => $pb_idx,
					'take_from' => $start,
					'take_to' => $end,
					'cadangan_from' => $cadangan_start,
					'cadangan_to' => $cadangan_end,
				));
			}
		}

		return $classes;
	}

	public function get_pb_list_each_mapel() {
		$mapel = $this->input->get('mapel');
		
		$classes = $this->get_pemetaan_classes($mapel);

		echo json_encode($classes);
	}

	public function get_pemetaan_classes_each_mapel($mapelParam = '', $pbParam = '') {
		$mapel = $mapelParam != '' ? $mapelParam : $this->input->get('mapel');
		$pb = $pbParam != '' ? $pbParam : $this->input->get('pb');

		$classes = $this->get_pemetaan_classes($mapel);

		$selKey = 0;
		$data = array_filter($classes, function($class) use ($mapel, $pb) {
			return $class['mapel'] == $mapel && $class['pb'] == $pb;
		});

		$selectedData = null;
		foreach ($data as $item) {
			$selectedData = $item;
			break;
		}

		return $selectedData;
	}

	public function export_data() {
		$classes = [];
		foreach ($this->mapels as $mapel) {
			$mapel_classes = $this->get_pemetaan_classes($mapel);
			$classes[$mapel] = $mapel_classes;
		}
		
		return $classes;
	}

	public function convertToArray($data) {
		if (is_object($data)) {
			// Convert object to array
			$data = (array)$data;
		}
		
		if (is_array($data)) {
			// Recursively apply conversion to each element
			foreach ($data as &$element) {
				$element = $this->convertToArray($element);
			}
		}
		
		return $data;
	}

    private function createExcelFile($filename, $sheets) {
		$spreadsheet = new Spreadsheet();
	
		$sheetIndex = 0;
		foreach ($sheets as $sheetName => $data) {
			if ($sheetIndex > 0) {
				$spreadsheet->createSheet();
			}
			$spreadsheet->setActiveSheetIndex($sheetIndex);
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setTitle($sheetName);

			$sheet->getStyle('C')->getNumberFormat()->setFormatCode('0');
			$sheet->getStyle('A7:F7')->getFont()->setBold(true);
			$sheet->getStyle('A7:F7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('d9e3f2');
			
			$sheet->getColumnDimension('B')->setWidth(30);
			$sheet->getColumnDimension('C')->setWidth(14);
			$sheet->getColumnDimension('D')->setWidth(25);
			$sheet->getColumnDimension('E')->setWidth(20);
			$sheet->getColumnDimension('F')->setWidth(18);
	
			$pass_cadangan = false;
			$pass_no_after_cadangan = false;
			foreach ($data as $cell => $value) {
				if (is_array($value) && strpos($cell, ':')) {
					// Handle ranges
					$range = explode(':', $cell);
					$startCell = $range[0];
					$sheet->fromArray($value, null, $startCell);

					if ($value != '') {
						$sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color(Color::COLOR_BLACK));
					}

					if ($pass_cadangan && !$pass_no_after_cadangan) {
						$pass_no_after_cadangan = true;

						$sheet->getStyle($cell)->getFont()->setBold(true);
						$sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('d9e3f2');
					}
				} else {
					// Handle single cell
					$sheet->setCellValue($cell, $value);

					if ($value != '') {
						$sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color(Color::COLOR_BLACK));
					}

					if ($value == 'CADANGAN') {
						$pass_cadangan = true;
						$sheet->getStyle($cell)->getFont()->setBold(true);
					}
				}
			}
	
			$sheetIndex++;
		}
	
		// Set the first sheet as the active sheet
		$spreadsheet->setActiveSheetIndex(0);
	
		$writer = new Xlsx($spreadsheet);
		$writer->save($filename);
	}

	public function export() {
		// Temporary directory to store the Excel files
		$tempDir = sys_get_temp_dir() . '/excel_files/';
		if (!is_dir($tempDir)) {
			mkdir($tempDir, 0777, true);
		}

		
		$init_data = $this->export_data();
		$excel_data = [];
	
		// Define data with customizable cell positions
		$fileData = [];

		$no = 1;
		foreach ($init_data as $mapel_name => $pb) {
			$filename = str_replace('/', '_', $mapel_name) . ".xlsx";
			$sheets = [];

			$no_sheet = 1;
			foreach ($pb as $pb_data) {
				$sheetName = substr(str_replace('/', '_', $pb_data['pb']), 0, 31);

				$peserta = $this->Preview_model->getPesertaEachMapelAndPb($mapel_name, $pb_data['pb_prov'], $pb_data['need'], $pb_data['take_from']);

				$ppp = [];
				foreach ($peserta as $i => $p) {
					array_push($ppp, array(
						$i+1,
						$p['nama'],
						$p['no_ukg'],
						strtoupper($p['instansi']),
						str_replace('Prov. ', '', $p['propinsi']),
						$p['no_hp'],
					));
				}

				// get cadangan list
				$cadangan = $this->Preview_model->getPesertaEachMapelAndPb($mapel_name, $pb_data['pb_prov'], $pb_data['cadangan_need'], $pb_data['cadangan_from']);
				// echo json_encode($cadangan); die;

				$list_cadangan = [];
				$start_cadangan_cell_num = 8+$pb_data['need'];
				foreach ($cadangan as $i => $c) {
					$start_cadangan_cell_num+=1;
					array_push($list_cadangan, array(
						$i+1,
						$c['nama'],
						$c['no_ukg'],
						strtoupper($c['instansi']),
						str_replace('Prov. ', '', $c['propinsi']),
						$c['no_hp'],
					));
				}

				$sheetData = [
					'A2' => 'PROGLI',
					'B2' => ': ' . $pb_data['mapel'],
					'A3' => 'GEL',
					'B3' => ': 1',
					'A4' => 'KELAS',
					'B4' => ': A',
					'A5' => 'PB',
					'B5' => ': ' . $pb_data['pb'],
					'A7:F7' => ['No.', 'Nama', 'No. UKG', 'Instansi', 'Propinsi', 'No Handphone'],
					'A8:F'.(8+$pb_data['need']) => $ppp,
					'A'.((8+$pb_data['need'])+1) => 'CADANGAN',
					'A'.((8+$pb_data['need'])+2).':F'.((8+$pb_data['need'])+2) => ['No.', 'Nama', 'No. UKG', 'Instansi', 'Propinsi', 'No Handphone'],
					'A'.((8+$pb_data['need'])+3).':F'.(((8+$pb_data['need'])+3)+$pb_data['cadangan_need']) => $list_cadangan,
				];
				$sheets[$sheetName] = $sheetData;

				$no_sheet++;
			}
	
			$fileData[$filename] = $sheets;

			$no++;
		}
		// echo json_encode($fileData); die;
	
		// // Example loop to generate file data dynamically
		// for ($i = 1; $i <= 5; $i++) {
		// 	$filename = "file{$i}.xlsx";
		// 	$sheets = [];
	
		// 	// Generate sheets data
		// 	for ($j = 1; $j <= 2; $j++) {
		// 		$sheetName = "Sheet{$j}";
		// 		$sheetData = [
		// 			'A2' => "PROGLI - File {$i}, Sheet {$j}",
		// 			'A3' => 'GEL',
		// 			'A4' => 'KELAS',
		// 			'A5' => 'PB',
		// 			'A7:F7' => ['Header1', 'Header2', 'Header3', 'Header4', 'Header5', 'Header6'],
		// 			'A8:F27' => [
		// 				['Row1-Col1', 'Row1-Col2', 'Row1-Col3', 'Row1-Col4', 'Row1-Col5', 'Row1-Col6'],
		// 				['Row2-Col1', 'Row2-Col2', 'Row2-Col3', 'Row2-Col4', 'Row2-Col5', 'Row2-Col6'],
		// 				// Add more rows as needed
		// 			]
		// 		];
		// 		$sheets[$sheetName] = $sheetData;
		// 	}
	
		// 	$fileData[$filename] = $sheets;
		// }
	
		// Create Excel files
		foreach ($fileData as $filename => $sheets) {
			$this->createExcelFile($tempDir . $filename, $sheets);
		}
	
		// Create a ZIP archive
		$zipFilename = $tempDir . 'excel_files.zip';
		$zip = new ZipArchive();
		if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
			exit("Cannot open <$zipFilename>\n");
		}
	
		// Add Excel files to the ZIP archive
		foreach ($fileData as $filename => $sheets) {
			$zip->addFile($tempDir . $filename, $filename);
		}
	
		$zip->close();
	
		// Serve the ZIP file for download
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="PEMETAAN.zip"');
		header('Content-Length: ' . filesize($zipFilename));
	
		readfile($zipFilename);
	
		// Clean up temporary files
		foreach ($fileData as $filename => $sheets) {
			unlink($tempDir . $filename);
		}
		unlink($zipFilename);
		rmdir($tempDir);
	
		exit();
	}
}
