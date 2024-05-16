<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use Phpml\Classification\NaiveBayes;

class Thesis extends MY_Controller {
    private $searchableFields = ['no_job', 'kode', 'judul', 'penulis'];

	public function __construct() {
		parent::__construct();
		$this->load->model(array('Preview_model'));
	}

	public function index() {
		if ($this->session->userdata('authorized')) {
			$data['page'] = 'index';
	
			$this->load->view('templates', $data);
		} else {
			redirect('login');
		}
	}

	public function import_peserta() {
		if ($this->session->userdata('authorized')) {
			$data['page'] = 'import_peserta';
	
			$this->load->view('templates', $data);
		} else {
			redirect('login');
		}
	}

	public function transformasi_data() {
		if ($this->session->userdata('authorized')) {
			$data['page'] = 'preview/transformasi_data';
	
			$this->load->view('templates', $data);
		} else {
			redirect('login');
		}
	}

	public function data_prepare_training() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getPraTrainingData($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [
				$item['no'],
				$item['nama'],
				strlen($item['nik']) == 16 ? 'Sesuai' : 'Tidak Sesuai', 
				strlen($item['no_ukg']) == 12 ? 'Sesuai' : 'Tidak Sesuai',
				strlen($item['nuptk']) == 16 ? 'Sesuai' : 'Tidak Sesuai',
				strlen($item['npsn']) == 8 ? 'Sesuai' : 'Tidak Sesuai',
				strlen($item['mapel']) > 0 && $item['mapel'] != 'Desain Fesyen' && $item['mapel'] != 'Spa dan Beauty Therapy' && $item['mapel'] != 'Wisata Bahari Dan Ekowisata' ? $item['mapel'] : 'Tidak Sesuai',
				strlen($item['no_hp']) >= 8 || filter_var($item['email'], FILTER_VALIDATE_EMAIL) ? 'Sesuai' : 'Tidak Sesuai',
				$item['usia'] && $item['usia'] <= 55 ? 'Sesuai' : 'Tidak Sesuai',
				strlen($item['propinsi']) > 0 && $item['propinsi'] != 'Luar Negeri' ? $item['propinsi'] : 'Tidak Sesuai',
				$item['status'],
			];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function persiapan_training() {
		if ($this->session->userdata('authorized')) {
			$data['page'] = 'preview/persiapan_training';

			$data['total_data_peserta'] = $this->db->query("SELECT COUNT(*) as total FROM data")->row()->total;
	
			$this->load->view('templates', $data);
		} else {
			redirect('login');
		}
	}

	public function importMasterData() {
		$config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'csv';

        $this->load->library('upload', $config);

		// pengolahan data pemetaan
		if (!$this->upload->do_upload('data_pemetaan')) {
			$error = $this->upload->display_errors();
			echo json_encode(array(
				'error' => true,
				'message' => $error,
			));
		} else {
			$fileData = $this->upload->data();
			$filePath = $fileData['full_path'];
			
			// consume and insert data pemetaan ke database
			$this->consumeDataPemetaan($filePath);
			
			// // pengolahan data master data (dapodik)
			// if (!$this->upload->do_upload('master_data')) {
			// 	$error = $this->upload->display_errors();
			// 	echo json_encode(array(
			// 		'error' => true,
			// 		'message' => $error,
			// 	));
			// } else {
			// 	$fileData = $this->upload->data();
			// 	$filePath = $fileData['full_path'];
	
			// 	// import data master ke database
			// 	$this->import($filePath, 'master');
	
			// 	// import data peserta
			// 	if (!$this->upload->do_upload('data_mentah')) {
			// 		$error = $this->upload->display_errors();
			// 		echo json_encode(array(
			// 			'error' => true,
			// 			'message' => $error,
			// 		));
			// 	} else {
			// 		$fileData = $this->upload->data();
			// 		$filePath = $fileData['full_path'];
		
			// 		// // (no logic) import data peserta ke database
			// 		// $reader = new Csv();
			// 		// $spreadsheet = $reader->load($filePath);
			// 		// $data = $spreadsheet->getActiveSheet()->toArray();
			// 		// $headers = array_shift($data);
			// 		// array_push($headers, 'status');

			// 		$data_mentah = $this->import($filePath, 'data');
	
			// 		// (with logic) klasifikasi menggunakan algoritma naive bayes dan import hasil akhir peserta ke database
			// 		// $this->consumeWithMachineLearning($headers, $data_mentah);
	
			// 		// join data peserta dengan data dapodik
			// 		// $this->mergePesertaWithDapodik();
	
			// 		redirect('thesis/persiapan_training');
			// 	}
			// }
		}
	}

	public function import($filePath, $db_name) {
		$reader = new Csv();
        $spreadsheet = $reader->load($filePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        // if ($is_master_data) {
			$headers = array_shift($data);

			$this->insertToDb($headers, $data, $db_name);
		// }

		return $data;
	}

	public function insertToDb($headers, $data, $db_name) {
		$this->db->query("TRUNCATE $db_name");
		
		foreach ($data as $row) {
			// // cleansing no_ukg di data peserta
			if ($db_name == 'data') {
			// 	$row[3] = (int)str_replace(array("@guruku.id", "@guru.id", "*"), "", $row[3]);

				// translate mapel peserta sesuai mapel data master
				if ($row[7] == 'Kecantikan Kulit' || $row[7] == 'Kecantikan Rambut') {
					$row[7] = 'Kecantikan';
				} else if ($row[7] == 'Social Care') {
					$row[7] = 'Pekerjaan Sosial';
				}
			}

			// if ($db_name == 'master') {
			// 	// remove "Prov. " dari nama propinsi data master
			// 	$row[11] = str_replace("Prov. ", "", $row[11]);

			// // translate mapel peserta ke mapel data mapping
			// if ($row[10] == 'Kecantikan Kulit' || $row[10] == 'Kecantikan Rambut') {
			// 	$row[10] = 'Kecantikan';
			// } else if ($row[10] == 'Social Care') {
			// 	$row[10] = 'Pekerjaan Sosial';
			// }
			// }

			$data = array_combine($headers, $row);

			$this->db->insert($db_name, $data);
		}
	}

	public function consumeWithMachineLearning($headers, $data_mentah) {
		$final_data = array();
		foreach ($data_mentah as $index => $row) {
			$parameter_benar = 0;
			$parameter_salah = 0;

			$row[3] = str_replace(array("@guruku.id", "@guru.id", "*"), "", $row[3]);

			if ($index > 0) {
				// // klasifikasi nik
				// if (!in_array($row[2], array('', '-', '0'))) {
				// 	$parameter_benar += 1;
				// } else {
				// 	$parameter_salah += 1;
				// }

				// klasifikasi no UKG
				if ($this->countDigit(strval($row[3])) < 12 || $this->countDigit(strval($row[3])) > 12 || $row[3] == null || $row[3] == '-' || $row[3] == 0 || ctype_alpha($row[3])) {
					$parameter_salah += 1;
				} else {
					$parameter_benar += 1;
				}

				// klasifikasi no UPTK
				if ($this->countDigit(strval($row[4])) < 16 || $this->countDigit(strval($row[4])) > 16 || $row[4] == null || $row[4] == '-' || $row[4] == 0 || ctype_alpha($row[4])) {
					$parameter_salah += 1;
				} else {
					$parameter_benar += 1;
				}

				// klasifikasi NPSN
				if ($this->countDigit(strval($row[5])) < 8 || $this->countDigit(strval($row[5])) > 8 || $row[5] == null || $row[5] == '-' || $row[5] == 0 || ctype_alpha($row[5])) {
					$parameter_salah += 1;
				} else {
					$parameter_benar += 1;
				}

				// // klasifikasi mapel
				// if (!in_array($row[7], array('', '-', '0'))) {
				// 	$parameter_benar += 1;
				// } else {
				// 	$parameter_salah += 1;
				// }

				// hasil klasifikasi
				$jumlah_variable_klasifikasi = 3;
				
				// mendapatkan nilai true positive
				$tp = $parameter_benar/$jumlah_variable_klasifikasi;

				// mendapatkan nilai true negative
				$tn = $parameter_salah/$jumlah_variable_klasifikasi;

				// final result naive bayes berdasarkan jumlah TP dan TN
				if ($tp > $tn) {
					$row[10] = 'Layak';
				} else {
					$row[10] = 'Tidak Layak';
				}

				array_push($final_data, $row);
			}
		}

		$this->insertToDb($headers, $final_data, 'data');
	}

	// public function consumeWithMachineLearning($data_mentah) {
	// 	$headers = array_shift($data_mentah);

	// 	$data_tidak_sesuai_ukgs = array();
	// 	foreach ($data_mentah as $index => $row) {
	// 		$row[3] = str_replace(array("@guruku.id", "@guru.id", "*"), "", $row[3]);

	// 		if ($index > 0) {
	// 			array_push($data_tidak_sesuai_ukgs, array($this->countDigit($row[3]) < 10 || $this->countDigit($row[3]) > 16 || $row[3] == null || $row[3] == '-' || ctype_alpha($row[3]) ? 0 : (int)$row[3]));
	// 		}
	// 	}

	// 	$cleansing_result = $this->cleanMissingUkg($data_tidak_sesuai_ukgs);

	// 	$clean_data = array();
	// 	foreach ($cleansing_result as $index => $row) {
	// 		if ($row == 'good') {
	// 			array_push($clean_data, $data_mentah[$index+1]);
	// 		}
	// 	}
		
	// 	$this->insertToDb($headers, $clean_data, 'data');
	// }

	// // gunakan machine learning naive bayes untuk klasifikasi data benar dan salah
	// public function cleanMissingUkg($data) {
	// 	// train data
	// 	$samples = [
	// 		[0], ['abcdefghijklmnopqrstuvwxyz123456789'],
	// 	];
	// 	$labels = ['bad', 'good'];

	// 	$nb = new NaiveBayes();
	// 	$nb->train($samples, $labels);

	// 	// classify
	// 	$cleansing_result = $nb->predict($data);

	// 	return $cleansing_result;
	// }

	public function countDigit($inputString) {
		$digitCount = 0;
	
		for ($i = 0; $i < strlen($inputString); $i++) {
			if (ctype_digit($inputString[$i])) {
				$digitCount++;
			}
		}
	
		return $digitCount;
	}

	public function getKelas($data, $kp, $sp) {
		if (!empty($data[$kp][$sp])) {
			return $data[$kp][$sp];
		}

		if ($kp > 0) {
			return $this->getKelas($data, $kp - 1, $sp);
		}

		return null;
	}

	public function getPBProv($data, $kp, $sp) {
		if (!empty($data[$kp][$sp])) {
			return $data[$kp][$sp];
		}

		if ($kp > 0) {
			return $this->getPBProv($data, $kp - 1, $sp);
		}

		return null;
	}

	public function getPB($data, $kp, $sp) {
		if (!empty($data[$kp][$sp])) {
			return $data[$kp][$sp];
		}

		if ($kp > 0) {
			return $this->getPB($data, $kp - 1, $sp);
		}

		return null;
	}

	public function consumeDataPemetaan($filePath) {
		$reader = new Csv();
        $spreadsheet = $reader->load($filePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

		$jmlPropinsi = 34;

		// collect data mapel
		$headers = array_shift($data);
		$data_mapel = array();
		$starting_point = 4;
		foreach ($headers as $index => $row) {
			if ($index == $starting_point) {
				if (!in_array($row, array("", "JUMLAH"))) {
					array_push($data_mapel, array(
						'index' => $index,
						'mapel' => $row
					));
				
					$starting_point += 5;
				}
			}
		}

		// collect prov
		$data_prov = [];
		foreach ($data as $index => $row) {
			if ($row[1] != null) {
				array_push($data_prov, $row[1]);
			}
		}

		$data_pemetaan = array();

		foreach ($data_prov as $kp => $prov) {
			$sp = 4;
			$spbprov = 5;
			$spb = 6;
			$spm = 2;
			for ($i=0; $i <= 9; $i++) { 
				if ($headers[$spm] == 'JUMLAH') {
					$spm = 2;
				} else {
					$kelas = $this->getKelas($data, $kp, $sp);
					$pb_prov = $this->getPBProv($data, $kp, $spbprov);
					$pb = $this->getPB($data, $kp, $spb);
					// echo $prov . ' - ' . $headers[$spm] . ' - ' . $kelas . '<br>';
					array_push($data_pemetaan, array(
						'propinsi' => $prov,
						'pb_prov' => $pb_prov,
						'pb' => $pb,
						'mapel' => $headers[$spm],
						'jumlah' => $kelas*20,
						'cadangan' => $kelas*10,
					));
					$sp+=5;
					$spbprov+=5;
					$spb+=5;
					$spm+=5;
				}
			}
			// echo '<br>';
		}
		// echo json_encode($data_pemetaan); die;

		$data_construct = [];
		foreach ($data_pemetaan as $kdp => $dp) {
			$mapel = $dp['mapel'];
			$key = $dp['pb_prov'];
			$keypb = $dp['pb'];

			$data_construct[$mapel][$key]['jumlah'] = $dp['jumlah'];
			$data_construct[$mapel][$key]['cadangan'] = $dp['cadangan'];

			if (!isset($data_construct[$mapel])) {
				$data_construct[$mapel] = [];
			}
			
			if (!isset($data_construct[$mapel][$key]['provinces'])) {
				$data_construct[$mapel][$key]['provinces'] = [];
			}
			
			if (!isset($data_construct[$mapel][$key]['pb'])) {
				$data_construct[$mapel][$key]['pb'] = [];
			}
			
			// if (!isset($data_construct[$mapel][$key][$keypb]['pb'])) {
			// 	$data_construct[$mapel][$key][$keypb]['pb'] = [];
			// }

			// if (!in_array($dp['pb'], $data_construct[$mapel][$key][$keypb]['pb'])) {
			// 	array_push($data_construct[$mapel][$key][$keypb]['pb'], $dp['pb']);
			// }

			array_push($data_construct[$mapel][$key]['provinces'], 'Prov. ' . $dp['propinsi']);
			if (!in_array($dp['pb'], $data_construct[$mapel][$key]['pb'])) {
				array_push($data_construct[$mapel][$key]['pb'], $dp['pb']);
			}
		}
		echo json_encode($data_construct); die;

		$data_final = [];
		foreach ($data_construct as $mapel_key => $mapel) {
			foreach ($mapel as $prov_key => $prov) {
				// echo $dckey . '-' . $mpkey . $mapel['pb'] . '<br>';
				// echo $prov_key . '' . '' . $mapel_key . json_encode($prov) . '<br>';
				// foreach ($mapel as $prov_key => $prov) {
				// 	echo json_encode($prov) . '<br>';
					array_push($data_final, array(
						'mapel' => $mapel_key,
						'prov' => $prov_key,
						'provinces' => json_encode($prov['provinces']),
						'pb' => json_encode($prov['pb']),
						'jumlah' => $prov['jumlah'],
						'cadangan' => $prov['cadangan'],
					));
				// }
			}
		}
		// echo json_encode($data_final); die;

		// $sp = 4;
		// $spm = 2;

		// foreach ($data as $index => $row) {
		// 	if ($headers[$spm] == 'JUMLAH') {
		// 		echo '<br>';
		// 		$sp = 4;
		// 		$spm = 2;
		// 	}

		// 	// echo json_encode($row);
		// 	echo json_encode(array(
		// 		'prov' => $row[1],
		// 		'mapel' => $headers[$spm],
		// 		'kelas' => $row[$sp] == null ? $data[$index-1][$sp] : $row[$sp],
		// 	));
		// 	$sp+=5;
		// 	$spm+=5;
		// 	echo '<br>';
		// }
		// die;

		$this->insertToDb(
			array("mapel", "propinsi", "pb_prov", "pb_sekolah", "jumlah", "cadangan"),
			$data_final,
			"mapping"
		);
	}

	public function mergePesertaWithDapodik() {
		$query = "
			SELECT master.propinsi, master.mapel_bispar, data.no, data.nama, data.nik, data.no_ukg, data.nuptk, data.npsn, data.instansi
			FROM data
			LEFT JOIN master ON (data.nik=master.nik AND data.no_ukg=master.no_ukg)
			WHERE master.mapel_bispar IS NOT NULL
			ORDER BY master.propinsi, master.mapel_bispar, CAST(data.no AS SIGNED) ASC
		";

		$final_data = $this->db->query($query)->result_array();

		echo json_encode($final_data);
	}

	// blm kepake
	// public function export() {
	// 	$spreadsheet = new Spreadsheet();
	// 	$activeWorksheet = $spreadsheet->getActiveSheet();
	// 	$activeWorksheet->setCellValue('A1', 'Hello World!');

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'excel-report';
        
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
    //     header('Cache-Control: max-age=0');

    //     $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    //     $writer->save('php://output');
	// }

	public function probabilitas() {
		if ($this->session->userdata('authorized')) {
			$data['data'] = $this->training();
			$data['page'] = 'preview/hasil_probabilitas';
	
			$this->load->view('templates', $data);
		} else {
			redirect('login');
		}
	}

	public function training() {
		$limit = $this->input->post('limit') ?? 50;

		// gunakan data peserta dari database untuk step pengujian
		// beberapa fields yang akan digunakan probabilitasnya: NIK, No. UKG, NUPTK, NPSN, Usia, No. HP x Email, Mapel, Provinsi

		// ambil data peserta dari database
		$query = "SELECT 
					SUM(IF(nik = 'Sesuai' AND status = 'Layak', 1, 0)) AS nik_sesuai_c1,
					SUM(IF(nik = 'Sesuai' AND status = 'Tidak Layak', 1, 0)) AS nik_sesuai_c0,
					SUM(IF(nik = 'Tidak Sesuai' AND status = 'Layak', 1, 0)) AS nik_tidak_sesuai_c1,
					SUM(IF(nik = 'Tidak Sesuai' AND status = 'Tidak Layak', 1, 0)) AS nik_tidak_sesuai_c0,
					SUM(IF(no_ukg = 'Sesuai' AND status = 'Layak', 1, 0)) AS no_ukg_sesuai_c1,
					SUM(IF(no_ukg = 'Sesuai' AND status = 'Tidak Layak', 1, 0)) AS no_ukg_sesuai_c0,
					SUM(IF(no_ukg = 'Tidak Sesuai' AND status = 'Layak', 1, 0)) AS no_ukg_tidak_sesuai_c1,
					SUM(IF(no_ukg = 'Tidak Sesuai' AND status = 'Tidak Layak', 1, 0)) AS no_ukg_tidak_sesuai_c0,
					SUM(IF(nuptk = 'Sesuai' AND status = 'Layak', 1, 0)) AS nuptk_sesuai_c1,
					SUM(IF(nuptk = 'Sesuai' AND status = 'Tidak Layak', 1, 0)) AS nuptk_sesuai_c0,
					SUM(IF(nuptk = 'Tidak Sesuai' AND status = 'Layak', 1, 0)) AS nuptk_tidak_sesuai_c1,
					SUM(IF(nuptk = 'Tidak Sesuai' AND status = 'Tidak Layak', 1, 0)) AS nuptk_tidak_sesuai_c0,
					SUM(IF(npsn = 'Sesuai' AND status = 'Layak', 1, 0)) AS npsn_sesuai_c1,
					SUM(IF(npsn = 'Sesuai' AND status = 'Tidak Layak', 1, 0)) AS npsn_sesuai_c0,
					SUM(IF(npsn = 'Tidak Sesuai' AND status = 'Layak', 1, 0)) AS npsn_tidak_sesuai_c1,
					SUM(IF(npsn = 'Tidak Sesuai' AND status = 'Tidak Layak', 1, 0)) AS npsn_tidak_sesuai_c0,
					SUM(IF(no_hp_email = 'Sesuai' AND status = 'Layak', 1, 0)) AS no_hp_email_sesuai_c1,
					SUM(IF(no_hp_email = 'Sesuai' AND status = 'Tidak Layak', 1, 0)) AS no_hp_email_sesuai_c0,
					SUM(IF(no_hp_email = 'Tidak Sesuai' AND status = 'Layak', 1, 0)) AS no_hp_email_tidak_sesuai_c1,
					SUM(IF(no_hp_email = 'Tidak Sesuai' AND status = 'Tidak Layak', 1, 0)) AS no_hp_email_tidak_sesuai_c0,
					SUM(IF(age = 'Sesuai' AND status = 'Layak', 1, 0)) AS usia_sesuai_c1,
					SUM(IF(age = 'Sesuai' AND status = 'Tidak Layak', 1, 0)) AS usia_sesuai_c0,
					SUM(IF(age = 'Tidak Sesuai' AND status = 'Layak', 1, 0)) AS usia_tidak_sesuai_c1,
					SUM(IF(age = 'Tidak Sesuai' AND status = 'Tidak Layak', 1, 0)) AS usia_tidak_sesuai_c0,
					SUM(IF(status = 'Layak', 1, 0)) AS jml_Layak,
					SUM(IF(status = 'Tidak Layak', 1, 0)) AS jml_tidak_Layak
				FROM (
					SELECT 
						data.`no`, 
						data.nama, 
						IF(LENGTH(data.nik) = 16, 'Sesuai', 'Tidak Sesuai') AS nik,
						IF(LENGTH(data.no_ukg) = 12, 'Sesuai', 'Tidak Sesuai') AS no_ukg,
						IF(LENGTH(data.nuptk) = 16, 'Sesuai', 'Tidak Sesuai') AS nuptk,
						IF(LENGTH(data.npsn) = 8, 'Sesuai', 'Tidak Sesuai') AS npsn,
						IF (LENGTH(data.no_hp) > 8 OR LOCATE('@', data.email) > 0, 'Sesuai', 'Tidak Sesuai') AS no_hp_email,
						IF (FLOOR(DATEDIFF(NOW(), master.tgl_lahir) / 365.25) <= 55, 'Sesuai', 'Tidak Sesuai') AS age,
						data.mapel,
						master.propinsi,
						data.status
					FROM data
					LEFT JOIN master ON (master.nik=data.nik)
					ORDER BY data.no
					LIMIT $limit
				) AS derived_table_alias";

		$tn = $this->db->query($query)->row();

		$jml_data_layak = $tn->jml_Layak;
		$jml_data_tidak_layak = $tn->jml_tidak_Layak;
		$total_data = $jml_data_layak+$jml_data_tidak_layak;

		// ---------------------------------------------------------------------------------------------------------------------------------------------
		// Perhitungan probabilitas NIK
		// ---------------------------------------------------------------------------------------------------------------------------------------------
		// | NIK valid 	| Lulus | Tidak Lulus 	| Lulus (C1) 	| Tidak Lulus (C0) 	|
		// | Yes		| 1		| 2				| (1/3) 0.33	| (2/5) 0.4			|
		// | No 		| 2		| 3				| (2/3) 0.66	| (3/5) 0.6			|
		// | Jumlah		| 3		| 5				| 1				| 1					|
		$jml_nik_sesuai_c1 = $tn->nik_sesuai_c1;
		$jml_nik_sesuai_c0 = $tn->nik_sesuai_c0;
		$jml_nik_tidak_sesuai_c1 = $tn->nik_tidak_sesuai_c1;
		$jml_nik_tidak_sesuai_c0 = $tn->nik_tidak_sesuai_c0;

		// For NIK
		$probabilities['nik']['name'] = 'Probabilitas NIK';
		$probabilities['nik']['data'][0]['name'] = 'Sesuai';
		$probabilities['nik']['data'][0]['c1_total'] = $jml_nik_sesuai_c1;
		$probabilities['nik']['data'][0]['c0_total'] = $jml_nik_sesuai_c0;
		$probabilities['nik']['data'][0]['c1'] = round($jml_nik_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['nik']['data'][0]['c0'] = round($jml_nik_sesuai_c0/$jml_data_tidak_layak, 9999999999);
		
		$probabilities['nik']['data'][1]['name'] = 'Tidak Sesuai';
		$probabilities['nik']['data'][1]['c1_total'] = $jml_nik_tidak_sesuai_c1;
		$probabilities['nik']['data'][1]['c0_total'] = $jml_nik_tidak_sesuai_c0;
		$probabilities['nik']['data'][1]['c1'] = round($jml_nik_tidak_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['nik']['data'][1]['c0'] = round($jml_nik_tidak_sesuai_c0/$jml_data_tidak_layak, 9999999999);

		// For NO. UKG
		$jml_ukg_sesuai_c1 = $tn->no_ukg_sesuai_c1;
		$jml_ukg_sesuai_c0 = $tn->no_ukg_sesuai_c0;
		$jml_ukg_tidak_sesuai_c1 = $tn->no_ukg_tidak_sesuai_c1;
		$jml_ukg_tidak_sesuai_c0 = $tn->no_ukg_tidak_sesuai_c0;

		$probabilities['ukg']['name'] = 'Probabilitas No. UKG';
		$probabilities['ukg']['data'][0]['name'] = 'Sesuai';
		$probabilities['ukg']['data'][0]['c1_total'] = $jml_ukg_sesuai_c1;
		$probabilities['ukg']['data'][0]['c0_total'] = $jml_ukg_sesuai_c0;
		$probabilities['ukg']['data'][0]['c1'] = round($jml_ukg_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['ukg']['data'][0]['c0'] = round($jml_ukg_sesuai_c0/$jml_data_tidak_layak, 9999999999);
		
		$probabilities['ukg']['data'][1]['name'] = 'Tidak Sesuai';
		$probabilities['ukg']['data'][1]['c1_total'] = $jml_ukg_tidak_sesuai_c1;
		$probabilities['ukg']['data'][1]['c0_total'] = $jml_ukg_tidak_sesuai_c0;
		$probabilities['ukg']['data'][1]['c1'] = round($jml_ukg_tidak_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['ukg']['data'][1]['c0'] = round($jml_ukg_tidak_sesuai_c0/$jml_data_tidak_layak, 9999999999);

		// For NUPTK
		$jml_nuptk_sesuai_c1 = $tn->nuptk_sesuai_c1;
		$jml_nuptk_sesuai_c0 = $tn->nuptk_sesuai_c0;
		$jml_nuptk_tidak_sesuai_c1 = $tn->nuptk_tidak_sesuai_c1;
		$jml_nuptk_tidak_sesuai_c0 = $tn->nuptk_tidak_sesuai_c0;

		$probabilities['nuptk']['name'] = 'Probabilitas NUPTK';
		$probabilities['nuptk']['data'][0]['name'] = 'Sesuai';
		$probabilities['nuptk']['data'][0]['c1_total'] = $jml_nuptk_sesuai_c1;
		$probabilities['nuptk']['data'][0]['c0_total'] = $jml_nuptk_sesuai_c0;
		$probabilities['nuptk']['data'][0]['c1'] = round($jml_nuptk_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['nuptk']['data'][0]['c0'] = round($jml_nuptk_sesuai_c0/$jml_data_tidak_layak, 9999999999);
		
		$probabilities['nuptk']['data'][1]['name'] = 'Tidak Sesuai';
		$probabilities['nuptk']['data'][1]['c1_total'] = $jml_nuptk_tidak_sesuai_c1;
		$probabilities['nuptk']['data'][1]['c0_total'] = $jml_nuptk_tidak_sesuai_c0;
		$probabilities['nuptk']['data'][1]['c1'] = round($jml_nuptk_tidak_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['nuptk']['data'][1]['c0'] = round($jml_nuptk_tidak_sesuai_c0/$jml_data_tidak_layak, 9999999999);

		// For NPSN
		$jml_npsn_sesuai_c1 = $tn->npsn_sesuai_c1;
		$jml_npsn_sesuai_c0 = $tn->npsn_sesuai_c0;
		$jml_npsn_tidak_sesuai_c1 = $tn->npsn_tidak_sesuai_c1;
		$jml_npsn_tidak_sesuai_c0 = $tn->npsn_tidak_sesuai_c0;

		$probabilities['npsn']['name'] = 'Probabilitas NPSN';
		$probabilities['npsn']['data'][0]['name'] = 'Sesuai';
		$probabilities['npsn']['data'][0]['c1_total'] = $jml_npsn_sesuai_c1;
		$probabilities['npsn']['data'][0]['c0_total'] = $jml_npsn_sesuai_c0;
		$probabilities['npsn']['data'][0]['c1'] = round($jml_npsn_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['npsn']['data'][0]['c0'] = round($jml_npsn_sesuai_c0/$jml_data_tidak_layak, 9999999999);
		
		$probabilities['npsn']['data'][1]['name'] = 'Tidak Sesuai';
		$probabilities['npsn']['data'][1]['c1_total'] = $jml_npsn_tidak_sesuai_c1;
		$probabilities['npsn']['data'][1]['c0_total'] = $jml_npsn_tidak_sesuai_c0;
		$probabilities['npsn']['data'][1]['c1'] = round($jml_npsn_tidak_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['npsn']['data'][1]['c0'] = round($jml_npsn_tidak_sesuai_c0/$jml_data_tidak_layak, 9999999999);

		// For Mata Pelajaran
		$probabilities['mapel']['name'] = 'Probabilitas Mata Pelajaran';
		$probabilities['mapel']['data'] = $this->get_mapel_probabilities($limit, $total_data, $jml_data_layak, $jml_data_tidak_layak);

		// For No. Hp/Email
		$jml_no_hp_email_sesuai_c1 = $tn->no_hp_email_sesuai_c1;
		$jml_no_hp_email_sesuai_c0 = $tn->no_hp_email_sesuai_c0;
		$jml_no_hp_email_tidak_sesuai_c1 = $tn->no_hp_email_tidak_sesuai_c1;
		$jml_no_hp_email_tidak_sesuai_c0 = $tn->no_hp_email_tidak_sesuai_c0;

		$probabilities['no_hp_email']['name'] = 'Probabilitas No. HP/Email';
		$probabilities['no_hp_email']['data'][0]['name'] = 'Sesuai';
		$probabilities['no_hp_email']['data'][0]['c1_total'] = $jml_no_hp_email_sesuai_c1;
		$probabilities['no_hp_email']['data'][0]['c0_total'] = $jml_no_hp_email_sesuai_c0;
		$probabilities['no_hp_email']['data'][0]['c1'] = round($jml_no_hp_email_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['no_hp_email']['data'][0]['c0'] = round($jml_no_hp_email_sesuai_c0/$jml_data_tidak_layak, 9999999999);
		
		$probabilities['no_hp_email']['data'][1]['name'] = 'Tidak Sesuai';
		$probabilities['no_hp_email']['data'][1]['c1_total'] = $jml_no_hp_email_tidak_sesuai_c1;
		$probabilities['no_hp_email']['data'][1]['c0_total'] = $jml_no_hp_email_tidak_sesuai_c0;
		$probabilities['no_hp_email']['data'][1]['c1'] = round($jml_no_hp_email_tidak_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['no_hp_email']['data'][1]['c0'] = round($jml_no_hp_email_tidak_sesuai_c0/$jml_data_tidak_layak, 9999999999);

		// For Usia
		$jml_usia_sesuai_c1 = $tn->usia_sesuai_c1;
		$jml_usia_sesuai_c0 = $tn->usia_sesuai_c0;
		$jml_usia_tidak_sesuai_c1 = $tn->usia_tidak_sesuai_c1;
		$jml_usia_tidak_sesuai_c0 = $tn->usia_tidak_sesuai_c0;

		$probabilities['usia']['name'] = 'Probabilitas Usia';
		$probabilities['usia']['data'][0]['name'] = 'Sesuai';
		$probabilities['usia']['data'][0]['c1_total'] = $jml_usia_sesuai_c1;
		$probabilities['usia']['data'][0]['c0_total'] = $jml_usia_sesuai_c0;
		$probabilities['usia']['data'][0]['c1'] = round($jml_usia_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['usia']['data'][0]['c0'] = round($jml_usia_sesuai_c0/$jml_data_tidak_layak, 9999999999);
		
		$probabilities['usia']['data'][1]['name'] = 'Tidak Sesuai';
		$probabilities['usia']['data'][1]['c1_total'] = $jml_usia_tidak_sesuai_c1;
		$probabilities['usia']['data'][1]['c0_total'] = $jml_usia_tidak_sesuai_c0;
		$probabilities['usia']['data'][1]['c1'] = round($jml_usia_tidak_sesuai_c1/$jml_data_layak, 9999999999);
		$probabilities['usia']['data'][1]['c0'] = round($jml_usia_tidak_sesuai_c0/$jml_data_tidak_layak, 9999999999);
		// End of Perhitungan Probabilitas masing-masing kriteria (X)

		// ---------------------------------------------------------------------------------------------------------------------------------------------
		// Pendefinisian Probabilitas Prior P(Ci)
		// ---------------------------------------------------------------------------------------------------------------------------------------------
		// Layak
		$c1 = round($jml_data_layak/$total_data, 9999999999);

		// Tidak Layak
		$c0 = round($jml_data_tidak_layak/$total_data, 9999999999);

		// Mengambil probabilitas untuk Provinsi
		$probabilities['prov']['name'] = 'Probabilitas Propinsi';
		$probabilities['prov']['data'] = $this->get_prov_probabilities($limit, $total_data, $jml_data_layak, $jml_data_tidak_layak);

		// echo json_encode($probabilities['mapel']); die;
		// echo json_encode($probabilities['prov']); die;
		// echo json_encode($probabilities); die;

		// // ---------------------------------------------------------------------------------------------------------------------------------------------
		// // Perhitungan Probabilitas Data Uji
		// // ---------------------------------------------------------------------------------------------------------------------------------------------
		$this->classify_data_uji($total_data, $c1, $c0, $probabilities);

		return array(
			'jml_data_training' => $limit,
			'probabilities' => $probabilities,
			'total_data' => $total_data,
			'jml_data_layak' => $jml_data_layak,
			'jml_data_tidak_layak' => $jml_data_tidak_layak,
			'c1' => $c1,
			'c0' => $c0,
		);
	}

	public function get_prov_probabilities($limit, $total_data, $jml_data_layak, $jml_data_tidak_layak) {
		$sql = "SELECT DISTINCT(propinsi)
				FROM data
				LEFT JOIN master ON (master.nik=data.nik)
				ORDER BY data.no
				LIMIT $limit";
		$all_prov = $this->db->query($sql)->result_array();

		// form each category count query
		$prov_query = "SELECT ";

		foreach ($all_prov as $prov_key => $prov) {
			$propinsi = $prov['propinsi'];

			if ($propinsi != '') {
				if ($prov_key+1 == count($all_prov)) {
					$prov_query .= " SUM(propinsi = '$propinsi' AND status = 'Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', $propinsi)) . '_c1' . ", ";
					$prov_query .= " SUM(propinsi = '$propinsi' AND status = 'Tidak Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', $propinsi)) . '_c0' . ", ";
				} else {
					$prov_query .= " SUM(propinsi = '$propinsi' AND status = 'Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', $propinsi)) . '_c1' . ", ";
					$prov_query .= " SUM(propinsi = '$propinsi' AND status = 'Tidak Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', $propinsi)) . '_c0' . ", ";
				}
			}
		}

		$prov_query .= " SUM(propinsi = 'Luar Negeri' AND status = 'Layak') + SUM(propinsi IS NULL AND status = 'Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', 'Tidak Sesuai')) . '_c1' . ", ";
		$prov_query .= " SUM(propinsi = 'Luar Negeri' AND status = 'Tidak Layak') + SUM(propinsi IS NULL AND status = 'Tidak Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', 'Tidak Sesuai')) . '_c0' . " ";

		// $prov_query .= " SUM(propinsi = 'Luar Negeri' AND status = 'Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', 'Luar Negeri')) . '_c1' . ", ";
		// $prov_query .= " SUM(propinsi = 'Luar Negeri' AND status = 'Tidak Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', 'Luar Negeri')) . '_c0' . " ";

		$prov_query .= " FROM (
			SELECT data.*, master.propinsi
			FROM data
			LEFT JOIN master ON (master.nik=data.nik)
			ORDER BY data.no
			LIMIT $limit
		) as p";

		$each_prov = $this->db->query($prov_query)->result_array();

		$prob_each_prov = [];
		foreach ($each_prov[0] as $key => $prov) {
			$prov_name = substr($key, 0, -3);

			$prob_each_prov[$prov_name]['name'] = str_replace('f_dot', '.', str_replace('f_space', ' ', $prov_name));

			$exp_key = explode('_', $key);
			if (end($exp_key) == 'c1') {
				$prob_each_prov[$prov_name][str_replace($prov_name . '_', '', $key).'_total'] = $prov;
				$prob_each_prov[$prov_name][str_replace($prov_name . '_', '', $key)] = round($prov/$jml_data_layak, 9999999999);
			} else {
				$prob_each_prov[$prov_name][str_replace($prov_name . '_', '', $key).'_total'] = $prov;
				$prob_each_prov[$prov_name][str_replace($prov_name . '_', '', $key)] = round($prov/$jml_data_tidak_layak, 9999999999);
			}
		}

		// echo json_encode($prob_each_prov); die;

		$final_prov = (object)[];
		$tidak_sesuai = [];
		foreach ($prob_each_prov as $key => $prov) {
			if ($prov['name'] == 'Tidak Sesuai' || $prov['name'] == 'Luar Negeri') {
				// array_push($tidak_sesuai, array($prov['name'] => $prov));
				$final_prov->Tidakf_spaceSesuai = $prov;
			} else {
				// array_push($final_prov, array($prov['name'] => $prov));
				$final_prov->$key = $prov;
			}
		}

		// echo json_encode($final_prov); die;

		// $mergedData = [];
		// foreach ($tidak_sesuai as $item) {
		// 	$name = $item['name'];
		// 	if (!isset($mergedData[$name])) {
		// 		$mergedData[$name] = [
		// 			'c1_total' => 0,
		// 			'c1' => 0,
		// 			'c0_total' => 0,
		// 			'c0' => 0
		// 		];
		// 	}
		// 	$mergedData[$name]['c1_total'] += (int)$item['c1_total'];
		// 	$mergedData[$name]['c1'] += (float)$item['c1'];
		// 	$mergedData[$name]['c0_total'] += (int)$item['c0_total'];
		// 	$mergedData[$name]['c0'] += (float)$item['c0'];
		// }

		// $mergedData = array_values($mergedData)[1];
		// $mergedData['name'] = 'Tidak Sesuai';

		// array_push($final_prov, $mergedData);

		// $array = json_decode(json_encode($final_prov), true);
		// usort($array, function($a, $b) {
		// 	return strcmp($a['name'], $b['name']);
		// });
		// $sorted_prov = (object) $array;
		// echo json_encode($sorted_prov); die;

		return $final_prov;
	}

	public function get_mapel_probabilities($limit, $total_data, $jml_data_layak, $jml_data_tidak_layak) {
		$sql = "SELECT DISTINCT(mapel)
				FROM data
				LEFT JOIN master ON (master.nik=data.nik)
				ORDER BY data.no
				LIMIT $limit";
		$all_mapel = $this->db->query($sql)->result_array();

		// form each category count query
		$mapel_query = "SELECT ";

		foreach ($all_mapel as $mapel_key => $mapel) {
			$mapel = $mapel['mapel'];

			if ($mapel != '' && $mapel != 'Desain Fesyen' && $mapel != 'Spa dan Beauty Therapy' && $mapel != 'Wisata Bahari Dan Ekowisata') {
				if ($mapel_key+1 == count($all_mapel)) {
					$mapel_query .= " SUM(mapel = '$mapel' AND status = 'Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', str_replace('/', 'f_slash', $mapel))) . '_c1' . ", ";
					$mapel_query .= " SUM(mapel = '$mapel' AND status = 'Tidak Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', str_replace('/', 'f_slash', $mapel))) . '_c0' . ", ";
				} else {
					$mapel_query .= " SUM(mapel = '$mapel' AND status = 'Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', str_replace('/', 'f_slash', $mapel))) . '_c1' . ", ";
					$mapel_query .= " SUM(mapel = '$mapel' AND status = 'Tidak Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', str_replace('/', 'f_slash', $mapel))) . '_c0' . ", ";
				}
			}
		}

		$mapel_query .= " SUM(mapel = 'Desain Fesyen' AND status = 'Layak') + SUM(mapel = 'Spa dan Beauty Therapy' AND status = 'Layak') + SUM(mapel = 'Wisata Bahari Dan Ekowisata' AND status = 'Layak') + SUM(mapel IS NULL AND status = 'Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', 'Tidak Sesuai')) . '_c1' . ", ";
		$mapel_query .= " SUM(mapel = 'Desain Fesyen' AND status = 'Tidak Layak') + SUM(mapel = 'Spa dan Beauty Therapy' AND status = 'Tidak Layak') + SUM(mapel = 'Wisata Bahari Dan Ekowisata' AND status = 'Tidak Layak') + SUM(mapel IS NULL AND status = 'Tidak Layak') AS " . str_replace('.', 'f_dot', str_replace(' ', 'f_space', 'Tidak Sesuai')) . '_c0' . " ";

		$mapel_query .= " FROM (
			SELECT data.*
			FROM data
			LEFT JOIN master ON (master.nik=data.nik)
			ORDER BY data.no
			LIMIT $limit
		) as p";

		$each_mapel = $this->db->query($mapel_query)->result_array();

		$prob_each_mapel = [];
		foreach ($each_mapel[0] as $key => $mapel) {
			$mapel_name = substr($key, 0, -3);

			$prob_each_mapel[$mapel_name]['name'] = str_replace('f_dot', '.', str_replace('f_space', ' ', str_replace('f_slash', '/', $mapel_name)));

			$exp_key = explode('_', $key);
			if (end($exp_key) == 'c1') {
				$prob_each_mapel[$mapel_name][str_replace($mapel_name . '_', '', $key).'_total'] = $mapel;
				$prob_each_mapel[$mapel_name][str_replace($mapel_name . '_', '', $key)] = round($mapel/$jml_data_layak, 9999999999);
			} else {
				$prob_each_mapel[$mapel_name][str_replace($mapel_name . '_', '', $key).'_total'] = $mapel;
				$prob_each_mapel[$mapel_name][str_replace($mapel_name . '_', '', $key)] = round($mapel/$jml_data_tidak_layak, 9999999999);
			}
		}

		$final_mapel = (object)[];
		$tidak_sesuai = [];
		foreach ($prob_each_mapel as $key => $mapel) {
			if ($mapel['name'] == 'Tidak Sesuai') {
				// array_push($tidak_sesuai, $mapel['data']);
				$final_mapel->Tidakf_spaceSesuai = $mapel;
			} else {
				// array_push($final_mapel, $mapel['data']);
				$final_mapel->$key = $mapel;
			}
		}

		// $mergedData = [];
		// foreach ($tidak_sesuai as $item) {
		// 	$name = $item['name'];
		// 	if (!isset($mergedData[$name])) {
		// 		$mergedData[$name] = [
		// 			'c1_total' => 0,
		// 			'c1' => 0,
		// 			'c0_total' => 0,
		// 			'c0' => 0
		// 		];
		// 	}
		// 	$mergedData[$name]['c1_total'] += (int)$item['c1_total'];
		// 	$mergedData[$name]['c1'] += (float)$item['c1'];
		// 	$mergedData[$name]['c0_total'] += (int)$item['c0_total'];
		// 	$mergedData[$name]['c0'] += (float)$item['c0'];
		// }

		// $mergedData = array_values($mergedData)[0];
		// $mergedData['name'] = 'Tidak Sesuai';

		// array_push($final_mapel, $mergedData);

		// $array = json_decode(json_encode($final_mapel), true);
		// usort($array, function($a, $b) {
		// 	return strcmp($a['name'], $b['name']);
		// });
		// $sorted_mapel = (object) $array;
		// echo json_encode($sorted_mapel); die;

		return $final_mapel;
	}

	public function pengujian() {
		if ($this->session->userdata('authorized')) {
			$data['confusion_matrix'] = $this->db->get('confusion_matrix')->row();
			$data['page'] = 'hasil_uji';
	
			$this->load->view('templates', $data);
		} else {
			redirect('login');
		}
	}

	public function data_pengujian() {
		$searchKeyword = $this->input->post('search')['value'];

		$pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $propinsi = $this->input->post('propinsi');
        $mapel = $this->input->post('mapel');

        $naskah = $this->Preview_model->getPraTrainingData($this->searchableFields, $pagination, $propinsi, $mapel, $searchKeyword);

        $formattedData = array_map(function ($item) {
			return [
				$item['no'],
				$item['nama'],
				strlen($item['nik']) == 16 ? 'Sesuai' : 'Tidak Sesuai', 
				strlen($item['no_ukg']) == 12 ? 'Sesuai' : 'Tidak Sesuai',
				strlen($item['nuptk']) == 16 ? 'Sesuai' : 'Tidak Sesuai',
				strlen($item['npsn']) == 8 ? 'Sesuai' : 'Tidak Sesuai',
				strlen($item['mapel']) > 0 && $item['mapel'] != 'Desain Fesyen' && $item['mapel'] != 'Spa dan Beauty Therapy' && $item['mapel'] != 'Wisata Bahari Dan Ekowisata' ? $item['mapel'] : 'Tidak Sesuai',
				strlen($item['no_hp']) >= 8 || filter_var($item['email'], FILTER_VALIDATE_EMAIL) ? 'Sesuai' : 'Tidak Sesuai',
				$item['usia'] && $item['usia'] <= 55 ? 'Sesuai' : 'Tidak Sesuai',
				strlen($item['propinsi']) > 0 && $item['propinsi'] != 'Luar Negeri' ? $item['propinsi'] : 'Tidak Sesuai',
				$item['status'],
				$item['prediksi']
			];
        }, $naskah['data']);

        $data = [
            'recordsTotal' => $naskah['recordsTotal'],
            'recordsFiltered' => $naskah['recordsTotal'],
            'data' => $formattedData
        ];

        echo json_encode($data);
	}

	public function classify_data_uji($total_data, $c1, $c0, $probabilities) {
		// Kriteria X yang bersifat Sesuai atau Tidak Sesuai
		// $base_two_probabilities_c1 = round($probabilities['prob_nik_c1_sesuai']*$probabilities['prob_tidak_sesuai_ukg_c1_sesuai']*$probabilities['prob_nuptk_c1_sesuai']*$probabilities['prob_npsn_c1_sesuai']*$probabilities['prob_tidak_sesuai_hp_email_c1_sesuai']*$probabilities['prob_usia_c1_sesuai'], 9999999999);
		// $base_two_probabilities_c0 = round($probabilities['prob_nik_c0_sesuai']*$probabilities['prob_tidak_sesuai_ukg_c0_sesuai']*$probabilities['prob_nuptk_c0_sesuai']*$probabilities['prob_npsn_c0_sesuai']*$probabilities['prob_tidak_sesuai_hp_email_c0_sesuai']*$probabilities['prob_usia_c0_sesuai'], 9999999999);

		$data_uji_query = "
			SELECT data.*, master.propinsi, master.tgl_lahir
			FROM data
			LEFT JOIN master ON (master.nik=data.nik)
			-- WHERE data.no=8725
			-- GROUP BY data.nik
			ORDER BY data.no
			-- LIMIT 100
		";
		$data_uji = $this->db->query($data_uji_query)->result_array();

		$hasil_data_uji = [];
		$collect_batch = [];
		$tp = 0;
		$tn = 0;
		$fp = 0;
		$fn = 0;
		$p_layak = 0;
		$p_tidak_layak = 0;
		foreach ($data_uji as $index => $peserta) {
			// Data transformation each Kriteria (X)
			$nik = (strlen($peserta['nik']) == 16 ? 'Sesuai' : 'Tidak Sesuai');
			$ukg = (strlen($peserta['no_ukg']) == 12 ? 'Sesuai' : 'Tidak Sesuai');
			$nuptk = (strlen($peserta['nuptk']) == 16 ? 'Sesuai' : 'Tidak Sesuai');
			$npsn = (strlen($peserta['npsn']) == 8 ? 'Sesuai' : 'Tidak Sesuai');
			$no_hp_email = (strlen($peserta['no_hp']) > 8 || filter_var($peserta['email'], FILTER_VALIDATE_EMAIL) ? 'Sesuai' : 'Tidak Sesuai');

			$tgl_lahir = new DateTime($peserta['tgl_lahir']);
			$current_date = new DateTime();
			$peserta_age = $current_date->diff($tgl_lahir)->y;
			$usia = $peserta_age <= 55 ? 'Sesuai' : 'Tidak Sesuai';

			// Collect all Kriteria and get each probabilities based on X value
			$base_two_values_c1 = [];
			$base_two_values_c0 = [];

			// NIK
			array_push($base_two_values_c1, $nik == 'Sesuai' ? $probabilities['nik']['data'][0]['c1'] : $probabilities['nik']['data'][1]['c1']);
			array_push($base_two_values_c0, $nik == 'Sesuai' ? $probabilities['nik']['data'][0]['c0'] : $probabilities['nik']['data'][1]['c0']);
			
			// UKG
			array_push($base_two_values_c1, $ukg == 'Sesuai' ? $probabilities['ukg']['data'][0]['c1'] : $probabilities['ukg']['data'][1]['c1']);
			array_push($base_two_values_c0, $ukg == 'Sesuai' ? $probabilities['ukg']['data'][0]['c0'] : $probabilities['ukg']['data'][1]['c0']);
			
			// NUPTK
			array_push($base_two_values_c1, $nuptk == 'Sesuai' ? $probabilities['nuptk']['data'][0]['c1'] : $probabilities['nuptk']['data'][1]['c1']);
			array_push($base_two_values_c0, $nuptk == 'Sesuai' ? $probabilities['nuptk']['data'][0]['c0'] : $probabilities['nuptk']['data'][1]['c0']);

			// NPSN
			array_push($base_two_values_c1, $npsn == 'Sesuai' ? $probabilities['npsn']['data'][0]['c1'] : $probabilities['npsn']['data'][1]['c1']);
			array_push($base_two_values_c0, $npsn == 'Sesuai' ? $probabilities['npsn']['data'][0]['c0'] : $probabilities['npsn']['data'][1]['c0']);

			// No Hp/Email
			array_push($base_two_values_c1, $no_hp_email == 'Sesuai' ? $probabilities['no_hp_email']['data'][0]['c1'] : $probabilities['no_hp_email']['data'][1]['c1']);
			array_push($base_two_values_c0, $no_hp_email == 'Sesuai' ? $probabilities['no_hp_email']['data'][0]['c0'] : $probabilities['no_hp_email']['data'][1]['c0']);

			// Usia
			array_push($base_two_values_c1, $usia == 'Sesuai' ? $probabilities['usia']['data'][0]['c1'] : $probabilities['usia']['data'][1]['c1']);
			array_push($base_two_values_c0, $usia == 'Sesuai' ? $probabilities['usia']['data'][0]['c0'] : $probabilities['usia']['data'][1]['c0']);

			$base_two_probabilities_c1 = 1;
			foreach ($base_two_values_c1 as $val) {
				$base_two_probabilities_c1 *= $val;
			}

			$base_two_probabilities_c0 = 1;
			foreach ($base_two_values_c0 as $val) {
				$base_two_probabilities_c0 *= $val;
			}

			// get prov
			$prov_name = str_replace('.', 'f_dot', str_replace(' ', 'f_space', $peserta['propinsi']));
			
			$prov_probabilities_c1 = 0;
			if ($peserta['propinsi'] == '' || $peserta['propinsi'] == 'Luar Negeri') {
				$prov_probabilities_c1 = $probabilities['prov']['data']->Tidakf_spaceSesuai['c1'];
			} else {
				$prov_probabilities_c1 = $probabilities['prov']['data']->$prov_name['c1'];
			}
			
			$prov_probabilities_c0 = 0;
			if ($peserta['propinsi'] == '' || $peserta['propinsi'] == 'Luar Negeri') {
				$prov_probabilities_c0 = $probabilities['prov']['data']->Tidakf_spaceSesuai['c0'];
			} else {
				$prov_probabilities_c0 = $probabilities['prov']['data']->$prov_name['c0'];
			}

			// get mapel
			$mapel_name = str_replace('.', 'f_dot', str_replace(' ', 'f_space', str_replace('/', 'f_slash', $peserta['mapel'])));
			
			$mapel_probabilities_c1 = 0;
			if ($peserta['mapel'] == '' || $peserta['mapel'] == 'Desain Fesyen' || $peserta['mapel'] == 'Spa dan Beauty Therapy' || $peserta['mapel'] == 'Wisata Bahari Dan Ekowisata') {
				$mapel_probabilities_c1 = $probabilities['mapel']['data']->Tidakf_spaceSesuai['c1'];
			} else {
				$mapel_probabilities_c1 = $probabilities['mapel']['data']->$mapel_name['c1'];
			}
			
			$mapel_probabilities_c0 = 0;
			if ($peserta['mapel'] == '' || $peserta['mapel'] == 'Desain Fesyen' || $peserta['mapel'] == 'Spa dan Beauty Therapy' || $peserta['mapel'] == 'Wisata Bahari Dan Ekowisata') {
				$mapel_probabilities_c0 = $probabilities['mapel']['data']->Tidakf_spaceSesuai['c0'];
			} else {
				$mapel_probabilities_c0 = $probabilities['mapel']['data']->$mapel_name['c0'];
			}

			// Mencari nilai P(X|C1)
			// P(X|C1) = P(NIK=Yes|C1) x P(UKG=Yes|C1) x P(NUPTK=Yes|C1) x P(NPSN=Yes|C1) x P(NIK=No_HP_Email|C1) x P(Age=Yes|C1)
			$p_x_c1 = round($base_two_probabilities_c1*$prov_probabilities_c1*$mapel_probabilities_c1, 9999999999);

			// Mencari nilai P(X|C0)
			// P(X|C0) = P(NIK=Yes|C0) x P(UKG=Yes|C0) x P(NUPTK=Yes|C0) x P(NPSN=Yes|C0) x P(NIK=No_HP_Email|C0) x P(Age=Yes|C0)
			$p_x_c0 = round($base_two_probabilities_c0*$prov_probabilities_c0*$mapel_probabilities_c0, 9999999999);

			// echo json_encode(array(
			// 	'sesuai_tidak_sesuai' => array(
			// 		$base_two_values_c1,
			// 		$base_two_values_c0,
			// 	),
			// 	'prov' => array(
			// 		$prov_probabilities_c1,
			// 		$prov_probabilities_c0,
			// 	)
			// )); die;

			// ---------------------------------------------------------------------------------------------------------------------------------------------
			// Pemaksimalan P(X|Ci)P(Ci)
			// ---------------------------------------------------------------------------------------------------------------------------------------------
			$p_c1_x = $c1*$p_x_c1;
			$p_c0_x = $c0*$p_x_c0;

			$status = $p_c1_x > $p_c0_x ? 'Layak' : 'Tidak Layak';

			$hasil_data_uji[$peserta['no']]['actual'] = $peserta['status'];
			$hasil_data_uji[$peserta['no']]['prediksi'] = $status;
			$hasil_data_uji[$peserta['no']]['akurat'] = $status == $peserta['status']  ? 'Akurat' : 'Tidak Akurat';
			$hasil_data_uji[$peserta['no']]['nama'] = $peserta['nama'];
			// $hasil_data_uji[$peserta['no']]['nik'] = $nik;
			// $hasil_data_uji[$peserta['no']]['ukg'] = $ukg;
			// $hasil_data_uji[$peserta['no']]['nuptk'] = $nuptk;
			// $hasil_data_uji[$peserta['no']]['npsn'] = $npsn;
			// $hasil_data_uji[$peserta['no']]['no_hp_email'] = $no_hp_email;
			// $hasil_data_uji[$peserta['no']]['usia'] = $usia;
			// $hasil_data_uji[$peserta['no']]['propinsi'] = $peserta['propinsi'];
			// $hasil_data_uji[$peserta['no']]['mapel'] = $peserta['mapel'];
			// $hasil_data_uji[$peserta['no']]['base_two'] = array(
			// 	$base_two_values_c1,
			// 	$base_two_values_c0,
			// );
			// $hasil_data_uji[$peserta['no']]['prob_propinsi'] = array(
			// 	'c1' => $prov_probabilities_c1,
			// 	'c0' => $prov_probabilities_c0,
			// );
			// $hasil_data_uji[$peserta['no']]['prob_mapel'] = array(
			// 	'c1' => $mapel_probabilities_c1,
			// 	'c0' => $mapel_probabilities_c0,
			// );
			// $hasil_data_uji[$peserta['no']]['prob_propinsi'] = ($peserta['propinsi'] != '' ? $probabilities['prov']['data']->$prov_name : 0);
			// $hasil_data_uji[$peserta['no']]['c1'] = $c1;
			// $hasil_data_uji[$peserta['no']]['c0'] = $c0;
			// $hasil_data_uji[$peserta['no']]['p_x_c1'] = $p_x_c1;
			// $hasil_data_uji[$peserta['no']]['p_x_c0'] = $p_x_c0;
			// $hasil_data_uji[$peserta['no']]['p_c1_x'] = $p_c1_x;
			// $hasil_data_uji[$peserta['no']]['p_c0_x'] = $p_c0_x;
			// $hasil_data_uji[$peserta['no']]['base_two_values_c1'] = $base_two_values_c1;
			// $hasil_data_uji[$peserta['no']]['base_two_values_c0'] = $base_two_values_c0;

			if ($peserta['status'] == 'Layak' && $peserta['status'] == $status) {
				$tp += 1;
			} else if ($peserta['status'] == 'Tidak Layak' && $peserta['status'] == $status) {
				$tn += 1;
			} else if ($peserta['status'] == 'Layak' && $peserta['status'] != $status) {
				$fp += 1;
			} else {
				$fn += 1;
			}

			if ($status == 'Layak') {
				$p_layak += 1;
			} else {
				$p_tidak_layak += 1;
			}

			// Save result to DB
			array_push($collect_batch, array(
				'no' => $peserta['no'],
				'prediksi' => $status,
			));
		}

		$this->db->update_batch('data', $collect_batch, 'no');
		// if ($this->db->_error_message()) {
		// 	echo json_encode($this->db->_error_message()); die;
		// }

		// echo json_encode($hasil_data_uji); die;

		$accuracy = round(($tp+$tn) / ($tp+$fp+$fn+$tn) * 100, 1) . '%';
		$precision = round(($tp / ($tp+$fp)) * 100, 1) . '%';
		$recall = round(($tp / ($tp+$fn)) * 100, 1) . '%';

		// echo json_encode(array(
		// 	'layak' => $p_layak,
		// 	'tidak_layak' => $p_tidak_layak,
		// 	'accuracy' => $accuracy,
		// 	'precision' => $precision,
		// 	'recall' => $recall,
		// )); 
		
		
		// store confusion matrix result to database
		$this->db->query("TRUNCATE confusion_matrix");
		$this->db->insert('confusion_matrix', array(
			'accuracy' => $accuracy,
			'precision' => $precision,
			'recall' => $recall,
		));
	}

	public function list() {
		echo 'list';
	}
}
