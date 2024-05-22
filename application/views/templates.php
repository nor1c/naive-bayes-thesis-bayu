<!DOCTYPE html>
<html>

<head>
  <title>Thesis Bayu</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css">
  
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="<?php // echo base_url('assets/adminator/style.css') ?>"> -->
  <style type="text/tailwindcss">
	@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap');
	@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap');

	* {
		font-family: "Inter", sans-serif !important;
	}
	::-webkit-scrollbar {
		width: 10px;
	}

	::-webkit-scrollbar-thumb {
		background: #dbebfd;
	}

	::-webkit-scrollbar-thumb:hover {
		background: #dbebfd;
	}

	@layer base {
		table {
			@apply border border-gray-200 rounded-md shadow-md !important;

			tbody {
				@apply text-xs !important;

				tr {
					@apply bg-white border-b !important;

					td {
						@apply border-b border-gray-200 !important;
					}
				}
			}
		}
	}

	@layer utilities {
		.poppins {
			font-family: "Poppins" !important;
		}
		.paginate_button {
			@apply rounded-lg;
			border-radius: 5px !important;
			
			.current {
				@apply bg-blue-100;
				border-radius: 5px !important;
			}
		}
		.paginate_button.current {
				background: #dbebfd !important;
				border: solid 1px #dbebfd !important;
		}
		.dataTables_scroll {
			@apply py-2;
		}
	}
  </style>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/fontawesome.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>

  <script>
	tailwind.config = {
		theme: {
		extend: {
			colors: {
			clifford: '#da373d',
			}
		}
		}
	}
  </script>

  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <!-- <script type="text/javascript" src="<?php // echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script> -->
  <script src="<?= base_url('assets/adminator/main.js') ?>" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="app">
  <!-- <nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?=site_url('')?>">Seleksi Peserta Diklat</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item active">
					<a class="nav-link" href="<?=site_url('thesis/import_peserta')?>">Import Peserta</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="<?=site_url('')?>">Input Data</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="<?=site_url('preview/pengumpulan')?>">Step 1 Result</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="<?=site_url('preview/penyaringan')?>">Step 2 Result</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="<?=site_url('preview')?>">Final Output</a>
				</li>
			</ul>
		
			<a class="nav-link" href="<?=site_url('login/logout')?>">Logout</a>
			</div>
		</div>
	</nav> -->

  <nav class="bg-white border-gray-200">
    <div class="w-full flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="<?=site_url('')?>" class="flex items-center space-x-3 rtl:space-x-reverse">
        <span class="poppins font-medium self-center text-lg whitespace-nowrap">Diklat</span>
      </a>
      <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        <button type="button"
          class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300"
          id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
          data-dropdown-placement="bottom">
          <span class="sr-only">Open user menu</span>
          <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="user photo">
        </button>
        <!-- Dropdown menu -->
        <div
          class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow"
          id="user-dropdown">
          <div class="px-4 py-3">
            <span class="block text-xs text-gray-900">M. Bayu Khrisna</span>
          </div>
          <ul class="py-2" aria-labelledby="user-menu-button">
            <li>
              <a href="#"
                class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">Sign
                out</a>
            </li>
          </ul>
        </div>
        <button data-collapse-toggle="navbar-user" type="button"
          class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
          aria-controls="navbar-user" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M1 1h15M1 7h15M1 13h15" />
          </svg>
        </button>
      </div>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
        <ul
          class="flex flex-col text-sm p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
          <li>
            <a href="<?=site_url('')?>" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Home</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="w-full flex items-center justify-center mb-20"> <!-- h-screen -mt-20 -->
		<?php $this->load->view($page)?>
  </main>

  <script>
  let table
	let cadanganTable

  refreshTable = function() {
    table.ajax.reload(null, false)
  }
	
  refreshCadanganTable = function() {
    cadanganTable.ajax.reload(null, false)
  }

  let filters = []
  $('#filter').submit(function(e) {
    e.preventDefault()

    filters.filters = $('#filter :input').serialize()

    refreshTable()
  })
  </script>
  <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
