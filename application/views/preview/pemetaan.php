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
				<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0">2</span>
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
		<a href="<?=site_url('thesis/persiapan_training')?>"">
			<li class="flex items-center text-sm text-gray-500">
				<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0">4</span>
				Training & Uji
				<svg class="w-2 h-2 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
				</svg>
			</li>
		</a>
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
		<li class="flex items-center text-sm text-blue-500">
			<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-500 rounded-full shrink-0">7</span>
			Pemetaan
		</li>
	</ol>

	<div class="w-full flex flex-row justify-between">
		<div>
			<h3 class="text-lg font-medium">7. Pemetaan berdasar Mata Pelajaran dan Propinsi</h3>
		
			<div class="overflow-x-auto shadow-md sm:rounded-lg mt-5">
				<table class="w-full text-left text-gray-500">
					<tbody>
						<tr class="border-b border-gray-200">
							<td class="px-6 py-4 font-semibold w-1/4">PROGLI</td>
							<td class="current-mapel px-6 py-4 bg-gray-50">0</td>
						</tr>
						<!-- <tr class="border-b border-gray-200">
							<td class="px-6 py-4 font-semibold w-1/2">KELAS</td>
							<td class="px-6 py-4 bg-gray-50">A</td>
						</tr> -->
						<tr class="border-b border-gray-200">
							<td class="px-6 py-4 font-semibold w-1/4">PB</td>
							<td class="current-pb px-6 py-4 bg-gray-50"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div>
			<a href="<?=site_url('preview/export')?>" class="px-5 py-3 text-xs font-bold rounded-lg bg-green-700 text-white hover:bg-green-700 hover:shadow-xl">
				<i class="fa-solid fa-file-excel mr-1"></i> UNDUH EXCEL
			</a>
		</div>
	</div>

	<div class="mt-10">
		<table id="previewTable" class="w-full text-sm text-left rtl:text-right text-gray-500" cellspacing="0">
			<thead class="text-xs text-gray-700 uppercase bg-blue-100">
				<tr>
					<th width="60">No. Urut</th>
					<th width="220">Nama</th>
					<th width="150">NIK</th>
					<th width="150">No. UKG</th>
					<th width="150">NUPTK</th>
					<th width="150">NPSN</th>
					<th width="250">MaPel</th>
					<th>No. HP</th>
					<th>Email</th>
					<th width="80">Usia</th>
					<th width="200">Propinsi</th>
				</tr>
			</thead>
		</table>

		<!-- Cadangan -->
		<h3 class="mt-10 mb-2 text-sm font-medium">CADANGAN</h3>
		<table id="cadanganTable" class="w-full text-sm text-left rtl:text-right text-gray-500" cellspacing="0">
			<thead class="text-xs text-gray-700 uppercase bg-blue-100">
				<tr>
					<th width="60">No. Urut</th>
					<th width="220">Nama</th>
					<th width="150">NIK</th>
					<th width="150">No. UKG</th>
					<th width="150">NUPTK</th>
					<th width="150">NPSN</th>
					<th width="250">MaPel</th>
					<th>No. HP</th>
					<th>Email</th>
					<th width="80">Usia</th>
					<th width="200">Propinsi</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<?php
$mapels = array(
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
?>

<div class="w-full fixed ml-10 bottom-0 flex flex-wrap text-sm w-96">
	<div>
		<button id="dropdownMapelButton" data-dropdown-toggle="dropdownMapel" data-dropdown-placement="top" class="flex flex-row justify-between w-72 me-3 mb-1 md:mb-0 bg-gray-100 hover:bg-blue-800 hover:text-white ring-4 outline-none ring-blue-300 font-medium rounded-t-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
			<span class="current-mapel"></span>
			<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
			</svg>
		</button>
		
		<!-- Dropdown menu -->
		<div id="dropdownMapel" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-72">
			<ul class="py-2 text-sm border border-gray-300" aria-labelledby="dropdownMapelButton">
				<?php
					foreach ($mapels as $mapel) {
						echo '<li>
							<a id="'.str_replace('.', 'f_dot', str_replace(' ', 'f_space', str_replace('/', 'f_slash', $mapel))).'" href="#" onClick="changeMapel(\''.$mapel.'\', \''.str_replace('.', 'f_dot', str_replace(' ', 'f_space', str_replace('/', 'f_slash', $mapel))).'\')" class="mapel block px-4 py-2 hover:bg-gray-100">'.$mapel.'</a>
						</li>';
					}
				?>
			</ul>
		</div>
	</div>
	<div>
		<button id="dropdownClassButton" data-dropdown-toggle="dropdownClass" data-dropdown-placement="top" class="flex flex-row justify-between w-96 me-3 mb-3 md:mb-0 bg-gray-100 hover:bg-blue-800 hover:text-white ring-4 outline-none ring-blue-300 font-medium rounded-t-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
			<span class="current-pb"></span>
			<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
			</svg>
		</button>
		
		<!-- Dropdown menu -->
		<div id="dropdownClass" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-96">
			<ul id="classes" class="py-2 text-sm border border-gray-300" aria-labelledby="dropdownClassButton"></ul>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		let aktifPropinsi = 0;
		let aktifMapel = 'Administrasi Profesional/OTKP';
		let aktifPb = 'SMKN 1 Pekanbaru'

		table = $('#previewTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollCollapse": true,
            "aLengthMenu": [
                [10, 15, 20, 50, 100, 999999999],
                [10, 15, 20, 50, 100, 'Semua Data'],
            ],
            "pageLength": 999999999,
            "processing": true,
            "serverSide": true,
            "searching": false,
			"paging": false,
			"info": false,
			// "scrollY": "500px",
			// "scrollCollapse": true,
            "ajax": {
                "url": "<?=site_url('preview/data_pemetaan')?>",
                'method': 'POST',
                'data': function(d) {
                    d.draw = d.draw || 1
					filters.mapel = aktifMapel
					filters.pb = aktifPb
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
            ],
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

		cadanganTable = $('#cadanganTable').DataTable({
            "sDom": "Rlfrtip",
            "scrollCollapse": true,
            "aLengthMenu": [
                [10, 15, 20, 50, 100, 999999999],
                [10, 15, 20, 50, 100, 'Semua Data'],
            ],
            "pageLength": 999999999,
            "processing": true,
            "serverSide": true,
            "searching": false,
			"paging": false,
			"info": false,
			// "scrollY": "500px",
			// "scrollCollapse": true,
            "ajax": {
                "url": "<?=site_url('preview/data_pemetaan_cadangan')?>",
                'method': 'POST',
                'data': function(d) {
                    d.draw = d.draw || 1
					filters.mapel = aktifMapel
					filters.pb = aktifPb
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
            ],
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

		changeMapel = (mapel, mapell) => {
			aktifMapel = mapel

			$('.mapel').removeClass('bg-blue-500 text-white hover:bg-blue-500 border-blue-500')
			$('#' + mapell).addClass('bg-blue-500 text-white hover:bg-blue-500 border-blue-500')

			$('.current-mapel').html(aktifMapel)

			fetchClasses(mapel)
		}

		setTimeout(() => {
			changeMapel('Administrasi Profesional/OTKP', 'Administrasif_spaceProfesionalf_slashOTKP')
		}, 100)

		fetchClasses = (mapel) => {
			$.ajax({
				method: 'GET',
				url: "<?=site_url('preview/get_pb_list_each_mapel')?>?mapel=" + mapel,
			})
			.then((result) => {
				result = JSON.parse(result)
				
				let classes = ''

				for (let sekolah in result) {
					let pb = result[sekolah].pb

					if (sekolah == 0) {
						aktifPb = pb
					}
					
					classes += '<li>' +
							'<a id="'+(pb.replaceAll('.', 'f_dot').replaceAll(' ', 'f_space').replaceAll('/', 'f_slash'))+'" href="#" onClick="changePb(\''+mapel+'\', \''+(pb)+'\')" class="pb block px-4 py-2 hover:bg-gray-100">'+pb+'</a>' +
						'</li>';
				}

				$('#classes').html(classes)

				// set default selected PB
				changePb(mapel, aktifPb)
			})
		}

		changePb = (mapel, pb) => {
			aktifPb = pb

			$('.pb').removeClass('bg-blue-500 text-white hover:bg-blue-500 border-blue-500')
			$('#' + pb.replaceAll('.', 'f_dot').replaceAll(' ', 'f_space').replaceAll('/', 'f_slash')).addClass('bg-blue-500 text-white hover:bg-blue-500 border-blue-500')

			$('.current-pb').html(aktifPb)

			refreshTable()
			refreshCadanganTable()
		}

		$('#propinsi').change(function() {
			const val = $(this).val()
			aktifPropinsi = val
			refreshTable()
			refreshCadanganTable()

			table.page(0).draw('page');
		})

		$('#mapel').change(function() {
			const val = $(this).val()
			aktifMapel = val
			refreshTable()
			refreshCadanganTable()

			table.page(0).draw('page');
		})
	})
</script>
