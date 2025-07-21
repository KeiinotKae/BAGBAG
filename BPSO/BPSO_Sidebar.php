<?php
// Sidebar for Barangay Officials
$current_page = basename($_SERVER['PHP_SELF']);
$showReportsDropdown = ($current_page == 'reports.php' || strpos($current_page, 'report_') !== false);
?>

<!-- Sidebar with Toggle Button -->
<div id="sidebar" class="w-64 bg-primary text-white flex flex-col py-10 px-6 shadow-2xl transition-all duration-300 ease-in-out relative">
  <!-- Toggle Button Inside Sidebar -->
  <button id="toggleSidebar" class="absolute top-4 right-0 transform -translate-x-1/2 bg-primary rounded-full p-1.5 text-white hover:bg-gray-800 z-50">
    <svg id="iconOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
    </svg>
    <svg id="iconClose" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>

  <!-- Content inside sidebar that will hide when collapsed -->
  <div id="sidebarContent" class="flex-1 overflow-hidden">
    <div class="flex items-center space-x-4 mb-10 ml-2">
      <img src="../images/Gaid.png" class="w-12 h-12 rounded-full border-2 border-white shadow" alt="Logo">
      <div class="opacity-100 transition-opacity duration-300">
        <h2 class="text-lg font-bold">Welcome,</h2>
        <p class="text-sm text-blue-100"><?php echo $_SESSION['full_name']; ?></p>
        <p class="text-xs text-blue-200">Desk BPSO</p>
      </div>
    </div>

    <nav class="space-y-2 text-sm">

      <!-- Dashboard -->
      <a href="BPSO_Dashboard.php" class="flex items-center px-4 py-3 rounded-lg <?php echo ($current_page == 'BPSO_Dashboard.php') ? 'bg-white text-primary font-semibold shadow' : 'hover:bg-white hover:text-primary hover:font-semibold'; ?> transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M3 12l2-2m0 0l7-7 7 7m-7-7v18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="whitespace-nowrap">Dashboard</span>
      </a>

    

      <!-- blotters & reports -->
<a href="blotters.php" class="flex items-center px-4 py-3 rounded-lg <?php echo ($current_page == 'blotters.php') ? 'bg-white text-primary font-semibold shadow' : 'hover:bg-white hover:text-primary hover:font-semibold'; ?> transition">
  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M8 16h8M8 12h8M9 8h6M12 2a10 10 0 100 20 10 10 0 000-20z"/>
  </svg>
  <span class="whitespace-nowrap">Blotters & Reports</span>
</a>



      <!-- Profile -->
      <a href="#" class="flex items-center px-4 py-3 rounded-lg <?php echo ($current_page == '#') ? 'bg-white text-primary font-semibold shadow' : 'hover:bg-white hover:text-primary hover:font-semibold'; ?> transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M5.121 17.804A3 3 0 007 21h10a3 3 0 002.879-3.804L17.34 9.37a1 1 0 00-.97-.7h-8.74a1 1 0 00-.97.7L5.12 17.804z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="whitespace-nowrap">My Profile</span>
      </a>

      <!-- Logout -->
      <a href="logout.php" class="flex items-center px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 transition font-semibold">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="whitespace-nowrap">Logout</span>
      </a>
    </nav>
  </div>
</div>

<!-- JavaScript -->
<script>
  const toggleBtn = document.getElementById('toggleSidebar');
  const sidebar = document.getElementById('sidebar');
  const sidebarContent = document.getElementById('sidebarContent');
  const iconOpen = document.getElementById('iconOpen');
  const iconClose = document.getElementById('iconClose');

  // Sidebar Toggle
  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('w-16'); // Minimal width
    sidebar.classList.toggle('w-64'); // Full width
    sidebarContent.classList.toggle('hidden'); // Hide content
    iconOpen.classList.toggle('hidden');
    iconClose.classList.toggle('hidden');
  });

  // Reports Dropdown Toggle
  const reportsDropdownBtn = document.getElementById('reportsDropdownBtn');
  const reportsDropdownMenu = document.getElementById('reportsDropdownMenu');
  const dropdownArrow = document.getElementById('dropdownArrow');

  reportsDropdownBtn.addEventListener('click', function(e) {
    e.preventDefault(); // Prevent accidental redirect
    const isHidden = reportsDropdownMenu.classList.contains('hidden');
    reportsDropdownMenu.classList.toggle('hidden');
    dropdownArrow.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
  });
</script>