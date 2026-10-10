<?php
// Handle POST Request for Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Force output to JSON and capture errors
    header('Content-Type: application/json');
    ini_set('display_errors', 0); // Hide HTML error formatting
    error_reporting(E_ALL);

    // Custom error handler to catch PHP Warnings/Notices as JSON
    set_error_handler(function($severity, $message, $file, $line) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => "PHP Error: $message on line $line"
        ]);
        exit;
    });

    // Database configuration
 include  "includes/db_connect.php";

  

    // Capture input from JSON or standard POST
    $jsonInput = file_get_contents('php://input');
    $data = json_decode($jsonInput, true) ?? $_POST;

    // Extract and sanitize input
    $firstName = trim($data['firstName'] ?? '');
    $lastName  = trim($data['lastName'] ?? '');
    $email     = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $phone     = trim($data['phone'] ?? '') ?: null;
    $team      = trim($data['team'] ?? '');
    $message   = trim($data['message'] ?? '');

    // Validate required fields
    if (!$firstName || !$lastName || !$email || !$team || !$message) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields properly.']);
        exit;
    }

    // Insert into database
    try {
        $sql = "INSERT INTO contact_submissions (first_name, last_name, email, phone, team, message) 
                VALUES (:first_name, :last_name, :email, :phone, :team, :message)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':email'      => $email,
            ':phone'      => $phone,
            ':team'       => $team,
            ':message'    => $message
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Message sent successfully!',
            'id'      => $pdo->lastInsertId()
        ]);
    } catch (\PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'SQL Error: ' . $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - PURE GAIN</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue: '#1e40af',
                            'blue-hover': '#1d4ed8',
                            'blue-light': '#3b82f6',
                            sky: '#93c5fd',
                            bg: '#f8fafc',
                            card: '#ffffff',
                            panel: '#bfdbfe',
                            'panel-dark': '#1e3a8a'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        h1, h2, h3, .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        .input-focus-effect:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }
        .curved-top-right {
            border-top-right-radius: 4rem;
        }
        .curved-bottom-left {
            border-bottom-left-radius: 3rem;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between selection:bg-blue-500 selection:text-white">

    <!-- Main Content Container -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16 w-full flex-grow">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
            
            <!-- Left Column: Form Section -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Heading -->
                <div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-blue-900 leading-tight tracking-tight font-heading">
                        Contact<br>PURE GAIN<span class="text-blue-600">.</span>
                    </h1>
                    <p class="mt-4 text-slate-600 text-sm sm:text-base leading-relaxed">
                        If you ever need anything, do not hesitate to connect with us. Reaching PURE GAIN has never been easier. We are here to help with any questions or feedback.
                    </p>
                </div>

                <!-- Form Card -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50">
                    <form id="contactForm" onsubmit="handleFormSubmit(event)" class="space-y-5">
                        
                        <!-- Row 1: Email & Phone -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Email<span class="text-blue-600">*</span>
                                </label>
                                <input type="email" id="email" name="email" required placeholder="e.g. email@domain.com"
                                    class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl input-focus-effect transition-all duration-200 placeholder-slate-400">
                            </div>
                            <div>
                                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Phone Number
                                </label>
                                <input type="tel" id="phone" name="phone" placeholder="999-999-9999"
                                    class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl input-focus-effect transition-all duration-200 placeholder-slate-400">
                            </div>
                        </div>

                        <!-- Row 2: First Name & Last Name -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="firstName" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    First Name<span class="text-blue-600">*</span>
                                </label>
                                <input type="text" id="firstName" name="firstName" required placeholder="Your First Name"
                                    class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl input-focus-effect transition-all duration-200 placeholder-slate-400">
                            </div>
                            <div>
                                <label for="lastName" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Last Name<span class="text-blue-600">*</span>
                                </label>
                                <input type="text" id="lastName" name="lastName" required placeholder="Your Last Name"
                                    class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl input-focus-effect transition-all duration-200 placeholder-slate-400">
                            </div>
                        </div>

                        <!-- Row 3: Team to Contact -->
                        <div>
                            <label for="team" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Team to Contact<span class="text-blue-600">*</span>
                            </label>
                            <div class="relative">
                                <select id="team" name="team" required
                                    class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl input-focus-effect appearance-none transition-all duration-200 text-slate-700 pr-10">
                                    <option value="" disabled selected>Select Team</option>
                                    <option value="customer-support">Customer Support</option>
                                    <option value="corporate-sales">Corporate Gifts & Wholesale</option>
                                    <option value="press-media">Press & Media</option>
                                    <option value="general">General Inquiries</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-blue-600">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Row 4: Description -->
                        <div>
                            <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Description<span class="text-blue-600">*</span>
                            </label>
                            <textarea id="message" name="message" rows="4" required placeholder="Your Message"
                                class="w-full px-4 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl input-focus-effect transition-all duration-200 placeholder-slate-400 resize-none"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" id="submitBtn"
                                class="w-full sm:w-auto px-8 py-3.5 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm rounded-xl shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all duration-200 flex items-center justify-center gap-2 group">
                                <span>Send Message</span>
                                <i class="fa-solid fa-paper-plane text-xs transition-transform group-hover:translate-x-1"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Success Message Box -->
                    <div id="successBox" class="hidden mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl text-blue-900 text-sm flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-blue-600 text-lg"></i>
                        <div>
                            <p class="font-bold">Thank you for reaching out!</p>
                            <p class="text-xs text-blue-700">We've received your message and will get back to you shortly.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Visual Side Panel -->
            <div class="lg:col-span-5 w-full">
                <div class="rounded-3xl overflow-hidden shadow-2xl bg-white border border-slate-200/60">
                    
                    <div class="relative bg-amber-50 h-72 sm:h-80 overflow-hidden flex items-center justify-center border-b border-blue-100">
                        <img src="assets/images/logos.png" 
                             alt="PURE GAIN" 
                             class="w-full h-full object-cover object-center transform hover:scale-105 transition-transform duration-700"
                             onerror="this.src='https://placehold.co/800x600/bfdbfe/1e3a8a?text=PURE GAIN'">
                        
                        <div class="absolute top-0 right-0 bg-white w-16 h-16 curved-bottom-left flex items-center justify-center p-2">
                            <span class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700">
                                <i class="fa-solid fa-dumbbell"></i>
                            </span>
                        </div>
                    </div>

                    <div class="bg-blue-200/70 p-6 sm:p-8 curved-top-right text-slate-800 space-y-6 relative border-t border-blue-300/40">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h3 class="font-heading text-lg font-bold text-blue-950">Address</h3>
                                <p class="text-sm text-slate-700 mt-1 leading-relaxed">
                                    P. O. Box 976<br>
                                    Kampala, Uganda
                                </p>
                            </div>
                        </div>

                        <hr class="border-blue-300/60">

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h3 class="font-heading text-lg font-bold text-blue-950">Call Us</h3>
                                <p class="text-sm text-slate-800 font-semibold mt-1">
                                    Toll-Free: <a href="tel:8007672489" class="text-blue-900 hover:underline">800.767.2489*</a>
                                </p>
                                <p class="text-xs text-slate-600 mt-1">
                                    Monday through Friday 8am–8pm EAT
                                </p>
                            </div>
                        </div>

                        <div class="pt-2 flex items-center gap-3 text-blue-900">
                            <a href="#" class="w-9 h-9 rounded-lg bg-blue-300/50 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center text-sm">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-9 h-9 rounded-lg bg-blue-300/50 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center text-sm">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="#" class="w-9 h-9 rounded-lg bg-blue-300/50 hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center text-sm">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        async function handleFormSubmit(e) {
            e.preventDefault();
            const form = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');
            const successBox = document.getElementById('successBox');

            const payload = {
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                firstName: document.getElementById('firstName').value.trim(),
                lastName: document.getElementById('lastName').value.trim(),
                team: document.getElementById('team').value,
                message: document.getElementById('message').value.trim()
            };

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Sending...</span>';

            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    successBox.classList.remove('hidden');
                    form.reset();

                    setTimeout(() => {
                        successBox.classList.add('hidden');
                    }, 5000);
                } else {
                    alert(result.message || 'Validation error.');
                }
            } catch (err) {
                console.error(err);
                alert('An error occurred submitting the form. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `
                    <span>Send Message</span>
                    <i class="fa-solid fa-paper-plane text-xs transition-transform group-hover:translate-x-1"></i>
                `;
            }
        }
    </script>
</body>
</html>