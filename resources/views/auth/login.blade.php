<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spanel Login | Sun Leisure World</title>
<link rel="icon" type="image/png" href="{{ asset('public/assets/images/logo.png') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('public/assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('public/assets/css/login.css') }}">
</head>
<body>
<div class="login-page">
    <!--LEFT PANEL-->
    <section class="login-left">
        <div class="left-pattern"></div>
        <div class="brand-area">
            <div class="logo-box">
                <img src="https://i.ibb.co/n8t2WZwR/logo-sun.png" alt="Sun Leisure World">
            </div>
            <div class="portal-tag">
                SPANEL SUPPLIER PORTAL
            </div>
            <h1>
                Manage your travel business
                <span>from one place.</span>
            </h1>
            <p class="brand-description">
                Manage tours, transfers, packages, bookings, suppliers,
                sub-suppliers and operational updates from one secure dashboard.
            </p>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>

                    <div>
                        <h3>Manage Products</h3>
                        <p>Tours, transfers, packages and hotels.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3>Manage Bookings</h3>
                        <p>View, update and manage bookings easily.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <div>
                        <h3>Manage Suppliers</h3>
                        <p>Suppliers, sub-suppliers and guide access.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="left-footer">
            <span>© 2026 Sun Leisure World</span>
            <span class="footer-dot"></span>
            <span>Supplier Management System</span>
        </div>
    </section>
    <!--RIGHT PANEL-->
    <section class="login-right">
        <div class="login-wrapper">
            <div class="mobile-logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Sun Leisure World">
            </div>
            <div class="login-heading">
                <span class="small-title">WELCOME BACK</span>
                <h2>Sign in to Spanel</h2>
                <p>
                    Enter your login details to access your supplier dashboard.
                </p>
            </div>
            <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
            @csrf
                <!--EMAIL-->
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-box">
                        <span class="input-icon">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                       <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email address"
                        required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!--PASSWORD-->
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-box">
                        <span class="input-icon">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                       <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required>
                        <button
                            class="password-toggle"
                            type="button"
                            id="passwordToggle">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        @error('password')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <!--ACCOUNT TYPE-->
                <div class="form-group">
                    <label>Account Type</label>
                    <div class="input-box">
                        <span class="input-icon">
                            <i class="fa-solid fa-user-gear"></i>
                        </span>
                        <select id="accountType" name="account_type" required>
                            <option value="">
                                Select account type
                            </option>
                            <option value="supplier">
                                Supplier
                            </option>
                            <option value="subsupplier">
                                Sub Supplier
                            </option>
                        </select>
                        <span class="select-arrow">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                    @error('account_type')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <!--OPTIONS-->
                <div class="login-options">
                    <label class="remember-me">
                        <input type="checkbox">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-link">
                        Forgot password?
                    </a>
                </div>
                <!--LOGIN BUTTON-->
                <button
                    type="submit"
                    class="login-btn">
                    <span>Sign In</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
            <div class="security-line">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Secure supplier portal</span>
                <span class="security-dot"></span>
                <span>Sun Leisure World</span>
            </div>
            <div class="support-box">
                <div class="support-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div class="support-content">
                    <strong>Need help signing in?</strong>
                    <p>
                        Contact Sun Leisure World technical support.
                    </p>
                </div>
                <a href="#">
                    Contact Support
                </a>
            </div>
        </div>
    </section>
</div>
<script src="{{ asset('public/assets/js/login.js') }}"></script>
</body>
</html>