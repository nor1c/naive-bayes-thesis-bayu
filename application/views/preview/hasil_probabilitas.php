<div class="w-full px-5">
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
			<li class="flex items-center text-sm text-gray-500 hover:text-blue-500">
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
		<li class="flex items-center text-sm text-blue-500">
			<span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-500 rounded-full shrink-0">4</span>
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

	<div class="w-1/2 mx-auto">
		<h3 class="text-lg font-medium">4.1. Hasil Perhitungan Probabilitas Data Training</h3>

		<div class="mt-10">
			<h3 class="text-base font-medium"># Detail Pengaturan Data Training</h3>

			<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
				<table class="w-full text-sm text-left rtl:text-right text-gray-500">
					<tbody>
						<tr class="border-b border-gray-200">
							<td class="px-6 py-4 font-semibold w-1/3">Total Data Training</td>
							<td class="px-6 py-4 bg-gray-50"><?=$data['jml_data_training']?></td>
						</tr>
						<tr class="border-b border-gray-200">
							<td class="px-6 py-4 font-semibold w-1/3">Jumlah Data Layak</td>
							<td class="px-6 py-4 bg-gray-50"><?=$data['jml_data_layak']?></td>
						</tr>
						<tr class="border-b border-gray-200">
							<td class="px-6 py-4 font-semibold w-1/3">Jumlah Data Tidak Layak</td>
							<td class="px-6 py-4 bg-gray-50"><?=$data['jml_data_tidak_layak']?></td>
						</tr>
						<tr class="border-b border-gray-200">
							<td class="px-6 py-4 font-semibold w-1/3">C1</td>
							<td class="px-6 py-4 bg-gray-50"><?=$data['c1']?></td>
						</tr>
						<tr class="border-b border-gray-200">
							<td class="px-6 py-4 font-semibold w-1/3">C0</td>
							<td class="px-6 py-4 bg-gray-50"><?=$data['c0']?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="mt-10">
			<?php 
				$no = 1;
				foreach ($data['probabilities'] as $key => $probability) {
			?>
				<div class="mb-10">
					<h4 class="text-base font-medium"><?=$no . '. ' . $probability['name']?></h4>
					<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
						<table class="w-full text-sm text-left rtl:text-right text-gray-500">
							<thead class="text-xs text-gray-700 uppercase">
								<tr>
									<th scope="col" class="px-6 py-3">
										
									</th>
									<th scope="col" class="px-6 py-3 bg-gray-50 text-center" colspan="2">
										Jumlah Kejadian "Dipilih"
									</th>
									<th scope="col" class="px-6 py-3 bg-gray-50 text-center" colspan="2">
										Probabilitas
									</th>
								</tr>
							</thead>
							<thead class="text-xs text-gray-700 uppercase">
								<tr class="border-b border-gray-200">
									<th scope="col" class="px-6 py-3">
										
									</th>
									<th scope="col" class="px-6 py-3 bg-green-50">
										Layak
									</th>
									<th scope="col" class="px-6 py-3 bg-orange-50">
										Tidak Layak
									</th>
									<th scope="col" class="px-6 py-3 bg-green-50">
										Layak (C1)
									</th>
									<th scope="col" class="px-6 py-3 bg-orange-50">
										Tidak Layak (C0)
									</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$jml_c1_total = 0;
									$jml_c0_total = 0;
									$jml_c1 = 0;
									$jml_c0 = 0;
									foreach ($probability['data'] as $kriteria) {
								?>
									<tr class="border-b border-gray-200">
										<th class="px-6 py-4">
											<?=$kriteria['name']?>
										</th>
										<td class="px-6 py-4 bg-green-50">
											<?php $jml_c1_total += $kriteria['c1_total'] ?>
											<?=$kriteria['c1_total']?>
										</td>
										<td class="px-6 py-4 bg-orange-50">
											<?php $jml_c0_total += $kriteria['c0_total'] ?>
											<?=$kriteria['c0_total']?>
										</td>
										<td class="px-6 py-4 bg-green-50">
											<?php $jml_c1 += $kriteria['c1'] ?>
											<?=$kriteria['c1']?>
										</td>
										<td class="px-6 py-4 bg-orange-50">
											<?php $jml_c0 += $kriteria['c0'] ?>
											<?=$kriteria['c0']?>
										</td>
									</tr>
								<?php } ?>
								<tr class="border-b border-gray-200">
									<th class="px-6 py-4">
										Jumlah
									</th>
									<td class="px-6 py-4 bg-green-50">
										<?=$jml_c1_total?>
									</td>
									<td class="px-6 py-4 bg-orange-50">
										<?=$jml_c0_total?>
									</td>
									<td class="px-6 py-4 bg-green-50">
										<?=$jml_c1?>
									</td>
									<td class="px-6 py-4 bg-orange-50">
										<?=$jml_c0?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			<?php $no++; } ?>

			<div class="w-full text-center mt-10">
				<a href="<?=site_url('thesis/pengujian')?>" type="submit" class="px-5 py-3 text-xs font-bold rounded-lg bg-blue-500 text-white hover:bg-blue-700 hover:shadow-xl">PROSES DATA UJI <i class="fa-solid fa-circle-right ml-1"></i></a>
			</div>
		</div>
	</div>
</div>
