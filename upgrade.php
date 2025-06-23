<?php
session_start();
require("include/db.php");

if(!isset($_SESSION['username'])){
    header("location: login.php");
    exit;
}

// Check if already premium
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT is_premium FROM users WHERE id = ".$_SESSION['user_id']));
if($user['is_premium']) {
    header("location: skills.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upgrade to Premium</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #fefde5;
            color: #333;
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px;
        }

        .upgrade-container {
            display: flex;
            width: 90%;
            max-width: 1000px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .upgrade-info, .upgrade-payment {
            padding: 40px;
            flex: 1;
        }

        .upgrade-info {
            background: linear-gradient(135deg, #1a8e5f, #f5c518);
            color: white;
        }

        .upgrade-info h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .upgrade-info p {
            font-size: 16px;
            margin-top: 10px;
        }

        .price-display {
            font-size: 48px;
            font-weight: bold;
            margin: 20px 0;
        }

        .price-display span {
            font-size: 16px;
            font-weight: normal;
        }

        .benefits-list {
            margin-top: 20px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .benefit-icon {
            margin-right: 10px;
            font-weight: bold;
            font-size: 18px;
        }

        .upgrade-payment {
            background-color: #fff;
            color: #333;
            border-left: 1px solid #eee;
        }

        .upgrade-payment h3 {
            margin-bottom: 10px;
        }

        .upgrade-payment p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        #payment-form {
            display: flex;
            flex-direction: column;
        }

        #payment-element {
            margin-bottom: 20px;
        }

        button#submit {
            padding: 12px 20px;
            background-color: #f5c518;
            border: none;
            color: #000;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        button#submit:hover {
            background-color: #e0b000;
        }

        .loading-spinner {
            display: none;
            margin-left: 10px;
            width: 16px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #1a8e5f;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<div class="main-content">
    <div class="upgrade-container">
        <!-- Left Column - Benefits Info -->
        <div class="upgrade-info">
            <h2>Upgrade to Premium</h2>
            <p>Get full access to all our exclusive content and features</p>
            
            <div class="price-display">₹200<span style="font-size: 16px;">/for each skill</span></div>
            
            <div class="benefits-list">
                <div class="benefit-item">
                    <span class="benefit-icon">✓</span>
                    <span>Unlimited video access</span>
                </div>
                <div class="benefit-item">
                    <span class="benefit-icon">✓</span>
                    <span>HD quality streaming</span>
                </div>
                <div class="benefit-item">
                    <span class="benefit-icon">✓</span>
                    <span>Download videos for offline viewing</span>
                </div>
                <div class="benefit-item">
                    <span class="benefit-icon">✓</span>
                    <span>Priority customer support</span>
                </div>
                <div class="benefit-item">
                    <span class="benefit-icon">✓</span>
                    <span>Cancel anytime</span>
                </div>
            </div>
            
            <p>Join thousands of satisfied members who upgraded their learning experience</p>
        </div>
        
        <!-- Right Column - Payment Form -->
        <div class="upgrade-payment">
            <h3>Payment Information</h3>
            <p>Secure payment processed by Stripe</p>
            
            <form id="payment-form">
                <div id="payment-element"></div>
                <button id="submit">
                    <span id="button-text">Upgrade Now</span>
                    <span id="spinner" class="loading-spinner"></span>
                </button>
                <div id="payment-message"></div>
            </form>
            
            <a href="skills.php" class="back-link">← Back to Skills</a>
        </div>
    </div>
</div>

<script>
    const stripe = Stripe('<?php echo getenv('STRIPE_PUBLIC_KEY'); ?>');

    const elements = stripe.elements({
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#1a8e5f',
                colorBackground: '#fefde5',
            }
        }
    });

    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        document.getElementById('submit').disabled = true;
        document.getElementById('spinner').style.display = 'inline-block';
        document.getElementById('button-text').textContent = 'Processing...';

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: window.location.origin + '/upgrade_success.php',
            }
        });

        if (error) {
            document.getElementById('payment-message').textContent = error.message;
            document.getElementById('submit').disabled = false;
            document.getElementById('spinner').style.display = 'none';
            document.getElementById('button-text').textContent = 'Upgrade Now';
        }
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('payment_error')) {
        document.getElementById('payment-message').textContent = 
            'Payment failed. Please try again or contact support.';
    }
</script>

</body>
</html>
