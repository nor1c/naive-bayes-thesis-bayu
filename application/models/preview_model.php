<?php

class Preview_model extends CI_Model {
	public function getData($searchableFields, $pagination, $propinsi, $mapel) {
        $this->db->select("data.*, master.propinsi");
        $this->db->from('data');
        $this->db->join('master', "master.nik=data.nik", 'left');

		$this->db->where('data.mapel IS NOT NULL');

		if ($propinsi) {
			$this->db->where('master.propinsi', $propinsi);
		}
		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

        $data = $this->db->group_by("data.nik")
						->order_by('master.propinsi', 'ASC')
						->order_by('data.mapel', 'ASC')
						->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        // count all records
		$this->db->select('COUNT(DISTINCT(data.nik)) as total')
				->from('data');

		// if (isset($filters)) {
			$this->db->join('master', "master.nik=data.nik", 'left');
		// }
		
		$this->db->where('data.mapel IS NOT NULL');

		if ($propinsi) {
			$this->db->where('master.propinsi', $propinsi);
		}
		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

		$recordsTotal = $this->db->get()->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
	}

	public function getDataStep1($searchableFields, $pagination, $propinsi, $mapel, $search) {
        $this->db->select("data.*");
        $this->db->from('data');
        // $this->db->join('master', "master.nik=data.nik", 'left');

		// $this->db->where('data.mapel IS NOT NULL');

		// if ($propinsi) {
		// 	$this->db->where('master.propinsi', $propinsi);
		// }
		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}
		if ($search) {
			$this->db->like('data.nik', $search);
			$this->db->or_like('data.no_ukg', $search);
			$this->db->or_like('data.nuptk', $search);
			$this->db->or_like('data.npsn', $search);
			// $this->db->or_like('master.propinsi', $search);
			$this->db->or_like('data.mapel', $search);
		}

        $data = $this->db->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        // count all records
		$this->db->select('COUNT(data.no) as total')
				->from('data');

		// if (isset($filters)) {
			// $this->db->join('master', "master.nik=data.nik", 'left');
		// }
		
		// $this->db->where('data.mapel IS NOT NULL');

		// if ($propinsi) {
		// 	$this->db->where('master.propinsi', $propinsi);
		// }
		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}
		if ($search) {
			$this->db->like('data.nik', $search);
		}

		$recordsTotal = $this->db->get()->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
	}

	public function getDataStep2($searchableFields, $pagination, $propinsi, $mapel, $search) {
        $this->db->select("data.*");
        $this->db->from('data');

		if ($search) {
			$this->db->like('data.nik', $search);
			$this->db->or_like('data.no_ukg', $search);
			$this->db->or_like('data.nuptk', $search);
			$this->db->or_like('data.npsn', $search);
			$this->db->or_like('data.mapel', $search);
		}

		$this->db->where('no IN (SELECT MAX(no) FROM data GROUP BY nik)', NULL, FALSE);

        $data = $this->db->group_by('data.nik')
						->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        // count all records
		$this->db->select('COUNT(DISTINCT(data.nik)) as total')
				->from('data');

		if ($search) {
			$this->db->like('data.nik', $search);
		}

		$recordsTotal = $this->db->get()->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
	}

	public function getDataStep3($searchableFields, $pagination, $propinsi, $mapel, $search) {
		$this->db->select("data.*, FLOOR(DATEDIFF(NOW(), master.tgl_lahir) / 365.25) as usia, master.propinsi");
        $this->db->from('data');
        $this->db->join('master', "master.nik=data.nik", 'left');

		if ($search) {
			$this->db->like('data.nik', $search);
			$this->db->or_like('data.no_ukg', $search);
			$this->db->or_like('data.nuptk', $search);
			$this->db->or_like('data.npsn', $search);
			$this->db->or_like('data.mapel', $search);
		}

		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);

        $data = $this->db->group_by('data.nik')
						->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        // count all records
		$this->db->select('COUNT(DISTINCT(data.nik)) as total')
				->from('data');

		if ($search) {
			$this->db->like('data.nik', $search);
		}

		$recordsTotal = $this->db->get()->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
	}

	public function getPraTrainingData($searchableFields, $pagination, $propinsi, $mapel, $search) {
        $this->db->select("data.*, FLOOR(DATEDIFF(NOW(), master.tgl_lahir) / 365.25) as usia, master.propinsi");
        $this->db->from('data');
        $this->db->join('master', "master.nik=data.nik", 'left');

		if ($search) {
			$this->db->like('data.nik', $search);
			$this->db->or_like('data.no_ukg', $search);
			$this->db->or_like('data.nuptk', $search);
			$this->db->or_like('data.npsn', $search);
			$this->db->or_like('data.mapel', $search);
		}

		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);

        $data = $this->db->group_by('data.nik')
						->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        // count all records
		$this->db->select('COUNT(DISTINCT(data.nik)) as total')
				->from('data');

		if ($search) {
			$this->db->like('data.nik', $search);
		}

		$recordsTotal = $this->db->get()->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
	}

	public function getDataPemecahanMapelDapodik($searchableFields, $pagination, $propinsi, $mapel, $search) {
		$this->db->select("data.*, FLOOR(DATEDIFF(NOW(), master.tgl_lahir) / 365.25) as usia, master.propinsi");
        $this->db->from('data');
        $this->db->join('master', "master.nik=data.nik", 'left');

		if ($search) {
			$this->db->like('data.nik', $search);
			$this->db->or_like('data.no_ukg', $search);
			$this->db->or_like('data.nuptk', $search);
			$this->db->or_like('data.npsn', $search);
			$this->db->or_like('data.mapel', $search);
		}

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

        $data = $this->db->group_by('data.nik')
						->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        // count all records
		$this->db->select('COUNT(DISTINCT(data.nik)) as total')
				->from('data');

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);

		if ($search) {
			$this->db->like('data.nik', $search);
		}

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

		$recordsTotal = $this->db->get()->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
	}

	public function getDataPengecekanMapelDapodik($searchableFields, $pagination, $propinsi, $mapel, $search) {
		$this->db->select("data.*, master.mapel_bispar, FLOOR(DATEDIFF(NOW(), master.tgl_lahir) / 365.25) as usia, master.propinsi");
        $this->db->from('data');
        $this->db->join('master', "master.nik=data.nik", 'left');

		if ($search) {
			$this->db->like('data.nik', $search);
			$this->db->or_like('data.no_ukg', $search);
			$this->db->or_like('data.nuptk', $search);
			$this->db->or_like('data.npsn', $search);
			$this->db->or_like('data.mapel', $search);
		}

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

        $data = $this->db->group_by('data.nik')
						->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        // count all records
		$this->db->select('COUNT(DISTINCT(data.nik)) as total')
				->from('data');

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);

		if ($search) {
			$this->db->like('data.nik', $search);
		}

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

		$recordsTotal = $this->db->get()->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
	}

	public function getDataHasilPengecekanMapelDapodik($searchableFields, $pagination, $propinsi, $mapel, $search) {
		$this->db->select("data.*, master.mapel_bispar, FLOOR(DATEDIFF(NOW(), master.tgl_lahir) / 365.25) as usia, master.propinsi");
        $this->db->from('data');
        $this->db->join('master', "master.nik=data.nik AND TRIM(master.mapel_bispar)=data.mapel", 'left');

		if ($search) {
			$this->db->like('data.nik', $search);
			$this->db->or_like('data.no_ukg', $search);
			$this->db->or_like('data.nuptk', $search);
			$this->db->or_like('data.npsn', $search);
			$this->db->or_like('data.mapel', $search);
		}

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);
		$this->db->where('master.mapel_bispar IS NOT NULL');

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

        $data = $this->db->group_by('data.nik')
						->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        // count all records
		$this->db->select('COUNT(DISTINCT(data.nik)) as total')
				->from('data')
				->join('master', "master.nik=data.nik AND TRIM(master.mapel_bispar)=data.mapel", 'left');

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);
		$this->db->where('master.mapel_bispar IS NOT NULL');

		if ($search) {
			$this->db->like('data.nik', $search);
		}

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

		$recordsTotal = $this->db->get()->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
	}

	public function getDataPenggabunganDataAfterMapel($searchableFields, $pagination, $propinsi, $mapel, $search) {
		$this->db->select("data.*, master.mapel_bispar, FLOOR(DATEDIFF(NOW(), master.tgl_lahir) / 365.25) as usia, master.propinsi");
        $this->db->from('data');
        $this->db->join('master', "master.nik=data.nik AND TRIM(master.mapel_bispar)=data.mapel", 'left');

		if ($search) {
			$this->db->like('data.nik', $search);
			$this->db->or_like('data.no_ukg', $search);
			$this->db->or_like('data.nuptk', $search);
			$this->db->or_like('data.npsn', $search);
			$this->db->or_like('data.mapel', $search);
		}

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);
		$this->db->where('master.mapel_bispar IS NOT NULL');

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

        $data = $this->db->group_by('data.nik')
						->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        // count all records
		$this->db->select('COUNT(DISTINCT(data.nik)) as total')
				->from('data')
				->join('master', "master.nik=data.nik AND TRIM(master.mapel_bispar)=data.mapel", 'left');

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);
		$this->db->where('master.mapel_bispar IS NOT NULL');

		if ($search) {
			$this->db->like('data.nik', $search);
		}

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

		$recordsTotal = $this->db->get()->row()->total;

        return [
            'data' => $data,
            'recordsTotal' => $recordsTotal
        ];
	}

	public function getPemetaanClassEachMapel($mapel) {
		return $this->db->from('mapping')
						->where('mapel', $mapel)
						->get()
						->result_array();
	}

	public function getDataPemetaan($searchableFields, $pagination, $mapel, $pb, $pb_prov, $search) {
		$this->db->select("data.*, master.mapel_bispar, FLOOR(DATEDIFF(NOW(), master.tgl_lahir) / 365.25) as usia, master.propinsi");
        $this->db->from('data');
        $this->db->join('master', "master.nik=data.nik AND TRIM(master.mapel_bispar)=data.mapel", 'left');

		if ($search) {
			$this->db->like('data.nik', $search);
			$this->db->or_like('data.no_ukg', $search);
			$this->db->or_like('data.nuptk', $search);
			$this->db->or_like('data.npsn', $search);
			$this->db->or_like('data.mapel', $search);
		}

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);
		$this->db->where('master.mapel_bispar IS NOT NULL');
		$pb_prov = str_replace("\\", '', json_encode($pb_prov));
		$this->db->where('master.propinsi IN ' . str_replace('"[', '(', str_replace(']"', ')', str_replace("", '', $pb_prov))));

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

        $data = $this->db->group_by('data.nik')
						->order_by('data.no', 'ASC')
						->limit($pagination['length'], $pagination['start'])
						->get()
						->result_array();

        return [
            'data' => $data,
            'recordsTotal' => $pagination['length']
        ];
	}

	public function getPesertaEachMapelAndPb($mapel, $prov, $need, $take_from) {
		$this->db->select("data.*, master.mapel_bispar, FLOOR(DATEDIFF(NOW(), master.tgl_lahir) / 365.25) as usia, master.propinsi");
        
		$this->db->from('data');
        $this->db->join('master', "master.nik=data.nik AND TRIM(master.mapel_bispar)=data.mapel", 'left');

		$this->db->where('data.prediksi', 'Layak');
		$this->db->where('data.no IN (SELECT MAX(data.no) FROM data GROUP BY data.nik)', NULL, FALSE);
		$this->db->where('master.mapel_bispar IS NOT NULL');
		$prov_name = str_replace("\\", '', json_encode($prov));
		$this->db->where('master.propinsi IN ' . str_replace('"[', '(', str_replace(']"', ')', str_replace("", '', $prov_name))));

		if ($mapel) {
			$this->db->where('data.mapel', $mapel);
		}

        $data = $this->db->group_by('data.nik')
						->order_by('data.no', 'ASC')
						->limit($need, $take_from)
						->get()
						->result_array();

		return $data;
	}
}
