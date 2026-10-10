@php
if (session('login_type') === 'supplier') {
    $supplier = \App\Models\AddSupplier::find(session('supplier_id'));
} else {
    $supplier = \App\Models\SubSupplier::find(session('sub_supplier_id'));
}
$nameInitial = strtoupper(substr(trim($supplier->name ?? 'S'), 0, 1));
$emailInitial = strtoupper(substr(trim($supplier->email ?? 't'), 0, 1));
@endphp
<aside class="sidebar" id="sidebar">
    <div class="supplier-profile">
        <div class="supplier-avatar">
            {{ $nameInitial }}{{ $emailInitial }}
        </div>
        <div class="supplier-info">
            <strong>
                {{ $supplier->name ?? 'Sun Leisure World - Thailand Tour' }}
            </strong>
            <span>
                {{ $supplier->email ?? 'thailandtours@sunleisureworld.net' }}
            </span>
        </div>
        <button class="profile-more">
            <i class="fa-solid fa-ellipsis-vertical"></i>
        </button>
    </div>
    <nav class="sidebar-nav">
        @if(session('login_type') === 'supplier')
        <div class="menu-label">MAIN</div>
        <a href="{{ route('dashboard') }}" class="menu-item active">
            <span class="menu-icon">
                <i class="fa-solid fa-house"></i>
            </span>
            <span>Dashboard</span>
        </a>
        <a href="{{ url('all-bookings')}}" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </span>
            <span>My Booking</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-hotel"></i>
            </span>
            <span>My Hotel Booking</span>
        </a>
        <div class="menu-label">MANAGEMENT</div>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-user-plus"></i>
            </span>
            <span>Add Sub Supplier</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-user-tie"></i>
            </span>
            <span>Add Guide</span>
        </a>
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-map-location-dot"></i>
                </span>
                <span>Tour</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="{{ url('tours-list')}}" class="submenu-item active">
                <i class="fa-solid fa-list"></i>
                Tour List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Tour
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-money-bill-wave"></i>
                Manage Tour Price
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-clock"></i>
                Add Time
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-user-plus"></i>
                Add Tour Booking
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-calendar-xmark"></i>
                Tour Block Date
                </a>
            </div>
        </div>
        <!--TRANSFER-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-car-side"></i>
                </span>
                <span>Transfer</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-list"></i>
                Transfer List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Transfer
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-ship"></i>
                Ferry Transfer List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Ferry Transfer
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-user-plus"></i>
                Add Transfer Booking
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-image"></i>
                Upload Transfer Images
                </a>
            </div>
        </div>
        <!--PACKAGES-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-box-open"></i>
                </span>
                <span>Packages</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-list"></i>
                Packages List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Packages
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-link"></i>
                External Packages List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add External Packages
                </a>
            </div>
        </div>
        <!--WEDDING-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-ring"></i>
                </span>
                <span>Wedding</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-list"></i>
                Wedding List
                </a>

                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Wedding Package
                </a>
            </div>
        </div>
        <!--VIATOR-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-user"></i>
                </span>
                <span>Viator</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-list"></i>
                Viator Booking
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-chart-line"></i>
                Viator Report
                </a>
            </div>
        </div>
        <!-- FINANCE -->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-wallet"></i>
                </span>
                <span>Finance Section</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Payment Report
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-money-bill-transfer"></i>
                Transactions
                </a>
            </div>
        </div>
        <div class="menu-label">OTHER</div>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-bell-concierge"></i>
            </span>
            <span>Hotel</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-building"></i>
            </span>
            <span>Hotels New</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-utensils"></i>
            </span>
            <span>Meal</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-chart-column"></i>
            </span>
            <span>My Report</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-laptop"></i>
            </span>
            <span>Training</span>
        </a>
        @elseif(session('login_type') === 'subsupplier')
        <div class="menu-label">MAIN</div>
        <a href="{{ route('dashboard') }}" class="menu-item active">
            <span class="menu-icon">
                <i class="fa-solid fa-house"></i>
            </span>
            <span>Dashboard</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </span>
            <span>My Booking</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-hotel"></i>
            </span>
            <span>My Hotel Booking</span>
        </a>
        <div class="menu-label">MANAGEMENT</div>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-user-plus"></i>
            </span>
            <span>Add Sub Supplier</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-user-tie"></i>
            </span>
            <span>Add Guide</span>
        </a>
        <!--TOUR-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-map-location-dot"></i>
                </span>
                <span>Tour</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item active">
                <i class="fa-solid fa-list"></i>
                Tour List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Tour
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-money-bill-wave"></i>
                Manage Tour Price
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-clock"></i>
                Add Time
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-user-plus"></i>
                Add Tour Booking
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-calendar-xmark"></i>
                Tour Block Date
                </a>
            </div>
        </div>
        <!--TRANSFER-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-car-side"></i>
                </span>
                <span>Transfer</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-list"></i>
                Transfer List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Transfer
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-ship"></i>
                Ferry Transfer List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Ferry Transfer
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-user-plus"></i>
                Add Transfer Booking
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-image"></i>
                Upload Transfer Images
                </a>
            </div>
        </div>
        <!--PACKAGES-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-box-open"></i>
                </span>
                <span>Packages</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-list"></i>
                Packages List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Packages
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-link"></i>
                External Packages List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add External Packages
                </a>
            </div>
        </div>
        <!--WEDDING-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-ring"></i>
                </span>
                <span>Wedding</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-list"></i>
                Wedding List
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-circle-plus"></i>
                Add Wedding Package
                </a>
            </div>
        </div>
        <!--VIATOR-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-user"></i>
                </span>
                <span>Viator</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-list"></i>
                Viator Booking
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-chart-line"></i>
                Viator Report
                </a>
            </div>
        </div>
        <!--FINANCE-->
        <div class="sidebar-dropdown">
            <button class="menu-item dropdown-toggle" type="button">
                <span class="menu-icon">
                <i class="fa-solid fa-wallet"></i>
                </span>
                <span>Finance Section</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="submenu">
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Payment Report
                </a>
                <a href="#" class="submenu-item">
                <i class="fa-solid fa-money-bill-transfer"></i>
                Transactions
                </a>
            </div>
        </div>
        <div class="menu-label">OTHER</div>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-bell-concierge"></i>
            </span>
            <span>Hotel</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-building"></i>
            </span>
            <span>Hotels New</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-utensils"></i>
            </span>
            <span>Meal</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-chart-column"></i>
            </span>
            <span>My Report</span>
        </a>
        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-laptop"></i>
            </span>
            <span>Training</span>
        </a>
        @endif
    </nav>
   <!--LOGOUT-->
   <div class="sidebar-bottom">
      <a
         href="{{ route('logout') }}"
         class="logout-button"
         title="Logout"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
      >
         <i class="fa-solid fa-arrow-right-from-bracket"></i>
         Logout
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">@csrf</form>
   </div>
</aside>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
