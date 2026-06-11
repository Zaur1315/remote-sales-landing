<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classic American Sales | Agricultural Equipment & Vehicle Sales</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Remote phone sales opportunity for experienced agricultural equipment and vehicle sales specialists. Work from home. Paid in USDT.">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('/site.webmanifest')}}">

    @if(config('meta.pixel_enabled') && config('meta.pixel_id'))
        <script>
            window.metaPixelId = @json(config('meta.pixel_id'));

            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', window.metaPixelId);
            fbq('track', 'PageView');
        </script>

        <noscript>
            <img
                height="1"
                width="1"
                style="display:none"
                src="https://www.facebook.com/tr?id={{ config('meta.pixel_id') }}&ev=PageView&noscript=1"
                alt=""
            />
        </noscript>
    @endif

    @vite([
        'resources/css/remote-sales.css',
        'resources/js/remote-sales.js',
    ])
</head>
<body>
<div class="site-shell">
    <div class="noise-layer"></div>
    <div class="gradient-orb gradient-orb-one"></div>
    <div class="gradient-orb gradient-orb-two"></div>
    <div class="gradient-orb gradient-orb-three"></div>

    <header class="site-header" data-glass-header>
        <div class="container header-inner">
            <a href="#top" class="brand" aria-label="Classic American Sales">
                <span class="brand-mark">
                    <img src="{{asset('/images/logo.png')}}" alt="logo">
                </span>
                <span class="brand-text">
                        <span>Classic American Sales</span>
                        <small>U.S. Equipment Market</small>
                    </span>
            </a>

            <nav class="desktop-nav" aria-label="Main navigation">
                <a href="#role">Role</a>
                <a href="#requirements">Requirements</a>
                <a href="#apply">Apply</a>
            </nav>

            <a href="#apply" class="header-cta">Apply Now</a>
        </div>
    </header>

    <main id="top">
        <section class="hero section-large">
            <div class="container hero-grid">
                <div class="hero-content">
                    <div class="eyebrow reveal">
                        <span></span>
                        Remote phone sales opportunity
                    </div>

                    <h1 class="hero-title reveal">
                        Sell agricultural equipment and vehicles to U.S. buyers.
                        <span>From home. Paid in USDT.</span>
                    </h1>

                    <p class="hero-subtitle reveal">
                        We're looking for top-tier salesmen to join our team! Do you know English and know how to
                        close deals over the phone? Then you're the person we're looking for!
                        Work safely from home. Payments of <b>$2,000–$7,000 in USDT</b>.
                    </p>

                    <div class="hero-actions reveal">
                        <a href="#apply" class="btn btn-primary">
                            Apply Now
                            <span>→</span>
                        </a>

                        <a href="#role" class="btn btn-secondary">
                            View Role Details
                        </a>
                    </div>

                    <div class="hero-stats reveal">
                        <div>
                            <strong>Remote</strong>
                            <span>No office required</span>
                        </div>
                        <div>
                            <strong>USDT</strong>
                            <span>$2,000 – $7,000 salary</span>
                        </div>
                        <div>
                            <strong>9AM–5PM CST</strong>
                            <span>Monday – Friday</span>
                        </div>
                    </div>
                </div>

                <div class="hero-visual reveal">
                    <div class="image-card main-image-card">
                        <img src="{{ asset('images/hero.webp') }}" alt="Agricultural equipment on an American field">
                    </div>

                    <div class="floating-card floating-card-top">
                        <span class="status-dot"></span>
                        Experienced sellers only
                    </div>

                    <div class="floating-card floating-card-bottom">
                        <strong>Commission based</strong>
                        <span>Your performance drives your income</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="role" class="section-spacious role-section">
            <div class="container">
                <div class="section-heading reveal">
                    <span class="section-kicker">The role</span>
                    <h2>This is not an entry-level script-reading position.</h2>
                    <p>
                        We’re not looking for people who just follow scripts. We need a strong salesperson who’s ready
                        to sell, grow, and develop professionally.
                    </p>
                </div>

                <div class="feature-grid">
                    <article class="feature-card reveal">
                        <div class="feature-icon">🇺🇸</div>
                        <h3>We work with the U.S. market.</h3>
                        <p>
                            You will communicate with buyers across the United States and help connect them
                            with agricultural equipment and vehicle dealers.
                        </p>
                    </article>

                    <article class="feature-card reveal">
                        <div class="feature-icon">🏠</div>
                        <h3>Work safely from home.</h3>
                        <p>
                            No office and no commute. You can work remotely from a quiet place with your own
                            computer, stable internet connection, and a professional calling setup.
                        </p>
                    </article>

                    <article class="feature-card reveal">
                        <div class="feature-icon">💵</div>
                        <h3>We pay competitive commissions</h3>
                        <p>
                            This is a performance-based role with commission opportunities for strong salespeople
                            who can manage conversations, follow up consistently, and close deals.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section-spacious split-section">
            <div class="container split-grid">
                <div class="split-media reveal">
                    <div class="wide-image-card">
                        <img src="{{ asset('images/dealership.webp') }}" alt="American dealership and pickup truck">
                    </div>
                </div>

                <div class="split-content reveal">
                    <span class="section-kicker">Who this is for</span>
                    <h2>Built for salespeople who already know the work.</h2>
                    <p>
                        This page is intentionally direct. We do not need to explain what follow-up calls,
                        objections, no-shows, price pressure, or buyer hesitation are. You have seen it before.
                    </p>

                    <div class="timeline">
                        <div class="timeline-item">
                            <span>01</span>
                            <div>
                                <h3>Apply with your Telegram</h3>
                                <p>Send your English level and a short summary of your sales background.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <span>02</span>
                            <div>
                                <h3>We review your experience</h3>
                                <p>Relevant remote phone sales experience matters more than a long resume.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <span>03</span>
                            <div>
                                <h3>We contact selected applicants</h3>
                                <p>If there is a fit, communication continues directly through Telegram.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="requirements" class="section-spacious requirements-section">
            <div class="container">
                <div class="section-heading reveal">
                    <span class="section-kicker">Requirements</span>
                    <h2>Clear expectations before you apply.</h2>
                    <p>
                        This position requires strong spoken English, serious availability, and previous sales
                        experience.
                    </p>
                </div>

                <div class="requirements-grid">
                    <article class="requirement-card reveal">
                        <span>01</span>
                        <h3>English C1 or higher</h3>
                        <p>
                            You must be confident, clear, and natural during phone conversations with U.S. buyers.
                        </p>
                    </article>

                    <article class="requirement-card reveal">
                        <span>02</span>
                        <h3>Sales experience required</h3>
                        <p>
                            Remote phone sales experience is required. Equipment, vehicles, or similar product sales are
                            preferred.
                        </p>
                    </article>

                    <article class="requirement-card reveal">
                        <span>03</span>
                        <h3>Monday–Friday availability</h3>
                        <p>
                            You need to be available at least 8 hours per day, Monday through Friday.
                        </p>
                    </article>

                    <article class="requirement-card reveal">
                        <span>04</span>
                        <h3>Reliable workspace</h3>
                        <p>
                            Own PC or laptop, stable internet connection, and a quiet place to handle calls
                            professionally.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="apply" class="section-spacious application-section">
            <div class="container application-grid">
                <div class="application-copy reveal">
                    <span class="section-kicker">Application</span>
                    <h2>Ready to apply?</h2>
                    <p>
                        Keep it short and specific. We care about what you sold, how long you worked in sales,
                        and whether you are comfortable speaking with U.S. buyers by phone.
                    </p>

                    <div class="application-note">
                        <strong>Before submitting:</strong>
                        <span>
                                Make sure your Telegram username is correct. If your profile cannot be found,
                                we may not be able to contact you.
                            </span>
                    </div>
                </div>

                <div class="form-card reveal">
                    <div class="form-card-header">
                        <div>
                            <span>Apply now</span>
                            <h3>Classic American Sales Application</h3>
                        </div>
                    </div>

                    <div class="form-alert form-alert-success" data-form-success hidden></div>
                    <div class="form-alert form-alert-error" data-form-error hidden></div>

                    <form
                        method="POST"
                        action="{{ route('remote-sales.store') }}"
                        class="application-form"
                        data-application-form
                        novalidate
                    >
                        @csrf

                        <div class="field-group">
                            <label for="telegram_username">Telegram Username *</label>
                            <input
                                id="telegram_username"
                                type="text"
                                name="telegram_username"
                                value="{{ old('telegram_username') }}"
                                placeholder="@username"
                                autocomplete="off"
                                inputmode="text"
                                pattern="^@?[A-Za-z0-9_]+$"
                                maxlength="100"
                                required
                            >
                            <div class="field-error" data-error-for="telegram_username"></div>
                        </div>

                        <div class="field-group">
                            <label for="english_level">English Level *</label>
                            <select id="english_level" name="english_level" required>
                                <option value="">Select your English level</option>

                                @foreach($englishLevels as $englishLevel)
                                    <option
                                        value="{{ $englishLevel }}"
                                        @selected(old('english_level') === $englishLevel)
                                    >
                                        {{ $englishLevel }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="field-error" data-error-for="english_level"></div>
                        </div>

                        <div class="field-group">
                            <label for="sales_experience">Sales Experience *</label>
                            <textarea
                                id="sales_experience"
                                name="sales_experience"
                                placeholder="Briefly describe your experience — what you sold, how long you worked in sales, and when."
                                required
                            >{{ old('sales_experience') }}</textarea>
                            <div class="field-error" data-error-for="sales_experience"></div>
                        </div>

                        <button type="submit" class="submit-button" data-submit-button>
                            <span data-submit-text>Submit Application</span>
                            <span class="button-loader" data-submit-loader hidden></span>
                        </button>

                        <p class="form-footnote">
                            By submitting, you confirm that your information is accurate and that you are available
                            for remote sales work.
                        </p>
                    </form>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>
