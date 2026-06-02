<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Remote Sales Jobs | Agricultural Equipment & Vehicles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #101412;
            color: #f8f5ed;
        }

        .hero {
            padding: 80px 20px;
            background: linear-gradient(135deg, #123524, #1f2a24);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .hero h1 {
            max-width: 850px;
            margin: 0 0 20px;
            font-size: 52px;
            line-height: 1.05;
            color: #f3c76a;
        }

        .hero p {
            max-width: 720px;
            font-size: 20px;
            line-height: 1.6;
            color: #e6e0d1;
        }

        .button {
            display: inline-block;
            margin-top: 28px;
            padding: 16px 28px;
            border-radius: 999px;
            background: #b83226;
            color: #ffffff;
            font-weight: 700;
            text-decoration: none;
        }

        .section {
            padding: 60px 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
        }

        .card {
            padding: 28px;
            border-radius: 20px;
            background: #1c231f;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .card h2 {
            margin-top: 0;
            color: #f3c76a;
        }

        .card p,
        .card li {
            color: #ded8c8;
            line-height: 1.6;
        }

        .form-section {
            background: #171c19;
        }

        .form {
            max-width: 720px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
        }

        input,
        select,
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid #3a443d;
            background: #0f1311;
            color: #ffffff;
            font-size: 16px;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .error {
            margin-top: 6px;
            color: #ff9a8f;
            font-size: 14px;
        }

        .success {
            margin-bottom: 24px;
            padding: 16px 18px;
            border-radius: 12px;
            background: rgba(46, 125, 50, 0.2);
            border: 1px solid rgba(76, 175, 80, 0.5);
            color: #b9f6ca;
        }

        .submit {
            border: 0;
            cursor: pointer;
            padding: 16px 28px;
            border-radius: 999px;
            background: #b83226;
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 56px 20px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 18px;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<section class="hero">
    <div class="container">
        <h1>Sell Agricultural Equipment and Vehicles to U.S. Buyers. From Home. Paid in USDT.</h1>

        <p>
            We are looking for experienced remote phone sales specialists who can speak confidently
            with buyers in the United States. This is a commission-based remote role with USDT payments.
        </p>

        <a href="#apply" class="button">Apply Now</a>
    </div>
</section>

<section class="section">
    <div class="container grid">
        <div class="card">
            <h2>What This Role Is</h2>

            <p>
                You will contact U.S. buyers by phone on behalf of agricultural equipment and vehicle dealers.
                This role is for people who already understand remote sales, follow-ups, objections, and closing.
            </p>

            <p>
                No office. No commute. Work from home with your own computer, stable internet connection,
                and a quiet place to make calls.
            </p>
        </div>

        <div class="card">
            <h2>Requirements</h2>

            <ul>
                <li>English level C1, C2, or Native</li>
                <li>Experience in remote phone sales</li>
                <li>Experience selling agricultural equipment, vehicles, or similar products is preferred</li>
                <li>Available Monday–Friday, at least 8 hours per day</li>
                <li>Own PC or laptop, stable internet, and a quiet workspace</li>
            </ul>
        </div>
    </div>
</section>

<section id="apply" class="section form-section">
    <div class="container">
        <div class="form">
            <h2>Apply Now</h2>

            @if(session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('remote-sales.store') }}">
                @csrf

                <div class="field">
                    <label for="telegram_username">Telegram Username *</label>
                    <input
                        id="telegram_username"
                        type="text"
                        name="telegram_username"
                        value="{{ old('telegram_username') }}"
                        placeholder="@username"
                        required
                    >

                    @error('telegram_username')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
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

                    @error('english_level')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="sales_experience">Sales Experience *</label>
                    <textarea
                        id="sales_experience"
                        name="sales_experience"
                        placeholder="Briefly describe your experience — what you sold, how long you worked in sales, and when."
                        required
                    >{{ old('sales_experience') }}</textarea>

                    @error('sales_experience')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit">
                    Submit Application
                </button>
            </form>
        </div>
    </div>
</section>
</body>
</html>
