@extends('supplier.layouts.master') 
@section('content')
<div class="app-layout">
    <main class="main-content">
        <div class="page-top">
            <div>
                <span class="page-eyebrow">OVERVIEW</span>
                <h1>Dashboard</h1>
                <p>Manage your products, bookings and supplier operations from one place.</p>
            </div>
            <div class="page-top-actions">
                <button class="top-action-btn secondary-btn">
                    <i class="fa-regular fa-calendar"></i>
                    <span>Today</span>
                </button>
                <button class="top-action-btn primary-btn">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add Product</span>
                </button>
            </div>
        </div>
        <section class="welcome-banner">
            <div class="welcome-content">
                <div class="welcome-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <span class="welcome-small"> WELCOME TO SPANEL </span>
                    <h2>{{ $greeting }}, {{ $supplier->name ?? 'Supplier' }}!</h2>
                    <p>Here's what's happening with your travel business today.</p>
                </div>
            </div>
            <div class="welcome-actions">
                <a href="{{ url('all-bookings')}}" class="welcome-link">
                View All Bookings
                <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </section>
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon booking-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <span class="stat-change positive">
                        <i class="fa-solid fa-arrow-up"></i>
                        {{ $todayBookings }}
                    </span>
                </div>
                <div class="stat-content">
                    <span class="stat-label"> Total Bookings </span>
                    <h3>{{ number_format($totalBookings) }}</h3>
                    <p>{{ number_format($todayBookings) }} new bookings today</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon tour-icon">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <span class="stat-change positive">
                        <i class="fa-solid fa-arrow-up"></i>

                        {{ $activeTours }}
                    </span>
                </div>
                <div class="stat-content">
                    <span class="stat-label"> Active Tours </span>
                    <h3>{{ number_format($activeTours) }}</h3>
                    <p>{{ number_format($activeTours) }} tour bookings</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon transfer-icon">
                        <i class="fa-solid fa-car-side"></i>
                    </div>
                    <span class="stat-change positive">
                        <i class="fa-solid fa-arrow-up"></i>
                        {{ $activeTransfers }}
                    </span>
                </div>
                <div class="stat-content">
                    <span class="stat-label"> Active Transfers </span>
                    <h3>{{ number_format($activeTransfers) }}</h3>
                    <p>{{ number_format($activeTransfers) }} transfer bookings</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon supplier-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <span class="stat-change neutral"> Active </span>
                </div>
                <div class="stat-content">
                    <span class="stat-label"> Sub Suppliers </span>
                    <h3>{{ number_format($subSuppliers) }}</h3>
                    <p>{{ number_format($activeSubSuppliers) }} currently active</p>
                </div>
            </div>
        </section>
        <section class="content-card quick-actions-card">
            <div class="section-header">
                <div>
                <h2>Quick Actions</h2>
                <p>Common actions for managing your supplier account.</p>
                </div>
            </div>
            <div class="quick-grid">
                <a href="#" class="quick-item">
                <div class="quick-icon orange">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <div>
                    <h3>Add Tour</h3>
                    <p>Create a new tour product</p>
                </div>
                <i class="fa-solid fa-chevron-right quick-arrow"></i>
                </a>
                <a href="#" class="quick-item">
                <div class="quick-icon blue">
                    <i class="fa-solid fa-car-side"></i>
                </div>
                <div>
                    <h3>Add Transfer</h3>
                    <p>Create a transfer service</p>
                </div>
                <i class="fa-solid fa-chevron-right quick-arrow"></i>
                </a>
                <a href="#" class="quick-item">
                <div class="quick-icon purple">
                    <i class="fa-solid fa-suitcase"></i>
                </div>
                <div>
                    <h3>Add Package</h3>

                    <p>Create a travel package</p>
                </div>
                <i class="fa-solid fa-chevron-right quick-arrow"></i>
                </a>
                <a href="#" class="quick-item">
                <div class="quick-icon green">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h3>Add Sub Supplier</h3>
                    <p>Create sub-supplier access</p>
                </div>
                <i class="fa-solid fa-chevron-right quick-arrow"></i>
                </a>
            </div>
        </section>
        <div class="dashboard-grid">
            <!--BOOKINGS-->
            <section class="content-card">
                <div class="section-header">
                <div>
                    <h2>Recent Bookings</h2>
                    <p>Latest booking activity.</p>
                </div>
                <a href="{{ url('all-bookings')}}" class="section-link">
                    View All
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                </div>
                <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Service</th>
                            <th>Guest</th>
                            <th>Travel Date</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                        @php $bookingType = strtolower( trim($booking->type ?? 'tour') ); 
                        if ($bookingType === 'transfer') { 
                            $serviceIcon = 'fa-car'; $serviceClass = 'transfer';
                        } elseif ($bookingType === 'package') { 
                            $serviceIcon = 'fa-suitcase'; $serviceClass = 'package'; 
                        } elseif ($bookingType === 'hotel') { 
                            $serviceIcon = 'fa-hotel'; $serviceClass = 'tour'; 
                        } else { $serviceIcon = 'fa-location-dot'; $serviceClass = 'tour'; 
                        } 
                        $bookingStatus = strtolower(trim($booking->status ?? 'pending') ); 
                        if ( str_contains($bookingStatus, 'confirm') ) {
                            $statusClass = 'confirmed'; $statusText = 'Confirmed'; 
                        } elseif ( str_contains($bookingStatus, 'cancel') ) {
                             $statusClass = 'cancelled'; $statusText = 'Cancelled'; 
                        } else { $statusClass = 'pending'; $statusText = 'Pending'; 
                        } $guestName = trim( ($booking->first_name ?? '') . ' ' .
                          ($booking->last_name ?? '') ); $guestName = $guestName ?: 'N/A';
                         @endphp
                        <tr>
                            <td>
                            <strong> #SLW{{ $booking->id }} </strong>
                            </td>
                            <td>
                            <div class="table-service">
                                <div class="service-icon {{ $serviceClass }}">
                                    <i class="fa-solid {{ $serviceIcon }}"></i>
                                </div>
                                <div>
                                    <strong> {{ $booking->item_name ?? 'N/A' }} </strong>
                                    <small> {{ ucfirst($booking->type ?? 'Tour') }} </small>
                                </div>
                            </div>
                            </td>
                            <td>{{ $guestName }}</td>
                            <td>
                            @if($booking->start_date) {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                            @else N/A @endif
                            </td>
                            <td>
                            <span class="status {{ $statusClass }}"> {{ $statusText }} </span>
                            </td>
                            <td>
                            <button class="table-action" type="button">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </section>
            <!-- RIGHT PANEL -->
            <div class="dashboard-side">
                <!-- PRODUCT SUMMARY -->
                <section class="content-card">
                <div class="section-header">
                    <div>
                        <h2>Product Summary</h2>
                        <p>Published product overview.</p>
                    </div>
                </div>
                <div class="product-list">
                    <div class="product-row">
                        <div class="product-left">
                            <div class="product-icon orange">
                            <i class="fa-solid fa-map"></i>
                            </div>
                            <div>
                            <strong>Tours</strong>

                            <span>Active Products</span>
                            </div>
                        </div>
                        <b> {{ number_format($activeTours) }} </b>
                    </div>
                    <div class="product-row">
                        <div class="product-left">
                            <div class="product-icon blue">
                            <i class="fa-solid fa-car-side"></i>
                            </div>
                            <div>
                            <strong>Transfers</strong>
                            <span>Active Products</span>
                            </div>
                        </div>
                        <b> {{ number_format($activeTransfers) }} </b>
                    </div>
                    <div class="product-row">
                        <div class="product-left">
                            <div class="product-icon purple">
                            <i class="fa-solid fa-suitcase"></i>
                            </div>
                            <div>
                            <strong>Packages</strong>
                            <span>Active Products</span>
                            </div>
                        </div>
                        <b> {{ number_format($packageCount) }} </b>
                    </div>
                    <div class="product-row">
                        <div class="product-left">
                            <div class="product-icon green">
                            <i class="fa-solid fa-hotel"></i>
                            </div>
                            <div>
                            <strong>Hotels</strong>
                            <span>Active Products</span>
                            </div>
                        </div>
                        <b> {{ number_format($hotelCount) }} </b>
                    </div>
                </div>
                </section>
                <!-- ALERT -->
                <section class="attention-card">
                <div class="attention-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <h3>Needs Your Attention</h3>
                    <p>{{ number_format($pendingBookings) }} bookings are waiting for confirmation.</p>
                    <a href="{{ url('all-bookings')}}">
                        Review Bookings
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                </section>
            </div>
        </div>
        <section class="content-card activity-card">
            <div class="section-header">
                <div>
                <h2>Recent Activity</h2>
                <p>Latest updates from your supplier account.</p>
                </div>
            </div>
            <div class="activity-list">
                @forelse($recentActivity as $activity) 
                @php $activityStatus = strtoupper( trim($activity->status ?? '') );
                    if ($activityStatus === 'CONFIRMED') { 
                        $activityTitle = 'Booking confirmed'; $activityIcon = 'fa-calendar-check'; $activityColor = 'green'; 
                    } elseif ( str_contains($activityStatus, 'CANCEL') ) {
                        $activityTitle = 'Booking cancelled'; $activityIcon = 'fa-circle-xmark'; $activityColor = 'orange'; 
                    } else {
                    $activityTitle = 'Booking updated'; $activityIcon = 'fa-pen'; $activityColor = 'blue'; 
                    }
                @endphp
                <div class="activity-item">
                <div class="activity-line"></div>
                <div class="activity-icon {{ $activityColor }}">
                    <i class="fa-solid {{ $activityIcon }}"></i>
                </div>
                <div class="activity-content">
                    <strong> {{ $activityTitle }} </strong>
                    <p>Booking #SLW{{ $activity->id }} {{ $activity->item_name ? ' - ' . $activity->item_name : '' }}</p>
                    <span>
                        @if($activity->date) {{ \Carbon\Carbon::parse($activity->date)->diffForHumans() }} @else Recently
                        @endif
                    </span>
                </div>
                </div>
                @empty
                <div class="activity-item">
                <div class="activity-icon blue">
                    <i class="fa-solid fa-info-circle"></i>
                </div>
                <div class="activity-content">
                    <strong> No recent activity </strong>
                    <p>No recent booking activity found.</p>
                    <span> Just now </span>
                </div>
                </div>

                @endforelse
            </div>
        </section>
    </main>
</div>
@endsection
