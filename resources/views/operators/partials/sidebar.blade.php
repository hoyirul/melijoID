<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">MELIJO <sup>.id</sup></div>
  </a>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ ($title == 'Dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="/operator/dashboard">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  <!-- Heading -->
  <div class="sidebar-heading">
    Masters
  </div>
  <!-- Nav Item - Pages Collapse Menu -->
  @if (Auth::user()->role_id == 1)
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
        aria-expanded="true" aria-controls="collapseUsers">
      <i class="fas fa-fw fa-users"></i>
      <span>Users Data</span>
      </a>
      <div id="collapseUsers" class="collapse {{ ($title == 'Operator Table' || $title == 'Customer Table' || $title == 'Seller Table') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Master Data</h6>
          <a class="collapse-item {{ ($title == 'Operator Table') ? 'active' : '' }}" href="/operator/operator">Operators</a>
          <a class="collapse-item {{ ($title == 'Customer Table') ? 'active' : '' }}" href="/operator/customer">Customers</a>
          <a class="collapse-item {{ ($title == 'Seller Table') ? 'active' : '' }}" href="/operator/seller">Sellers</a>
        </div>
      </div>
    </li>  
  @endif

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePlottings"
      aria-expanded="true" aria-controls="collapsePlottings">
    <i class="fas fa-fw fa-check"></i>
    <span>Setting Plot</span>
    </a>
    <div id="collapsePlottings" class="collapse {{ ($title == 'Plotting Table') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Plot Buyer</h6>
        <a class="collapse-item {{ ($title == 'Plotting Table') ? 'active' : '' }}" href="/operator/plotting">Plotting</a>
      </div>
    </div>
  </li>  
  
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      aria-expanded="true" aria-controls="collapseTwo">
    <i class="fas fa-fw fa-cog"></i>
    <span>Components</span>
    </a>
    <div id="collapseTwo" class="collapse {{ ($title == 'Role Table' || $title == 'Category Table' || $title == 'Promo Table' || $title == 'Unit Table') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Master Data</h6>
        @if (Auth::user()->role_id == 1)
          <a class="collapse-item {{ ($title == 'Role Table') ? 'active' : '' }}" href="/operator/role">Roles</a>
        @endif
        <a class="collapse-item {{ ($title == 'Category Table') ? 'active' : '' }}" href="/operator/category">Categories</a>
        <a class="collapse-item {{ ($title == 'Unit Table') ? 'active' : '' }}" href="/operator/unit">Units</a>
        <a class="collapse-item {{ ($title == 'Promo Table') ? 'active' : '' }}" href="/operator/promo">Promos</a>
      </div>
    </div>
  </li>
  <!-- Nav Item - Utilities Collapse Menu -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecipes"
      aria-expanded="true" aria-controls="collapseRecipes">
    <i class="fas fa-fw fa-list"></i>
    <span>Recipes</span>
    </a>
    <div id="collapseRecipes" class="collapse {{ ($title == 'Recipe Table' || $title == 'Recipe Category Table') ? 'show' : '' }}" aria-labelledby="headingUtilities"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Master Recipes:</h6>
        <a class="collapse-item {{ ($title == 'Recipe Table') ? 'active' : '' }}" href="/operator/recipe">Recipes</a>
        <a class="collapse-item {{ ($title == 'Recipe Category Table') ? 'active' : '' }}" href="/operator/recipe_category">Recipe Categories</a>
      </div>
    </div>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  <!-- Heading -->
  <div class="sidebar-heading">
    Transactions
  </div>
  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaction"
      aria-expanded="true" aria-controls="collapseTransaction">
    <i class="fas fa-fw fa-folder"></i>
    <span>Transactions</span>
    </a>
    <div id="collapseTransaction" class="collapse {{ ($title == 'Transaction Table') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">All Transaction:</h6>
        <a class="collapse-item {{ ($title == 'Transaction Table') ? 'active' : '' }}" href="/operator/transaction">Transactions</a>
      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayment"
      aria-expanded="true" aria-controls="collapsePayment">
    <i class="fas fa-fw fa-chart-pie"></i>
    <span>Payments</span>
    </a>
    <div id="collapsePayment" class="collapse {{ ($title == 'Payment All Table' || $title == 'Payment Table (Paid)' || $title == 'Payment Table (Unpaid)' || $title == 'Payment Table (Processing)' || $title == 'Payment Table (Done)') || $title == 'Payment Table (Canceled)' ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Status Payments:</h6>
        <a class="collapse-item {{ ($title == 'Payment Table (Paid)') ? 'active' : '' }}" href="/operator/payment/paid">Paid</a>
        <a class="collapse-item {{ ($title == 'Payment Table (Unpaid)') ? 'active' : '' }}" href="/operator/payment/unpaid">Unpaid</a>
        <a class="collapse-item {{ ($title == 'Payment Table (Processing)') ? 'active' : '' }}" href="/operator/payment/processing">Processing</a>
        <a class="collapse-item {{ ($title == 'Payment Table (Done)') ? 'active' : '' }}" href="/operator/payment/waiting">Waiting</a>
        <a class="collapse-item {{ ($title == 'Payment Table (Canceled)') ? 'active' : '' }}" href="/operator/payment/canceled">Canceled</a>
        <div class="collapse-divider"></div>
        <h6 class="collapse-header">All Payments:</h6>
        <a class="collapse-item {{ ($title == 'Payment All Table') ? 'active' : '' }}" href="/operator/payment/all">Payments</a>
      </div>
    </div>
  </li>
  
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
  
</ul>