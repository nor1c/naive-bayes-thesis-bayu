<style>
	.row {
		display: flex;
		justify-content: center;
		/* Horizontal centering */
		align-items: center;
		/* Vertical centering */
	}
</style>

<div class="container mx-auto text-xs mt-48">
	<form id="formImportData" enctype="multipart/form-data" method="post" action="thesis/importMasterData" class="w-full">
		<div class="flex flex-row justify-center">
			<div class="flex flex-row rounded-xl shadow-lg">
				<!-- IMPORT DATA MASTER -->
				<div class="border border-2 p-10 rounded-l-xl">
					<div class="w-full text-center text-base font-medium">Pilih File SIMPKB/Dapodik</div>

					<div class="my-10 w-full justify-center flex">
						<img src="https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png" width="100">
					</div>

					<input type="file" name="master_data" accept=".csv" class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="file_input" type="file">
				</div>

				<!-- IMPORT DATA PESERTA -->
				<div class="border-t-2 border-b-2 p-10">
					<div class="w-full text-center text-base font-medium">Pilih File Peserta Diklat</div>

					<div class="my-10 w-full justify-center flex">
						<img src="https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png" width="100">
					</div>

					<input type="file" name="data_mentah" accept=".csv" class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="file_input" type="file">
				</div>

				<!-- IMPORT DATA PEMETAAN -->
				<div class="border border-2 p-10 rounded-r-xl">
					<div class="w-full text-center text-base font-medium">Pilih File Pemetaan</div>

					<div class="my-10 w-full justify-center flex">
						<img src="https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png" width="100">
					</div>

					<input type="file" name="data_pemetaan" accept=".csv" class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="file_input" type="file">
				</div>
			</div>
		</div>
		<div class="flex flex-row justify-center mt-5 text-sm">
			Sudah mengimport file? <a href="<?=site_url('preview/pengumpulan')?>" class="text-blue-500 hover:text-blue-700 font-medium ml-1 hover:underline">Mulai</a>
		</div>

		<div class="mt-10 w-full mx-auto text-center">
			<button class="gap-2 px-5 py-3 rounded-lg font-bold bg-blue-500 text-white hover:bg-blue-700 hover:shadow-xl">
				<div class="flex flex-row gap-2">
					<span id="button-text">IMPORT DATA</span>
					<i id="button-import-icon" class="fa-solid fa-file-import"></i>
					<svg id="button-spinner" aria-hidden="true" class="w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
						<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
					</svg>
				</div>
			</button>
		</div>
	</form>
</div>

<!-- <div class="container">
	<div class="row gap-20 masonry pos-r" style="position: relative; height: 1043.3px; display: flex; justify-content: center; align-items: center;">
		<div class="masonry-sizer col-md-6"></div>
		<div class="masonry-item col-md-6" style="position: absolute; left: 0%; top: 0px;">
			<div class="bgc-white p-20 bd">
				<form enctype="multipart/form-data" method="post" action="thesis/importMasterData">
					<div class="row">
						<div class="col-md-4">
							<div>Pilih Data Pusat Dapodik</div>

							<div class="mT-20">
								<img src="https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png" width="100">
							</div>

							<input class="mT-20" type="file" name="master_data">
						</div>

						<div class="col-md-4">
							<div>Pilih Data Peserta Diklat</div>

							<div class="mT-20">
								<img src="https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png" width="100">
							</div>

							<input class="mT-20" type="file" name="data_mentah">
						</div>

						<div class="col-md-4">
							<div>Pilih Data Pemetaan</div>

							<div class="mT-20">
								<img src="https://download.logo.wine/logo/Microsoft_Excel/Microsoft_Excel-Logo.wine.png" width="100">
							</div>

							<input class="mT-20" type="file" name="data_pemetaan">
						</div>
					</div>

					<div class="mT-50" style="width: 100%; text-align: center;">
						<button class="btn cur-p btn-outline-success">PROSES DATA</button>
					</div>
				</form>
			</div>
		</div>
		<div class="masonry-item col-md-6" style="position: absolute; left: 50%; top: 0px;">
			<div class="bgc-white p-20 bd">
				<h6 class="c-grey-900">SELAMAT DATANG, <b>NAMA ANDA DISINI</b></h6>
				<div class="mT-20">
					<img src="https://static.vecteezy.com/system/resources/previews/001/840/618/non_2x/picture-profile-icon-male-icon-human-or-people-sign-and-symbol-free-vector.jpg" width="250" style="border-radius:5px;">

					<div class="mT-20">
						<b>72091659012512</b>
						<div>Sekretariat Khusus</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> -->

<script>
	$(document).ready(function() {
		$('#button-import-icon').show()
		$('#button-spinner').hide()

		$('#formImportData').submit(function() {
			$('#button-text').text('MENGIMPORT DATA..')

			$('#button-import-icon').hide()
			$('#button-spinner').show()
		})
	})
</script>
