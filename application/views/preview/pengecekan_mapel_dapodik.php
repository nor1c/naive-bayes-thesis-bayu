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
		<li class="flex items-center text-sm text-blue-500">
			<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-500 rounded-full shrink-0">5</span>
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

	<h3 class="text-lg font-medium">5.2. Pengecekan Mata Pelajaran sesuai DAPODIK</h3>

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
					<th width="250">MaPel DAPODIK</th>
					<th>No. HP</th>
					<th>Email</th>
					<th width="80">Usia</th>
					<th width="200">Propinsi</th>
					<th width="10">Verifikasi</th>
				</tr>
			</thead>
		</table>
	</div>

	<div class="w-full text-right mt-12">
		<a href="<?=site_url('preview/hasil_pengecekan_mapel_dapodik')?>" class="px-5 py-3 text-xs font-bold rounded-lg bg-blue-500 text-white hover:bg-blue-700 hover:shadow-xl">HASIL PENGECEKAN MAPEL DAPODIK <i class="fa-solid fa-circle-right ml-1"></i></a>
	</div>
</div>

<ul class="fixed bg-white bottom-0 left-2 flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200">
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

foreach ($mapels as $mapel) {
	echo '<li class="me-2">
		<a id="'.str_replace('.', 'f_dot', str_replace(' ', 'f_space', str_replace('/', 'f_slash', $mapel))).'" href="#" onClick="changeMapel(\''.$mapel.'\', \''.str_replace('.', 'f_dot', str_replace(' ', 'f_space', str_replace('/', 'f_slash', $mapel))).'\')" class="mapel inline-block p-2 text-xs shadow-md border border-b-0 border-gray-300 hover:bg-gray-100 rounded-t-lg active">'.$mapel.'</a>
	</li>';
}
?>
</ul>

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
                "url": "<?=site_url('preview/data_pengecekan_mapel_dapodik')?>",
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
            // "columnDefs": [
			// 	{
			// 		"targets": 7,
			// 		"render": function(data, row, row) {
			// 			return row[6] + ' - ' + row[7] ? 'Sama' : 'Tidak Sama'
			// 		}
			// 	}
			// ],
            // "fnRowCallback": function(nRow, data, iDisplayIndex, iDisplayIndexFull) {
            //     if (data[6] != (data[7] != null ? data[7].trim() : null)) {
            //         $('td', nRow).css('background-color', '#ffe3e3');
            //     }
            // },
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

			refreshTable()
		}

		setTimeout(() => {
			changeMapel('Administrasi Profesional/OTKP', 'Administrasif_spaceProfesionalf_slashOTKP')
		}, 100)

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
