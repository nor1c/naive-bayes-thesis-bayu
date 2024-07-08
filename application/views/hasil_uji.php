<div class="px-5 w-full mx-auto text-xs">
	<ol class="mb-10 flex items-center justify-center w-full text-xs font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm sm:text-base sm:p-4 sm:space-x-4 rtl:space-x-reverse">
		<a href="<?=site_url('preview/pengumpulan')?>"">
			<li class="flex items-center text-sm text-gray-500 hover:text-blue-500">
				<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0">1</span>
				Pengumpulan Data
				<svg class="w-2 h-2 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
				</svg>
			</li>
		</a>
		<a href="<?=site_url('preview/penyaringan')?>"">
			<li class="flex items-center text-sm">
				<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-500 rounded-full shrink-0">2</span>
				Penyaringan Data
				<svg class="w-2 h-2 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
				</svg>
			</li>
		</a>
		<a href="<?=site_url('thesis/transformasi_data')?>"">
			<li class="flex items-center text-sm text-gray-500">
				<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0">3</span>
				Transformasi Data
				<svg class="w-2 h-2 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
				</svg>
			</li>
		</a>
		<li class="flex items-center text-sm text-blue-500">
			<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0">4</span>
			Training & Uji
			<svg class="w-2 h-2 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
			</svg>
		</li>
		<li class="flex items-center text-sm">
			<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0">5</span>
			Pengecekan Mapel DAPODIK
			<svg class="w-2 h-2 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
			</svg>
		</li>
		<li class="flex items-center text-sm">
			<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0">6</span>
			Penggabungan Data
			<svg class="w-2 h-2 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
			</svg>
		</li>
		<li class="flex items-center text-sm">
			<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0">7</span>
			Pemetaan
		</li>
	</ol>

	<h3 class="text-lg font-medium">4.2. Hasil Pengujian Data berdasarkan Probabilitas Data Training</h3>

	<div class="mt-10 flex flex-col gap-10">
		<div>
			<h3 class="text-base font-medium">Tabel Confusion Matrix</h3>
		
			<div class="w-2/3 flex flex-row gap-4 overflow-x-auto mt-5">
				<table class="w-full text-left rtl:text-right text-gray-500">
					<tbody>
						<tr class="border-b border-gray-200">
							<td class="px-6 py-2 font-semibold"></td>
							<td class="px-6 py-2 font-semibold" rowspan="1"></td>
							<td class="bg-green-100 px-6 py-2 font-bold text-center" colspan="2">AKTUAL</td>
						</tr>
						<tr class="border-b border-gray-200">
							<td class="px-6 py-2 font-semibold"></td>
							<td class="px-6 py-2 font-semibold"></td>
							<td class="bg-yellow-100 px-6 py-2 font-bold text-center">Positif</td>
							<td class="bg-yellow-100 px-6 py-2 font-bold text-center">Negatif</td>
						</tr>
						<tr class="border-b border-gray-200">
							<td class="bg-green-100 px-6 py-2 font-bold" rowspan="2">PREDIKSI</td>
							<td class="bg-yellow-100 px-6 py-2 font-bold">Positif</td>
							<td class="px-6 py-2 text-center"><?=$confusion_matrix->tp?></td>
							<td class="px-6 py-2 text-center"><?=$confusion_matrix->fp?></td>
						</tr>
						<tr class="border-b border-gray-200">
							<td class="bg-yellow-100 px-6 py-2 font-bold">Negatif</td>
							<td class="px-6 py-2 text-center"><?=$confusion_matrix->fn?></td>
							<td class="px-6 py-2 text-center"><?=$confusion_matrix->tn?></td>
						</tr>
					</tbody>
				</table>

				<table class="w-full text-left rtl:text-right text-gray-500">
					<tbody>
						<tr class="border-b border-gray-200">
							<td class="bg-green-100 px-6 py-4 font-semibold w-1/6">Akurasi</td>
							<td style="background:#f2f0ea" class="px-6 py-4 font-semibold w-1/4">
								<img src="<?=base_url('assets/formula/accuracy.png')?>" alt="">
							</td>
							<td class="px-6 py-4 bg-gray-50 w-1/6"><?=$confusion_matrix->accuracy?>%</td>
						</tr>
						<tr class="border-b border-gray-200">
							<td class="bg-green-100 px-6 py-4 font-semibold w-1/6">Presisi</td>
							<td style="background:#f2f0ea" class="px-6 py-4 font-semibold w-1/4">
								<img src="<?=base_url('assets/formula/precision.png')?>" alt="">
							</td>
							<td class="px-6 py-4 bg-gray-50 w-1/6"><?=$confusion_matrix->precision?>%</td>
						</tr>
						<tr class="border-b border-gray-200">
							<td class="bg-green-100 px-6 py-4 font-semibold w-1/6">Recall</td>
							<td style="background:#f2f0ea" class="px-6 py-4 font-semibold w-1/4">
								<img src="<?=base_url('assets/formula/recall.png')?>" alt="">
							</td>
							<td class="px-6 py-4 bg-gray-50 w-1/6"><?=$confusion_matrix->recall?>%</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<table id="previewTable" class="w-full text-sm text-left rtl:text-right text-gray-500" cellspacing="0">
			<thead class="text-xs text-gray-700 uppercase bg-blue-100">
				<tr>
					<th width="60">No. Urut</th>
					<th width="220">Nama</th>
					<th width="150">NIK</th>
					<th width="150">No. UKG</th>
					<th width="150">NUPTK</th>
					<th width="150">NPSN</th>
					<th width="250">Mata Pelajaran</th>
					<th>No. HP/Email</th>
					<th width="80">Usia</th>
					<th width="200">Propinsi</th>
					<th width="60">Aktual</th>
					<th width="60">Prediksi</th>
				</tr>
			</thead>
		</table>
	</div>

	<div class="w-full text-right mt-12">
		<a href="<?=site_url('preview/pemecahan_mapel_dapodik')?>" class="px-5 py-3 text-xs font-bold rounded-lg bg-blue-500 text-white hover:bg-blue-700 hover:shadow-xl">PENGECEKAN MAPEL DAPODIK/SIMPKB <i class="fa-solid fa-circle-right ml-1"></i></a>
	</div>
</div>

<script>
	$(document).ready(function() {
		let aktifPropinsi = 0;
		let aktifMapel = 0;

		table = $('#previewTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollCollapse": true,
            "aLengthMenu": [
                [10, 15, 20, 50, 100, 999999999],
                [10, 15, 20, 50, 100, 'Semua Data'],
            ],
            "pageLength": 100,
            "processing": true,
            "serverSide": true,
            "searching": false,
			"scrollY": "500px",
			"scrollCollapse": true,
            "ajax": {
                "url": "<?=site_url('thesis/data_pengujian')?>",
                'method': 'POST',
                'data': function(d) {
                    d.draw = d.draw || 1
					filters.propinsi = aktifPropinsi
					filters.mapel = aktifMapel
                    return $.extend(d, filters);
                },
            },
            "deferRender": true,
            "columns": [
                {
                    "className": 'datatables-number',
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "defaultContent": '',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "orderable": false,
                    "searchable": true,
                },
                {
                    "orderable": false,
                    "searchable": true,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": true,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
                {
                    "orderable": false,
                    "searchable": false,
                },
            ],
            "columnDefs": [],
            'select': {
                'style': 'multi'
            },
            "order": [
                [0, 'asc']
            ],
            "oLanguage": {
                "sSearch": "Pencarian",
                "sProcessing": '<image style="width:150px" src="http://superstorefinder.net/support/wp-content/uploads/2018/01/blue_loading.gif">',
            }
        });

		$('#propinsi').change(function() {
			const val = $(this).val()
			aktifPropinsi = val
			refreshTable()

			table.page(0).draw('page');
		})

		$('#mapel').change(function() {
			const val = $(this).val()
			aktifMapel = val
			refreshTable()

			table.page(0).draw('page');
		})
	})
</script>
