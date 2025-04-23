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
    <link rel="stylesheet" type="text/css" href="css.css">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
    .upgrade-container {
    display: flex;
    max-width: 1000px;
    margin: 30px auto;
    background: var(--card-bg);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    animation: fadeIn 0.8s ease forwards;
    border-left: 4px solid var(--accent1);
}

.upgrade-info {
    flex: 1;
    padding: 40px;
    background: linear-gradient(135deg, var(--sidebar), #333333);
    color: var(--text-light);
}

.upgrade-payment {
    flex: 1;
    padding: 40px;
    background: var(--card-bg);
}

.upgrade-info h2 {
    font-size: 28px;
    margin-bottom: 15px;
    color: var(--primary);
    position: relative;
    padding-bottom: 10px;
}

.upgrade-info h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: var(--secondary);
    border-radius: 10px;
}

.upgrade-info p {
    font-size: 16px;
    line-height: 1.6;
    opacity: 0.9;
}

.price-display {
    font-size: 42px;
    font-weight: 700;
    margin: 25px 0;
    color: var(--primary);
}

.price-display span {
    font-size: 18px;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.8);
}

.benefits-list {
    margin: 30px 0;
}

.benefit-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding: 12px 15px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.benefit-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(5px);
}

.benefit-icon {
    margin-right: 15px;
    font-size: 20px;
    color: var(--secondary);
    width: 30px;
    height: 30px;
    background: rgba(50, 205, 50, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upgrade-payment h3 {
    font-size: 24px;
    margin-bottom: 15px;
    color: var(--text-dark);
    position: relative;
    padding-bottom: 10px;
}

.upgrade-payment h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: var(--primary);
    border-radius: 10px;
}

.upgrade-payment p {
    font-size: 16px;
    color: #777;
    margin-bottom: 25px;
}

#payment-form {
    margin-top: 20px;
}

#payment-element {
    margin-bottom: 20px;
    padding: 15px;
    background: var(--yellow-light);
    border-radius: 10px;
    border: 2px solid #e0e0e0;
}

#payment-element:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 5px rgba(255, 209, 0, 0.2);
}

#submit {
    background: linear-gradient(135deg, var(--secondary), var(--green-dark));
    color: white;
    border: none;
    padding: 15px;
    font-size: 16px;
    border-radius: 50px;
    cursor: pointer;
    width: 100%;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 15px rgba(50, 205, 50, 0.3);
    position: relative;
    overflow: hidden;
}

#submit:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(50, 205, 50, 0.4);
}

#submit::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, rgba(255,255,255,0.1), transparent);
    transition: all 0.5s ease;
}

#submit:hover::before {
    left: 100%;
}

.back-link {
    display: inline-block;
    margin-top: 25px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    padding: 8px 15px;
    border-radius: 5px;
}

.back-link:hover {
    color: var(--sidebar);
    background: var(--primary);
    transform: translateX(-5px);
}

#payment-message {
    color: #e74c3c;
    margin-top: 15px;
    text-align: center;
    padding: 12px;
    background: #fdecea;
    border-radius: 8px;
    border-left: 4px solid #e74c3c;
    animation: fadeIn 0.5s ease;
}

.loading-spinner {
    display: none;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
    margin-left: 10px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .upgrade-container {
        flex-direction: column;
        margin: 15px;
    }
    
    .upgrade-info, .upgrade-payment {
        padding: 25px;
    }
    
    .price-display {
        font-size: 36px;
        margin: 20px 0;
    }
}

@media (max-width: 480px) {
    .upgrade-info h2, .upgrade-payment h3 {
        font-size: 24px;
    }
    
    .benefit-item {
        padding: 10px;
        font-size: 14px;
    }
    
    #submit {
        padding: 12px;
    }
}
        .price-display {
            font-size: 36px;
            font-weight: bold;
            margin: 20px 0;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #6e8efb;
            text-decoration: none;
        }
        #payment-message {
            color: #e74c3c;
            margin-top: 15px;
            text-align: center;
        }
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="upgrade-container">
        <!-- Left Column - Benefits Info -->
        <div class="upgrade-info">
            <h2>Upgrade to Premium</h2>
            <p>Get full access to all our exclusive content and features</p>
            
            <div class="price-display">₹200<span style="font-size: 16px;">/month</span></div>
            
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
    
    // Initialize Stripe Elements
    const elements = stripe.elements({
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#6e8efb',
                colorBackground: '#f9f9f9',
            }
        }
    });
    
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');
    
    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        
        // Show loading state
        document.getElementById('submit').disabled = true;
        document.getElementById('spinner').style.display = 'inline-block';
        document.getElementById('button-text').textContent = 'Processing...';
        
        // Confirm payment
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
    
    // Check for payment status in URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('payment_error')) {
        document.getElementById('payment-message').textContent = 
            'Payment failed. Please try again or contact support.';
    }
</script>

</body>
</html>