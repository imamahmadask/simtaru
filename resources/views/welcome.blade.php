<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMTARU</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('landing/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <header class="container-fluid py-3">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand fw-bold fs-3 text-primary" href="/">
                    <img src="{{ asset('assets/img/favicon/favicon.ico') }}" alt="SIMTARU Logo" class="d-inline-block"
                        width="30">
                    SIMTARU
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#testimonials">Testimonials</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#pricing">Pricing</a>
                        </li>
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item ms-3">
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                                </li>
                            @else
                                <li class="nav-item ms-3">
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item ms-3">
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section py-5">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary-subtle text-primary-emphasis mb-4">✨ New features available now</span>
                    <h1 class="display-2 fw-bold text-dark mb-4">Unlock Your Potential Today</h1>
                    <p class="lead text-muted mb-5">
                        Join a community of innovators and transform your ideas into reality. Explore our resources and
                        connect with like-minded individuals.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5">
                        <button class="btn btn-primary btn-lg px-4">Get Started</button>
                        <button class="btn btn-outline-secondary btn-lg px-4">Watch Demo</button>
                    </div>
                    <div
                        class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-4 text-muted small">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex">
                                <div class="avatar bg-primary-subtle"></div>
                                <div class="avatar bg-info-subtle"></div>
                                <div class="avatar bg-success-subtle"></div>
                            </div>
                            <span>10,000+ happy users</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-star-fill text-primary"></i>
                            <i class="bi bi-star-fill text-primary"></i>
                            <i class="bi bi-star-fill text-primary"></i>
                            <i class="bi bi-star-fill text-primary"></i>
                            <i class="bi bi-star-fill text-primary"></i>
                            <span class="ms-1">4.9/5 rating</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold text-dark mb-4">Everything you need to succeed</h2>
                    <p class="lead text-muted">
                        Powerful tools and features designed to help you achieve your goals faster than ever before.
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary-subtle text-primary mb-4 mx-auto">
                                <i class="bi bi-lightning-fill"></i>
                            </div>
                            <h3 class="h5 fw-semibold text-dark mb-3">Lightning Fast</h3>
                            <p class="text-muted">
                                Experience blazing fast performance with our optimized infrastructure and cutting-edge
                                technology.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-info-subtle text-info mb-4 mx-auto">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h3 class="h5 fw-semibold text-dark mb-3">Secure & Reliable</h3>
                            <p class="text-muted">
                                Your data is protected with enterprise-grade security and 99.9% uptime guarantee.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg feature-card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-success-subtle text-success mb-4 mx-auto">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h3 class="h5 fw-semibold text-dark mb-3">Team Collaboration</h3>
                            <p class="text-muted">
                                Work seamlessly with your team using our advanced collaboration tools and real-time
                                sync.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold text-dark mb-4">Loved by thousands of users</h2>
                    <p class="lead text-muted">See what our community has to say about their experience.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                            </div>
                            <p class="text-muted mb-4">"This platform has completely transformed how our team
                                collaborates. The results speak for themselves."</p>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-danger-subtle me-3"></div>
                                <div>
                                    <div class="fw-semibold text-dark">Sarah Johnson</div>
                                    <small class="text-muted">Product Manager</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                            </div>
                            <p class="text-muted mb-4">"I've tried many solutions, but nothing comes close to the
                                simplicity and power of this platform."</p>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-info-subtle me-3"></div>
                                <div>
                                    <div class="fw-semibold text-dark">Michael Chen</div>
                                    <small class="text-muted">Startup Founder</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                                <i class="bi bi-star-fill text-primary"></i>
                            </div>
                            <p class="text-muted mb-4">"The user experience is incredible. It's intuitive, fast, and
                                exactly what I needed for my projects."</p>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-success-subtle me-3"></div>
                                <div>
                                    <div class="fw-semibold text-dark">Emily Rodriguez</div>
                                    <small class="text-muted">Designer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold text-dark mb-4">Ready to get started?</h2>
                    <p class="lead text-muted mb-5">
                        Join thousands of users who have already transformed their workflow. Start your free trial
                        today, no credit card required.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <button class="btn btn-primary btn-lg px-4">Start Free Trial</button>
                        <button class="btn btn-outline-secondary btn-lg px-4">Contact Sales</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <h5 class="text-primary mb-3">YourBrand</h5>
                    <p class="text-light">
                        Empowering innovators to transform ideas into reality through cutting-edge tools and community.
                    </p>
                </div>
                <div class="col-md-6 col-lg-3">
                    <h6 class="mb-3">Product</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none hover-white">Features</a></li>
                        <li><a href="#" class="text-light text-decoration-none hover-white">Pricing</a></li>
                        <li><a href="#" class="text-light text-decoration-none hover-white">API</a></li>
                        <li><a href="#" class="text-light text-decoration-none hover-white">Documentation</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-3">
                    <h6 class="mb-3">Company</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none hover-white">About</a></li>
                        <li><a href="#" class="text-light text-decoration-none hover-white">Blog</a></li>
                        <li><a href="#" class="text-light text-decoration-none hover-white">Careers</a></li>
                        <li><a href="#" class="text-light text-decoration-none hover-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-3">
                    <h6 class="mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none hover-white">Help Center</a></li>
                        <li><a href="#" class="text-light text-decoration-none hover-white">Community</a></li>
                        <li><a href="#" class="text-light text-decoration-none hover-white">Status</a></li>
                        <li><a href="#" class="text-light text-decoration-none hover-white">Privacy</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-light">
                <p>&copy; 2024 YourBrand. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
