<div class="px-5 mt-10 w-full mx-auto text-xs">
	<div class="">
		<!-- filters -->
		<form id="filter" class="flex flex-row justify-between mb-10">
			<div class="flex flex-row gap-2">
				<select name="propinsi" id="propinsi"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
					<option value="" selected>Pilih Propinsi</option>
					<?php foreach ($propinsi as $p) { ?>
						<option value="<?=$p['propinsi']?>"><?=$p['propinsi']?></option>
					<?php } ?>
				</select>
				<select name="mapel" id="mapel"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
					<option value="" selected>Pilih Mapel</option>
					<?php foreach ($mapel as $p) { ?>
						<option value="<?=$p['mapel']?>"><?=$p['mapel']?></option>
					<?php } ?>
				</select>
			</div>
			<button class="px-5 py-3 text-xs font-bold rounded-lg bg-green-600 text-white hover:bg-green-700 hover:shadow-xl">SIMPAN KE EXCEL</button>
		</form>

		<table id="previewTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" cellspacing="0">
			<thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
				<tr>
					<th scope="col" class="px-6 py-3">#</th>
					<th scope="col" class="px-6 py-3">Nama</th>
					<th scope="col" class="px-6 py-3">NIK</th>
					<th scope="col" class="px-6 py-3">No. UKG</th>
					<th scope="col" class="px-6 py-3">NUPTK</th>
					<th scope="col" class="px-6 py-3">NPSN</th>
					<th scope="col" class="px-6 py-3" width="200">Propinsi</th>
					<!-- <th scope="col" class="px-6 py-3">Instansi</th> -->
					<th scope="col" class="px-6 py-3" width="300">Mata Pelajaran</th>
					<th scope="col" class="px-6 py-3">Keputusan</th>
				</tr>
			</thead>
		</table>
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
            "pageLength": 15,
            "processing": true,
            "serverSide": true,
            "searching": false,
			"scrollY": "600px",
			// "paging": false,
			"scrollCollapse": true,
            "ajax": {
                "url": "<?=site_url('preview/data')?>",
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
                // {
                //     "orderable": false,
                //     "searchable": false,
                // },
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
            "columnDefs": [
				{
					"targets": 8,
					"render": function(data, type, row) {
						return row[8]
					}
				}
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData[8] == 'Tidak Layak') {
                    $('td', nRow).css('background-color', '#ffd5d1');
                } else {
					// $('td', nRow).css('background-color', '#d1ffd1');
				}
            },
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
