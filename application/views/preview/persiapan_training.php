<form action="<?=site_url('thesis/probabilitas')?>" method="POST" class="w-1/4 container mt-48 mx-auto border-2 border-gray-300 rounded-lg p-8 flex flex-col gap-6 shadow-lg">
	<a href="<?=site_url('thesis/transformasi_data')?>" class="text-sm text-blue-500"><i class="text-xs fa-solid fa-arrow-left mr-1"></i> Back</a>

	<div class="flex flex-col gap-2">
		<label>Total Data Peserta</label>
		<div class="flex flex-row gap-2">
			<span id="totalData" class="text-gray-500 font-medium"><?=$total_data_peserta?></span>
		</div>
	</div>
	<div class="flex flex-col gap-2">
		<label>Tentukan Besaran Data Training</label>
		<div class="flex flex-row gap-0">
			<input id="trainingPercentage" type="number" width="500" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5">
			<div class="flex flex-row gap-0">
				<span id="percentMode" onClick="changeMode('percent')" class="change-mode py-2 px-3 text-center bg-gray-300 hover:bg-blue-500 hover:text-white hover:border-blue-500 border border-gray-300 cursor-pointer">%</span>
				<span id="numberMode" onClick="changeMode('number')" class="change-mode py-2 px-3 text-center bg-gray-300 hover:bg-blue-500 hover:text-white hover:border-blue-500 border border-gray-300 cursor-pointer rounded-r-lg">0</span>
			</div>
		</div>
	</div>
	<div class="flex flex-col gap-2">
		<label>Total Data Training</label>
		<div class="flex flex-row gap-2">
			<span id="totalDataTraining" class="text-gray-500 font-medium">0</span>
			<input id="totalDataTrainingInput" name="limit" type="hidden" value="0">
		</div>
	</div>
	<div class="flex flex-col gap-2">
		<label>Total Data Uji</label>
		<div class="flex flex-row gap-2">
			<span id="totalDataUji" class="text-gray-500 font-medium">21717</span>
		</div>
	</div>

	<div class="w-full text-center mt-10">
		<button type="submit" class="px-5 py-3 text-xs font-bold rounded-lg bg-blue-500 text-white hover:bg-blue-700 hover:shadow-xl">HITUNG PROBABILITAS <i class="fa-solid fa-circle-right ml-1"></i></button>
	</div>
</form>

<script>
	let changeMode
	let activeMode = 'percent'

	$(document).ready(function() {
		setTimeout(() => {
			changeMode('percent')
		}, 100)

		const totalData = parseInt($('#totalData').text())

		$('#trainingPercentage').keyup(function() {
			calculate()
		})
		$('#trainingPercentage').keydown(function() {
			calculate()
		})
		$('#trainingPercentage').change(function() {
			calculate()
		})

		function calculate() {
			let value = parseInt($('#trainingPercentage').val())

			if (value != 0 && value < totalData) {
				console.log('recalculating..');
				console.log(activeMode);
				const totalDataTraining = activeMode == 'percent' ? Math.round(value*totalData/100) : value
				$('#totalDataTraining').text(totalDataTraining)
				$('#totalDataTrainingInput').val(totalDataTraining)
				// $('#totalDataUji').text(totalData-totalDataTraining)
				$('#totalDataUji').text(totalData)
			} else {
				$('#totalDataTraining').text(0)
				$('#totalDataTrainingInput').val(0)
				$('#totalDataUji').text(totalData)
			}
		}

		changeMode = (mode) => {
			$('.change-mode').removeClass('bg-blue-500')
			$('.change-mode').removeClass('border-blue-500')
			$('.change-mode').removeClass('text-white')
			$('.change-mode').addClass('bg-gray-300')
			$('.change-mode').addClass('border-gray-300')

			$('#' + mode + 'Mode').removeClass('bg-gray-300');
			$('#' + mode + 'Mode').removeClass('border-gray-300');
			$('#' + mode + 'Mode').addClass('bg-blue-500');
			$('#' + mode + 'Mode').addClass('border-blue-500');
			$('#' + mode + 'Mode').addClass('text-white');

			activeMode = mode
			calculate()
		}
	})
</script>
